@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div class="glass-card p-4 d-flex justify-content-between align-items-center">
            <div>
                <h3 class="fw-bold mb-1">Welcome back, {{ auth()->user()->name ?? 'Admin' }}!</h3>
                <p class="text-muted mb-0">Here's what's happening with your store today, {{ \Carbon\Carbon::now()->format('F j, Y') }}.</p>
            </div>
            <div class="d-none d-md-block">
                <a href="{{ route('admin.reports.index') }}" class="btn btn-gradient px-4 py-2 rounded-pill shadow-sm">
                    <i class="bi bi-file-earmark-bar-graph me-2"></i> View Reports
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Key Metrics Row 1 -->
<div class="row g-4 mb-4">
    <div class="col-md-6 col-lg-3">
        <div class="glass-card p-4">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <p class="text-muted mb-1 fw-semibold">Total Products</p>
                    <h2 class="fw-bold mb-0">{{ number_format($totalProducts ?? 0) }}</h2>
                </div>
                <div class="rounded p-3 bg-primary bg-opacity-10 text-primary">
                    <i class="bi bi-box-seam fs-4"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="glass-card p-4">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <p class="text-muted mb-1 fw-semibold">Categories</p>
                    <h2 class="fw-bold mb-0">{{ number_format($totalCategories ?? 0) }}</h2>
                </div>
                <div class="rounded p-3 bg-info bg-opacity-10 text-info">
                    <i class="bi bi-tags fs-4"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="glass-card p-4">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <p class="text-muted mb-1 fw-semibold">Suppliers</p>
                    <h2 class="fw-bold mb-0">{{ number_format($totalSuppliers ?? 0) }}</h2>
                </div>
                <div class="rounded p-3 bg-warning bg-opacity-10 text-warning">
                    <i class="bi bi-truck fs-4"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="glass-card p-4">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <p class="text-muted mb-1 fw-semibold">Inventory Items</p>
                    <h2 class="fw-bold mb-0">{{ number_format($totalInventory ?? 0) }}</h2>
                </div>
                <div class="rounded p-3" style="background-color: rgba(124, 58, 237, 0.1); color: var(--accent-color);">
                    <i class="bi bi-clipboard-data fs-4"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Key Metrics Row 2 -->
<div class="row g-4 mb-4">
    <div class="col-md-6 col-lg-3">
        <div class="glass-card p-4">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <p class="text-muted mb-1 fw-semibold">Today's Sales</p>
                    <h3 class="fw-bold mb-0 text-success">₱{{ number_format($todaySales ?? 0, 2) }}</h3>
                </div>
                <div class="rounded p-3 bg-success bg-opacity-10 text-success">
                    <i class="bi bi-currency-dollar fs-4"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="glass-card p-4">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <p class="text-muted mb-1 fw-semibold">Weekly Sales</p>
                    <h3 class="fw-bold mb-0 text-success">₱{{ number_format($weeklySales ?? 0, 2) }}</h3>
                </div>
                <div class="rounded p-3 bg-success bg-opacity-10 text-success">
                    <i class="bi bi-graph-up-arrow fs-4"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="glass-card p-4">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <p class="text-muted mb-1 fw-semibold">Monthly Sales</p>
                    <h3 class="fw-bold mb-0 text-success">₱{{ number_format($monthlySales ?? 0, 2) }}</h3>
                </div>
                <div class="rounded p-3 bg-success bg-opacity-10 text-success">
                    <i class="bi bi-calendar-check fs-4"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="glass-card p-4 border-start border-4 border-danger">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <p class="text-muted mb-1 fw-semibold">Low Stock Alerts</p>
                    <h3 class="fw-bold mb-0 text-danger">{{ number_format($lowStockCount ?? 0) }}</h3>
                </div>
                <div class="rounded p-3 bg-danger bg-opacity-10 text-danger">
                    <i class="bi bi-exclamation-triangle fs-4"></i>
                </div>
            </div>
            <a href="{{ route('admin.inventory.low-stock') }}" class="text-decoration-none text-danger small mt-2 d-inline-block">View Details <i class="bi bi-arrow-right"></i></a>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <!-- Recent Transactions -->
    <div class="col-lg-7">
        <div class="glass-card h-100">
            <div class="card-header-gradient d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Recent Transactions</h5>
                <a href="{{ route('admin.reports.transactions') }}" class="btn btn-sm btn-outline-light border-0">View All</a>
            </div>
            <div class="p-0">
                <div class="table-responsive">
                    <table class="table table-custom mb-0">
                        <thead>
                            <tr>
                                <th>Transaction #</th>
                                <th>Date</th>
                                <th>Items</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentTransactions ?? [] as $transaction)
                            <tr>
                                <td><span class="fw-medium">#{{ $transaction->transaction_number }}</span></td>
                                <td>{{ \Carbon\Carbon::parse($transaction->created_at)->format('M d, g:i A') }}</td>
                                <td>{{ $transaction->items_count ?? 0 }}</td>
                                <td class="fw-bold">₱{{ number_format($transaction->total_amount, 2) }}</td>
                                <td>
                                    @if($transaction->status == 'completed')
                                        <span class="badge bg-success badge-custom">Completed</span>
                                    @elseif($transaction->status == 'pending')
                                        <span class="badge bg-warning text-dark badge-custom">Pending</span>
                                    @else
                                        <span class="badge bg-danger badge-custom">{{ ucfirst($transaction->status ?? 'Completed') }}</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($transaction->status == 'pending')
                                        <form action="{{ route('admin.reports.transactions.confirm', $transaction->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success rounded-pill px-2 py-0 shadow-sm" title="Confirm" onclick="return confirm('Confirm this transaction?')">
                                                <i class="bi bi-check-lg"></i>
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">No recent transactions found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Low Stock Products -->
    <div class="col-lg-5">
        <div class="glass-card h-100">
            <div class="card-header-gradient bg-danger bg-gradient d-flex justify-content-between align-items-center" style="background: linear-gradient(135deg, #dc3545, #fd7e14);">
                <h5 class="mb-0">Low Stock Warning</h5>
                <a href="{{ route('admin.inventory.low-stock') }}" class="btn btn-sm btn-outline-light border-0">View All</a>
            </div>
            <div class="p-0">
                <div class="table-responsive">
                    <table class="table table-custom mb-0">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Stock</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($lowStockProducts ?? [] as $product)
                            @php
                                $percent = $product->low_stock_threshold > 0 ? ($product->current_stock / $product->low_stock_threshold) * 100 : 0;
                                $color = $product->current_stock == 0 ? 'bg-danger' : ($percent < 50 ? 'bg-warning' : 'bg-info');
                            @endphp
                            <tr>
                                <td>
                                    <div class="d-flex flex-column">
                                        <span class="fw-medium">{{ $product->name }}</span>
                                        <span class="text-muted small">SKU: {{ $product->sku }}</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="fw-bold {{ $product->current_stock == 0 ? 'text-danger' : '' }}">{{ $product->current_stock }}</div>
                                    <div class="progress" style="height: 4px; width: 50px;">
                                        <div class="progress-bar {{ $color }}" role="progressbar" style="width: {{ min(100, $percent) }}%"></div>
                                    </div>
                                </td>
                                <td>
                                    @if($product->current_stock == 0)
                                        <span class="badge bg-danger badge-custom">Out of Stock</span>
                                    @else
                                        <span class="badge bg-warning text-dark badge-custom">Low Stock</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center py-4 text-muted">All products are adequately stocked!</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
