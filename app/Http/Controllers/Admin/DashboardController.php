<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Transaction;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProducts = Product::count();
        $totalCategories = Category::count();
        $totalSuppliers = Supplier::count();
        $currentInventoryCount = Product::sum('current_stock');
        $lowStockAlertsCount = Product::lowStock()->count();

        $todaySales = Transaction::where('status', 'completed')->whereDate('created_at', today())->sum('total_amount');
        $weeklySales = Transaction::where('status', 'completed')->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->sum('total_amount');
        $monthlySales = Transaction::where('status', 'completed')->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])->sum('total_amount');

        $recentTransactions = Transaction::withCount('items')->latest()->take(10)->get();
        $lowStockProducts = Product::with('category')->lowStock()->take(10)->get();

        return view('admin.dashboard', compact(
            'totalProducts',
            'totalCategories',
            'totalSuppliers',
            'currentInventoryCount',
            'lowStockAlertsCount',
            'todaySales',
            'weeklySales',
            'monthlySales',
            'recentTransactions',
            'lowStockProducts'
        ));
    }

    /**
     * Lightweight JSON endpoint polled every few seconds by the dashboard.
     * Returns only the data that changes frequently.
     */
    public function liveData()
    {
        $pendingCount = Transaction::where('status', 'pending')->count();

        $todaySales    = Transaction::where('status', 'completed')->whereDate('created_at', today())->sum('total_amount');
        $weeklySales   = Transaction::where('status', 'completed')->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->sum('total_amount');
        $monthlySales  = Transaction::where('status', 'completed')->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])->sum('total_amount');
        $lowStockCount = Product::lowStock()->count();

        $recentTransactions = Transaction::withCount('items')
            ->latest()
            ->take(10)
            ->get()
            ->map(fn ($t) => [
                'id'                 => $t->id,
                'transaction_number' => $t->transaction_number,
                'created_at'         => $t->created_at->format('M d, g:i A'),
                'items_count'        => $t->items_count ?? 0,
                'total_amount'       => $t->total_amount,
                'status'             => $t->status,
                'confirm_url'        => route('admin.reports.transactions.confirm', $t->id),
            ]);

        return response()->json([
            'pending_count'       => $pendingCount,
            'today_sales'         => $todaySales,
            'weekly_sales'        => $weeklySales,
            'monthly_sales'       => $monthlySales,
            'low_stock_count'     => $lowStockCount,
            'recent_transactions' => $recentTransactions,
            'timestamp'           => now()->toISOString(),
        ]);
    }
}
