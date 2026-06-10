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
}
