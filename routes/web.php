<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Kiosk\KioskController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\InventoryController;
use App\Http\Controllers\Admin\StockEntryController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AuditLogController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\SqlRunnerController;

// Public kiosk routes (no auth required)
Route::get('/', [KioskController::class, 'index'])->name('kiosk.index');
Route::get('/kiosk/products', [KioskController::class, 'products'])->name('kiosk.products');
Route::post('/kiosk/checkout', [KioskController::class, 'checkout'])->name('kiosk.checkout');
Route::get('/kiosk/receipt/{transaction}', [KioskController::class, 'receipt'])->name('kiosk.receipt');
Route::get('/kiosk/transaction/{id}/status', [KioskController::class, 'transactionStatus'])->name('kiosk.transaction.status');

// Auth routes
Route::get('/admin/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/admin/login', [AuthController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout');

// Admin routes (all require auth)
Route::prefix('admin')->middleware(['auth', 'auditor.readonly'])->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/live-data', [DashboardController::class, 'liveData'])->name('dashboard.live-data');

    // Self-Profile: any authenticated user can view/update their own profile
    Route::get('/profile', [UserController::class, 'editSelf'])->name('profile.edit');
    Route::put('/profile', [UserController::class, 'updateSelf'])->name('profile.update');

    // DCIT 55A SQL Runner
    Route::get('/sql-runner', [SqlRunnerController::class, 'index'])->name('sql-runner.index')->middleware('role:admin');
    Route::post('/sql-runner/execute', [SqlRunnerController::class, 'execute'])->name('sql-runner.execute')->middleware('role:admin');
    
    // Categories
    Route::resource('categories', CategoryController::class)->middleware('role:admin,inventory_manager');
    
    // Suppliers
    Route::resource('suppliers', SupplierController::class)->middleware('role:admin,inventory_manager');
    
    // Products
    Route::resource('products', ProductController::class)->middleware('role:admin,inventory_manager');
    
    // Inventory & Stock Entries (Admin & Inventory Manager only)
    Route::middleware('role:admin,inventory_manager')->group(function () {
        Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory.index');
        Route::get('/inventory/movements', [InventoryController::class, 'movements'])->name('inventory.movements');
        Route::get('/inventory/low-stock', [InventoryController::class, 'lowStock'])->name('inventory.low-stock');
        Route::get('/inventory/adjust', [InventoryController::class, 'adjustForm'])->name('inventory.adjust-form');
        Route::put('/inventory/adjust/{product}', [InventoryController::class, 'adjust'])->name('inventory.adjust');
        
        Route::resource('stock-entries', StockEntryController::class)->only(['index', 'create', 'store', 'show']);
        Route::put('/stock-entries/{stock_entry}/approve', [StockEntryController::class, 'approve'])->name('stock-entries.approve');
        Route::put('/stock-entries/{stock_entry}/reject', [StockEntryController::class, 'reject'])->name('stock-entries.reject');
    });
    
    // Reports
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/sales', [ReportController::class, 'sales'])->name('reports.sales');
    Route::get('/reports/top-products', [ReportController::class, 'topProducts'])->name('reports.top-products');
    Route::get('/reports/inventory', [ReportController::class, 'inventory'])->name('reports.inventory');
    Route::get('/reports/low-stock', [ReportController::class, 'lowStock'])->name('reports.low-stock');
    Route::get('/reports/suppliers', [ReportController::class, 'suppliers'])->name('reports.suppliers');
    Route::get('/reports/transactions', [ReportController::class, 'transactions'])->name('reports.transactions');
    Route::post('/reports/transactions/{id}/confirm', [ReportController::class, 'confirmTransaction'])->name('reports.transactions.confirm');
    Route::post('/reports/transactions/{id}/reject', [ReportController::class, 'rejectTransaction'])->name('reports.transactions.reject');
    
    // Users (admin only)
    Route::resource('users', UserController::class)->middleware('role:admin');
    
    // Audit Logs
    Route::get('/audit-logs', [AuditLogController::class, 'index'])->name('audit-logs.index')->middleware('role:admin,auditor');
    
    // Settings (admin only)
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index')->middleware('role:admin');
    Route::post('/settings', [SettingsController::class, 'store'])->name('settings.store')->middleware('role:admin');
});

Route::post('/test-upload', function (Illuminate\Http\Request $request) {
    return response()->json([
        'has_file' => $request->hasFile('image'),
        'files' => array_keys($_FILES),
        'error' => isset($_FILES['image']) ? $_FILES['image']['error'] : 'not_set',
    ]);
});
