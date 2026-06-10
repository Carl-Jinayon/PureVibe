@extends('layouts.admin')

@section('title', 'Reports Dashboard')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold mb-0">Reports Dashboard</h2>
</div>

<div class="row g-4 mb-4">
    <!-- Sales Report -->
    <div class="col-md-6 col-lg-4">
        <a href="{{ route('admin.reports.sales') }}" class="text-decoration-none text-dark h-100 d-block">
            <div class="glass-card p-4 h-100 d-flex flex-column align-items-center text-center hover-lift">
                <div class="bg-primary bg-opacity-10 text-primary rounded-circle p-4 mb-3">
                    <i class="bi bi-graph-up-arrow fs-1"></i>
                </div>
                <h4 class="fw-bold mb-2">Sales Report</h4>
                <p class="text-muted mb-0 small">Analyze revenue, transaction counts, and sales trends over specific periods.</p>
            </div>
        </a>
    </div>

    <!-- Top Products -->
    <div class="col-md-6 col-lg-4">
        <a href="{{ route('admin.reports.top-products') }}" class="text-decoration-none text-dark h-100 d-block">
            <div class="glass-card p-4 h-100 d-flex flex-column align-items-center text-center hover-lift">
                <div class="bg-success bg-opacity-10 text-success rounded-circle p-4 mb-3">
                    <i class="bi bi-star fs-1"></i>
                </div>
                <h4 class="fw-bold mb-2">Top Products</h4>
                <p class="text-muted mb-0 small">Discover your best-selling items by quantity sold and total revenue generated.</p>
            </div>
        </a>
    </div>

    <!-- Inventory Valuation -->
    <div class="col-md-6 col-lg-4">
        <a href="{{ route('admin.reports.inventory') }}" class="text-decoration-none text-dark h-100 d-block">
            <div class="glass-card p-4 h-100 d-flex flex-column align-items-center text-center hover-lift">
                <div class="bg-info bg-opacity-10 text-info rounded-circle p-4 mb-3">
                    <i class="bi bi-boxes fs-1"></i>
                </div>
                <h4 class="fw-bold mb-2">Inventory Value</h4>
                <p class="text-muted mb-0 small">Calculate the total estimated value of your current stock on hand.</p>
            </div>
        </a>
    </div>

    <!-- Low Stock -->
    <div class="col-md-6 col-lg-4">
        <a href="{{ route('admin.reports.low-stock') }}" class="text-decoration-none text-dark h-100 d-block">
            <div class="glass-card p-4 h-100 d-flex flex-column align-items-center text-center hover-lift">
                <div class="bg-danger bg-opacity-10 text-danger rounded-circle p-4 mb-3">
                    <i class="bi bi-exclamation-triangle fs-1"></i>
                </div>
                <h4 class="fw-bold mb-2">Low Stock</h4>
                <p class="text-muted mb-0 small">Printable report of all items currently below their minimum stock threshold.</p>
            </div>
        </a>
    </div>

    <!-- Supplier Report -->
    <div class="col-md-6 col-lg-4">
        <a href="{{ route('admin.reports.suppliers') }}" class="text-decoration-none text-dark h-100 d-block">
            <div class="glass-card p-4 h-100 d-flex flex-column align-items-center text-center hover-lift">
                <div class="bg-warning bg-opacity-10 text-warning rounded-circle p-4 mb-3">
                    <i class="bi bi-truck fs-1"></i>
                </div>
                <h4 class="fw-bold mb-2">Supplier Analysis</h4>
                <p class="text-muted mb-0 small">Overview of supplier performance, active products, and total stock value provided.</p>
            </div>
        </a>
    </div>

    <!-- Transactions -->
    <div class="col-md-6 col-lg-4">
        <a href="{{ route('admin.reports.transactions') }}" class="text-decoration-none text-dark h-100 d-block">
            <div class="glass-card p-4 h-100 d-flex flex-column align-items-center text-center hover-lift">
                <div class="bg-secondary bg-opacity-10 text-secondary rounded-circle p-4 mb-3">
                    <i class="bi bi-receipt fs-1"></i>
                </div>
                <h4 class="fw-bold mb-2">Transaction History</h4>
                <p class="text-muted mb-0 small">Detailed log of all self-checkout transactions, statuses, and payment amounts.</p>
            </div>
        </a>
    </div>
</div>

<style>
    .hover-lift {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .hover-lift:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.1);
        border-color: var(--primary-color);
    }
</style>
@endsection
