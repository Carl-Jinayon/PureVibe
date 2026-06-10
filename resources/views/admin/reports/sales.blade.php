@extends('layouts.admin')

@section('title', 'Sales Report')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold mb-0">Sales Report</h2>
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
        <form action="{{ route('admin.reports.sales') }}" method="GET" class="row g-3 align-items-end">
            <div class="col-md-3">
                <label class="form-label small text-muted fw-bold text-uppercase">Grouping Period</label>
                <select name="period" class="form-select form-control-custom">
                    <option value="daily" {{ request('period', 'daily') == 'daily' ? 'selected' : '' }}>Daily</option>
                    <option value="weekly" {{ request('period') == 'weekly' ? 'selected' : '' }}>Weekly</option>
                    <option value="monthly" {{ request('period') == 'monthly' ? 'selected' : '' }}>Monthly</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label small text-muted fw-bold text-uppercase">Date From</label>
                <input type="date" name="date_from" class="form-control form-control-custom" value="{{ request('date_from', \Carbon\Carbon::now()->subDays(30)->format('Y-m-d')) }}">
            </div>
            <div class="col-md-3">
                <label class="form-label small text-muted fw-bold text-uppercase">Date To</label>
                <input type="date" name="date_to" class="form-control form-control-custom" value="{{ request('date_to', \Carbon\Carbon::now()->format('Y-m-d')) }}">
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary w-100">Generate Report</button>
            </div>
        </form>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="glass-card p-4 text-center h-100">
            <h6 class="text-muted text-uppercase fw-semibold mb-2">Total Sales Revenue</h6>
            <h2 class="fw-bold text-success mb-0">₱{{ number_format($totalSales ?? 0, 2) }}</h2>
        </div>
    </div>
    <div class="col-md-4">
        <div class="glass-card p-4 text-center h-100">
            <h6 class="text-muted text-uppercase fw-semibold mb-2">Total Transactions</h6>
            <h2 class="fw-bold text-primary mb-0">{{ number_format($totalTransactions ?? 0) }}</h2>
        </div>
    </div>
    <div class="col-md-4">
        <div class="glass-card p-4 text-center h-100">
            <h6 class="text-muted text-uppercase fw-semibold mb-2">Average Transaction</h6>
            @php $avg = ($totalTransactions ?? 0) > 0 ? ($totalSales ?? 0) / $totalTransactions : 0; @endphp
            <h2 class="fw-bold text-info mb-0">₱{{ number_format($avg, 2) }}</h2>
        </div>
    </div>
</div>

<div class="glass-card">
    <div class="card-header-gradient d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Sales Data ({{ ucfirst(request('period', 'daily')) }})</h5>
    </div>
    <div class="p-0">
        <div class="table-responsive">
            <table class="table table-custom mb-0">
                <thead>
                    <tr>
                        <th width="40%">Period</th>
                        <th width="30%" class="text-center">Transactions Count</th>
                        <th width="30%" class="text-end">Total Sales</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sales ?? [] as $data)
                    <tr>
                        <td class="fw-medium">
                            @if(request('period') == 'monthly')
                                {{ \Carbon\Carbon::createFromFormat('Y-m', $data->date)->format('F Y') }}
                            @elseif(request('period') == 'weekly')
                                Week {{ substr($data->date, 4) }}, {{ substr($data->date, 0, 4) }}
                            @else
                                {{ \Carbon\Carbon::parse($data->date)->format('M d, Y (l)') }}
                            @endif
                        </td>
                        <td class="text-center">{{ $data->transactions_count }}</td>
                        <td class="text-end fw-bold">₱{{ number_format($data->total_sales, 2) }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-center py-5 text-muted">No sales data found for the selected date range.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
