@extends('layouts.admin')

@section('title', 'Transaction History')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold mb-0">Transaction History</h2>
    <div class="d-flex gap-2">
        <button class="btn btn-outline-primary rounded-pill px-4" onclick="window.print()">
            <i class="bi bi-printer me-2"></i> Print
        </button>
        <a href="{{ route('admin.reports.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
            <i class="bi bi-arrow-left me-2"></i> Back
        </a>
    </div>
</div>

<div class="glass-card mb-4 d-print-none">
    <div class="p-4 bg-light bg-opacity-50">
        <form action="{{ route('admin.reports.transactions') }}" method="GET" class="row g-3 align-items-end">
            <div class="col-md-3">
                <label class="form-label small text-muted fw-bold text-uppercase">Search</label>
                <input type="text" name="search" class="form-control form-control-custom" placeholder="Transaction #..." value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label small text-muted fw-bold text-uppercase">Date From</label>
                <input type="date" name="date_from" class="form-control form-control-custom" value="{{ request('date_from') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label small text-muted fw-bold text-uppercase">Date To</label>
                <input type="date" name="date_to" class="form-control form-control-custom" value="{{ request('date_to') }}">
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-primary w-100">Filter</button>
                <a href="{{ route('admin.reports.transactions') }}" class="btn btn-outline-secondary" title="Clear Filters"><i class="bi bi-arrow-clockwise"></i></a>
            </div>
        </form>
    </div>
</div>

<div class="glass-card">
    <div class="p-0">
        <div class="table-responsive">
            <table class="table table-custom mb-0">
                <thead>
                    <tr>
                        <th width="15%">Transaction #</th>
                        <th width="20%">Date & Time</th>
                        <th width="10%" class="text-center">Items</th>
                        <th width="15%" class="text-end">Subtotal</th>
                        <th width="10%" class="text-end">Tax</th>
                        <th width="15%" class="text-end">Total</th>
                        <th width="10%" class="text-center">Status</th>
                        <th width="10%" class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transactions ?? [] as $transaction)
                    <tr>
                        <td>
                            <span class="fw-bold text-primary">#{{ $transaction->transaction_number ?? str_pad($transaction->id, 8, '0', STR_PAD_LEFT) }}</span>
                        </td>
                        <td>{{ \Carbon\Carbon::parse($transaction->created_at)->format('M d, Y h:i A') }}</td>
                        <td class="text-center fw-semibold">{{ $transaction->items_count ?? 0 }}</td>
                        <td class="text-end text-muted">₱{{ number_format($transaction->subtotal ?? 0, 2) }}</td>
                        <td class="text-end text-muted">₱{{ number_format($transaction->tax_amount ?? 0, 2) }}</td>
                        <td class="text-end fw-bold text-success fs-6">₱{{ number_format($transaction->total_amount ?? 0, 2) }}</td>
                        <td class="text-center">
                            @if($transaction->status == 'completed')
                                <span class="badge bg-success badge-custom px-3">Completed</span>
                            @elseif($transaction->status == 'pending')
                                <span class="badge bg-warning text-dark badge-custom px-3">Pending</span>
                            @else
                                <span class="badge bg-danger badge-custom px-3">{{ ucfirst($transaction->status ?? 'Completed') }}</span>
                            @endif
                        </td>
                        <td class="text-center">
                            @if($transaction->status == 'pending')
                                <form action="{{ route('admin.reports.transactions.confirm', $transaction->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success rounded-pill px-3 shadow-sm" onclick="return confirm('Confirm this transaction?')">
                                        <i class="bi bi-check-lg me-1"></i> Confirm
                                    </button>
                                </form>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-5">
                            <div class="text-muted">
                                <i class="bi bi-receipt fs-1 d-block mb-3"></i>
                                <p class="mb-0">No transactions found matching your criteria.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    @if(isset($transactions) && method_exists($transactions, 'links'))
    <div class="p-3 border-top border-light d-flex justify-content-end d-print-none">
        {{ $transactions->links() }}
    </div>
    @endif
</div>

@endsection

@section('scripts')
<script>
    // Auto-refresh for new pending transactions
    (function() {
        let lastPendingCount = {{ ($transactions ?? collect())->where('status', 'pending')->count() }};

        // Create a subtle notification sound using Web Audio API
        function playNotificationSound() {
            try {
                const ctx = new (window.AudioContext || window.webkitAudioContext)();
                const osc = ctx.createOscillator();
                const gain = ctx.createGain();
                osc.connect(gain);
                gain.connect(ctx.destination);
                osc.frequency.setValueAtTime(587.33, ctx.currentTime); // D5
                osc.frequency.setValueAtTime(783.99, ctx.currentTime + 0.15); // G5
                gain.gain.setValueAtTime(0.3, ctx.currentTime);
                gain.gain.exponentialRampToValueAtTime(0.01, ctx.currentTime + 0.5);
                osc.start(ctx.currentTime);
                osc.stop(ctx.currentTime + 0.5);
            } catch(e) {}
        }

        // Poll for new transactions every 5 seconds
        setInterval(async () => {
            try {
                // Build current URL params to maintain filters
                const currentParams = new URLSearchParams(window.location.search);
                currentParams.set('_ajax', '1');
                
                const response = await fetch('{{ route("admin.reports.transactions") }}?' + currentParams.toString(), {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });
                
                if (!response.ok) return;
                
                const html = await response.text();
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                
                // Count pending badges in the fetched HTML
                const pendingBadges = doc.querySelectorAll('.badge.bg-warning');
                const newPendingCount = pendingBadges.length;
                
                if (newPendingCount > lastPendingCount) {
                    // New pending transaction detected — refresh page
                    playNotificationSound();
                    window.location.reload();
                } else if (newPendingCount !== lastPendingCount) {
                    // Pending count changed (e.g. confirmed) — refresh to update
                    window.location.reload();
                }
                
                lastPendingCount = newPendingCount;
            } catch (e) {
                // Silent fail
            }
        }, 5000);
    })();
</script>
@endsection
