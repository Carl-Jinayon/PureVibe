@extends('layouts.admin')

@section('title', 'Inventory Movements')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold mb-0">Inventory Movements</h2>
    <a href="{{ route('admin.inventory.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
        <i class="bi bi-arrow-left me-2"></i> Back to Inventory
    </a>
</div>

<div class="glass-card mb-4">
    <div class="p-4 border-bottom border-light bg-light bg-opacity-50">
        <form action="{{ route('admin.inventory.movements') }}" method="GET" class="row g-3">
            <div class="col-md-3">
                <input type="text" name="search" class="form-control form-control-custom" placeholder="Search reference or notes..." value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <select name="type" class="form-select form-control-custom">
                    <option value="">All Movement Types</option>
                    <option value="in" {{ request('type') == 'in' ? 'selected' : '' }}>Stock In</option>
                    <option value="out" {{ request('type') == 'out' ? 'selected' : '' }}>Stock Out</option>
                    <option value="adjustment" {{ request('type') == 'adjustment' ? 'selected' : '' }}>Adjustment</option>
                </select>
            </div>
            <div class="col-md-4">
                <div class="input-group">
                    <input type="date" name="date_from" class="form-control form-control-custom" value="{{ request('date_from') }}">
                    <span class="input-group-text border-0 bg-transparent">to</span>
                    <input type="date" name="date_to" class="form-control form-control-custom" value="{{ request('date_to') }}">
                </div>
            </div>
            <div class="col-md-2 d-flex gap-2">
                <button type="submit" class="btn btn-primary w-100">Filter</button>
                <a href="{{ route('admin.inventory.movements') }}" class="btn btn-outline-secondary" title="Clear Filters"><i class="bi bi-arrow-clockwise"></i></a>
            </div>
        </form>
    </div>

    <div class="table-responsive">
        <table class="table table-custom mb-0">
            <thead>
                <tr>
                    <th width="15%">Date & Time</th>
                    <th width="20%">Product</th>
                    <th width="10%">Type</th>
                    <th width="10%">Quantity</th>
                    <th width="15%">Before <span class="text-muted small px-1">→</span> After</th>
                    <th width="15%">Reference</th>
                    <th width="15%">User</th>
                </tr>
            </thead>
            <tbody>
                @forelse($movements ?? [] as $movement)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($movement->created_at)->format('M d, Y H:i') }}</td>
                    <td>
                        <div class="fw-semibold">{{ $movement->product->name ?? 'Unknown Product' }}</div>
                        <div class="small text-muted">{{ $movement->product->sku ?? '' }}</div>
                    </td>
                    <td>
                        @if($movement->type == 'in')
                            <span class="badge bg-success bg-opacity-10 text-success border border-success badge-custom"><i class="bi bi-arrow-down-left me-1"></i> IN</span>
                        @elseif($movement->type == 'out')
                            <span class="badge bg-danger bg-opacity-10 text-danger border border-danger badge-custom"><i class="bi bi-arrow-up-right me-1"></i> OUT</span>
                        @else
                            <span class="badge bg-warning bg-opacity-10 text-warning border border-warning badge-custom"><i class="bi bi-arrow-left-right me-1"></i> ADJ</span>
                        @endif
                    </td>
                    <td>
                        <span class="fw-bold {{ $movement->type == 'in' ? 'text-success' : ($movement->type == 'out' ? 'text-danger' : '') }}">
                            {{ $movement->type == 'in' ? '+' : ($movement->type == 'out' ? '-' : '') }}{{ $movement->quantity }}
                        </span>
                    </td>
                    <td>
                        <span class="text-muted">{{ $movement->before_stock }}</span> <span class="text-muted small px-1">→</span> <span class="fw-semibold">{{ $movement->after_stock }}</span>
                    </td>
                    <td>
                        {{ $movement->reference ?? '-' }}
                        @if($movement->notes)
                            <i class="bi bi-info-circle text-muted ms-1" data-bs-toggle="tooltip" title="{{ $movement->notes }}"></i>
                        @endif
                    </td>
                    <td>{{ $movement->user->name ?? 'System' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-5">
                        <div class="text-muted">
                            <i class="bi bi-clock-history fs-1 d-block mb-3"></i>
                            <p class="mb-0">No inventory movements found.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if(isset($movements) && method_exists($movements, 'links'))
    <div class="p-3 border-top border-light d-flex justify-content-end">
        {{ $movements->links() }}
    </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>
@endsection
