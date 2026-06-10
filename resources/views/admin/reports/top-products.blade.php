@extends('layouts.admin')

@section('title', 'Top Products Report')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold mb-0">Top Products Report</h2>
    <div class="d-flex gap-2">
        <button class="btn btn-outline-primary rounded-pill px-4" onclick="window.print()">
            <i class="bi bi-printer me-2"></i> Print
        </button>
        <a href="{{ route('admin.reports.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
            <i class="bi bi-arrow-left me-2"></i> Back to Reports
        </a>
    </div>
</div>

<div class="glass-card mb-4 d-print-none">
    <div class="p-4 bg-light bg-opacity-50">
        <form action="{{ route('admin.reports.top-products') }}" method="GET" class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label small text-muted fw-bold text-uppercase">Date From</label>
                <input type="date" name="date_from" class="form-control form-control-custom" value="{{ request('date_from', \Carbon\Carbon::now()->subDays(30)->format('Y-m-d')) }}">
            </div>
            <div class="col-md-4">
                <label class="form-label small text-muted fw-bold text-uppercase">Date To</label>
                <input type="date" name="date_to" class="form-control form-control-custom" value="{{ request('date_to', \Carbon\Carbon::now()->format('Y-m-d')) }}">
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary w-100">Generate Report</button>
            </div>
        </form>
    </div>
</div>

<div class="glass-card">
    <div class="card-header-gradient d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Top Selling Products</h5>
        <span class="badge bg-light text-dark shadow-sm">Based on date range</span>
    </div>
    <div class="p-0">
        <div class="table-responsive">
            <table class="table table-custom mb-0">
                <thead>
                    <tr>
                        <th width="10%" class="text-center">Rank</th>
                        <th width="30%">Product</th>
                        <th width="15%">Category</th>
                        <th width="15%">Unit Price</th>
                        <th width="15%" class="text-center">Quantity Sold</th>
                        <th width="15%" class="text-end">Total Revenue</th>
                    </tr>
                </thead>
                <tbody>
                    @php $rank = 1; @endphp
                    @forelse($products ?? [] as $product)
                    <tr>
                        <td class="text-center">
                            @if($rank == 1)
                                <span class="badge bg-warning rounded-circle p-2 shadow" style="width:30px; height:30px;">1</span>
                            @elseif($rank == 2)
                                <span class="badge bg-secondary rounded-circle p-2 shadow" style="width:30px; height:30px;">2</span>
                            @elseif($rank == 3)
                                <span class="badge rounded-circle p-2 shadow" style="width:30px; height:30px; background-color: #cd7f32;">3</span>
                            @else
                                <span class="fw-bold text-muted">{{ $rank }}</span>
                            @endif
                        </td>
                        <td>
                            <div class="fw-semibold text-dark">{{ $product->name }}</div>
                            <div class="small text-muted">SKU: {{ $product->sku }}</div>
                        </td>
                        <td>{{ $product->category->name ?? '-' }}</td>
                        <td>₱{{ number_format($product->price, 2) }}</td>
                        <td class="text-center fw-bold fs-5 text-primary">{{ $product->total_quantity_sold }}</td>
                        <td class="text-end fw-bold text-success">₱{{ number_format($product->total_revenue, 2) }}</td>
                    </tr>
                    @php $rank++; @endphp
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">No sales data found for the selected date range.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
