<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InventoryMovement;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        return view('admin.reports.index');
    }

    public function sales(Request $request)
    {
        $dateFrom = $request->input('date_from', now()->startOfMonth()->toDateString());
        $dateTo = $request->input('date_to', now()->endOfMonth()->toDateString());
        $period = $request->input('period', 'daily');

        $query = Transaction::where('status', 'completed')
                            ->whereDate('created_at', '>=', $dateFrom)
                            ->whereDate('created_at', '<=', $dateTo);

        if ($period === 'monthly') {
            $sales = $query->select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as date'),
                DB::raw('SUM(total_amount) as total_sales'),
                DB::raw('COUNT(id) as transactions_count')
            )->groupBy('date')->orderBy('date')->get();
        } elseif ($period === 'weekly') {
            $sales = $query->select(
                DB::raw('YEARWEEK(created_at, 1) as date'),
                DB::raw('SUM(total_amount) as total_sales'),
                DB::raw('COUNT(id) as transactions_count')
            )->groupBy('date')->orderBy('date')->get();
        } else {
            $sales = $query->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(total_amount) as total_sales'),
                DB::raw('COUNT(id) as transactions_count')
            )->groupBy('date')->orderBy('date')->get();
        }

        $totalSales = $sales->sum('total_sales');
        $totalTransactions = $sales->sum('transactions_count');

        return view('admin.reports.sales', compact('sales', 'dateFrom', 'dateTo', 'period', 'totalSales', 'totalTransactions'));
    }

    public function topProducts(Request $request)
    {
        $dateFrom = $request->input('date_from', now()->startOfMonth()->toDateString());
        $dateTo = $request->input('date_to', now()->endOfMonth()->toDateString());
        $orderBy = $request->input('order_by', 'quantity'); // quantity, revenue

        $query = TransactionItem::join('transactions', 'transaction_items.transaction_id', '=', 'transactions.id')
            ->join('products', 'transaction_items.product_id', '=', 'products.id')
            ->where('transactions.status', 'completed')
            ->whereDate('transactions.created_at', '>=', $dateFrom)
            ->whereDate('transactions.created_at', '<=', $dateTo)
            ->select(
                'products.name',
                'products.sku',
                'products.unit_price as price',
                DB::raw('SUM(transaction_items.quantity) as total_quantity_sold'),
                DB::raw('SUM(transaction_items.subtotal) as total_revenue')
            )
            ->groupBy('products.id', 'products.name', 'products.sku', 'products.unit_price');

        if ($orderBy === 'revenue') {
            $topProducts = $query->orderByDesc('total_revenue')->take(20)->get();
        } else {
            $topProducts = $query->orderByDesc('total_quantity_sold')->take(20)->get();
        }

        return view('admin.reports.top-products', ['products' => $topProducts, 'dateFrom' => $dateFrom, 'dateTo' => $dateTo, 'orderBy' => $orderBy]);
    }

    public function inventory()
    {
        $products = Product::with('category')->orderBy('name')->get();
        
        $totalValue = $products->sum(function ($product) {
            return $product->current_stock * $product->unit_price;
        });
        
        $totalUnits = $products->sum('current_stock');
        $totalProducts = $products->count();

        return view('admin.reports.inventory', compact('products', 'totalValue', 'totalUnits', 'totalProducts'));
    }

    public function lowStock()
    {
        $products = Product::with(['category', 'supplier'])->lowStock()->orderBy('current_stock')->get();
        return view('admin.reports.low-stock', compact('products'));
    }

    public function suppliers()
    {
        $suppliers = Supplier::with(['products' => function ($q) {
            $q->select('id', 'supplier_id', 'current_stock', 'unit_price', 'is_active');
        }])->orderBy('name')->get();

        foreach ($suppliers as $supplier) {
            $supplier->products_count = $supplier->products->count();
            $supplier->active_products_count = $supplier->products->where('is_active', true)->count();
            $supplier->total_stock_value = $supplier->products->sum(function ($product) {
                return $product->current_stock * $product->unit_price;
            });
        }

        return view('admin.reports.suppliers', compact('suppliers'));
    }

    public function transactions(Request $request)
    {
        $query = Transaction::with('items')->withCount('items');

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        if ($request->filled('search')) {
            $query->where('transaction_number', 'like', "%{$request->search}%");
        }

        $transactions = $query->latest()->paginate(20)->withQueryString();

        $totalRevenue = Transaction::where('status', 'completed')
            ->when($request->filled('date_from'), function($q) use ($request) {
                $q->whereDate('created_at', '>=', $request->date_from);
            })->when($request->filled('date_to'), function($q) use ($request) {
                $q->whereDate('created_at', '<=', $request->date_to);
            })->sum('total_amount');

        return view('admin.reports.transactions', compact('transactions', 'totalRevenue'));
    }

    public function confirmTransaction($id)
    {
        $transaction = Transaction::with('items')->findOrFail($id);
        
        if ($transaction->status !== 'pending') {
            return redirect()->back()->with('error', 'Transaction is already completed or cancelled.');
        }

        DB::beginTransaction();
        try {
            // Deduct stock and create inventory movements for each item
            foreach ($transaction->items as $item) {
                $product = Product::lockForUpdate()->find($item->product_id);

                if (!$product) {
                    throw new \Exception("Product '{$item->product_name}' no longer exists.");
                }

                if ($product->current_stock < $item->quantity) {
                    throw new \Exception("Not enough stock for {$product->name}. Available: {$product->current_stock}, Requested: {$item->quantity}");
                }

                $beforeStock = $product->current_stock;
                $product->decrement('current_stock', $item->quantity);

                InventoryMovement::create([
                    'product_id' => $product->id,
                    'type' => InventoryMovement::TYPE_OUT,
                    'quantity' => $item->quantity,
                    'before_stock' => $beforeStock,
                    'after_stock' => $product->fresh()->current_stock,
                    'reference_type' => Transaction::class,
                    'reference_id' => $transaction->id,
                    'notes' => 'Sale via kiosk (confirmed)',
                ]);
            }

            $transaction->status = 'completed';
            $transaction->save();

            DB::commit();

            return redirect()->back()->with('success', 'Transaction confirmed successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to confirm: ' . $e->getMessage());
        }
    }

    public function rejectTransaction($id)
    {
        $transaction = Transaction::findOrFail($id);
        
        if ($transaction->status !== 'pending') {
            return redirect()->back()->with('error', 'Transaction is already completed or cancelled.');
        }

        $transaction->status = 'cancelled';
        $transaction->save();

        return redirect()->back()->with('success', 'Transaction rejected successfully.');
    }
}
