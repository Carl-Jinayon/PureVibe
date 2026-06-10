@extends('layouts.admin')

@section('title', 'Supplier Analysis Report')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold mb-0">Supplier Analysis</h2>
    <div class="d-flex gap-2">
        <button class="btn btn-outline-primary rounded-pill px-4" onclick="window.print()">
            <i class="bi bi-printer me-2"></i> Print
        </button>
        <a href="{{ route('admin.reports.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
            <i class="bi bi-arrow-left me-2"></i> Back
        </a>
    </div>
</div>

<div class="glass-card">
    <div class="card-header-gradient bg-warning bg-gradient text-dark d-flex justify-content-between align-items-center" style="background: linear-gradient(135deg, #ffc107, #fd7e14); color: white !important;">
        <h5 class="mb-0 text-white">Supplier Performance & Inventory</h5>
        <span class="badge bg-white text-dark shadow-sm">As of {{ \Carbon\Carbon::now()->format('M d, Y') }}</span>
    </div>
    <div class="p-0">
        <div class="table-responsive">
            <table class="table table-custom mb-0">
                <thead>
                    <tr>
                        <th width="25%">Supplier</th>
                        <th width="25%">Contact Info</th>
                        <th width="15%" class="text-center">Total Products</th>
                        <th width="15%" class="text-center">Active Products</th>
                        <th width="20%" class="text-end">Total Stock Value</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($suppliers ?? [] as $supplier)
                    <tr>
                        <td>
                            <div class="fw-bold fs-6 text-dark">{{ $supplier->name }}</div>
                            @if(!$supplier->is_active)
                                <span class="badge bg-danger badge-custom mt-1" style="font-size: 0.6rem;">Inactive</span>
                            @endif
                        </td>
                        <td>
                            <div class="fw-medium">{{ $supplier->contact_person ?? 'No Contact Person' }}</div>
                            <div class="small text-muted"><i class="bi bi-telephone me-1"></i> {{ $supplier->phone ?? '-' }}</div>
                            <div class="small text-muted"><i class="bi bi-envelope me-1"></i> {{ $supplier->email ?? '-' }}</div>
                        </td>
                        <td class="text-center fw-semibold fs-5">{{ $supplier->products_count ?? 0 }}</td>
                        <td class="text-center fw-semibold fs-5 text-success">{{ $supplier->active_products_count ?? 0 }}</td>
                        <td class="text-end fw-bold text-primary fs-5">₱{{ number_format($supplier->total_stock_value ?? 0, 2) }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">No supplier data available.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
