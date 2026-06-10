<?php

namespace App\Http\Controllers\Kiosk;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\InventoryMovement;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KioskController extends Controller
{
    public function index()
    {
        $categories = Category::active()->get();
        $settings = \App\Models\Setting::pluck('value', 'key')->toArray();
        return view('kiosk.index', compact('categories', 'settings'));
    }

    public function products(Request $request)
    {
        $query = Product::active()->inStock();

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%")
                  ->orWhere('barcode', 'like', "%{$search}%");
            });
        }

        $products = $query->paginate(12);

        return response()->json($products);
    }

    public function checkout(Request $request)
    {
        $validated = $request->validate([
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();
        try {
            $totalAmount = 0;
            $transactionItems = [];

            // Pre-check stock to prevent partial transactions
            foreach ($validated['items'] as $item) {
                $product = Product::active()->lockForUpdate()->find($item['product_id']);
                
                if (!$product) {
                    throw new \Exception("Product not found or inactive.");
                }

                if ($product->current_stock < $item['quantity']) {
                    throw new \Exception("Not enough stock for {$product->name}. Available: {$product->current_stock}");
                }

                $subtotal = $product->unit_price * $item['quantity'];
                $totalAmount += $subtotal;

                $transactionItems[] = [
                    'product' => $product,
                    'quantity' => $item['quantity'],
                    'unit_price' => $product->unit_price,
                    'subtotal' => $subtotal,
                ];
            }

            $settings = \App\Models\Setting::pluck('value', 'key')->toArray();
            $taxRate = isset($settings['default_tax_rate']) ? (float)$settings['default_tax_rate'] / 100 : 0.12;

            $taxAmount = $totalAmount * $taxRate;
            $grandTotal = $totalAmount + $taxAmount;

            $transaction = Transaction::create([
                'total_amount' => $grandTotal,
                'subtotal' => $totalAmount,
                'tax_amount' => $taxAmount,
                'discount_amount' => 0,
                'status' => 'pending',
            ]);

            // Only create transaction items — stock will be deducted when admin confirms
            foreach ($transactionItems as $item) {
                TransactionItem::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $item['product']->id,
                    'product_name' => $item['product']->name,
                    'unit_price' => $item['unit_price'],
                    'quantity' => $item['quantity'],
                    'subtotal' => $item['subtotal'],
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Checkout successful',
                'transaction_id' => $transaction->id,
                'transaction_number' => $transaction->transaction_number,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    public function transactionStatus($id)
    {
        $transaction = Transaction::with('items.product')->find($id);

        if (!$transaction) {
            return response()->json(['error' => 'Transaction not found'], 404);
        }

        return response()->json([
            'id' => $transaction->id,
            'status' => $transaction->status,
            'transaction_number' => $transaction->transaction_number,
            'subtotal' => (float) $transaction->subtotal,
            'tax_amount' => (float) $transaction->tax_amount,
            'total_amount' => (float) $transaction->total_amount,
            'created_at' => $transaction->created_at,
            'items' => $transaction->items->map(fn($item) => [
                'name' => $item->product_name,
                'quantity' => $item->quantity,
                'price' => (float) $item->unit_price,
                'subtotal' => (float) $item->subtotal,
            ]),
        ]);
    }

    public function receipt($transactionId)
    {
        $transaction = Transaction::with('items')->findOrFail($transactionId);
        $settings = \App\Models\Setting::pluck('value', 'key')->toArray();
        return view('kiosk.receipt', compact('transaction', 'settings'));
    }
}
