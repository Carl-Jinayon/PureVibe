@extends('layouts.admin')

@section('title', 'Dashboard')

@section('styles')
<style>
    /* ── Live Pending Banner ─────────────────────────────── */
    #pendingBanner {
        display: none;
        background: linear-gradient(135deg, #f59e0b, #ef4444);
        color: white;
        border-radius: 12px;
        padding: 0.9rem 1.25rem;
        margin-bottom: 1.25rem;
        align-items: center;
        gap: 0.75rem;
        animation: bannerPulse 1.8s ease-in-out infinite;
        box-shadow: 0 4px 20px rgba(239, 68, 68, 0.35);
    }
    #pendingBanner.visible { display: flex; }

    @keyframes bannerPulse {
        0%, 100% { box-shadow: 0 4px 20px rgba(239, 68, 68, 0.35); }
        50%       { box-shadow: 0 4px 32px rgba(239, 68, 68, 0.65); }
    }

    .pending-count-bubble {
        background: white;
        color: #ef4444;
        font-weight: 800;
        font-size: 1.1rem;
        border-radius: 50%;
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    /* ── Live indicator dot ──────────────────────────────── */
    .live-dot {
        display: inline-block;
        width: 8px;
        height: 8px;
        background: #22c55e;
        border-radius: 50%;
        margin-right: 6px;
        animation: livePing 1.5s ease-in-out infinite;
        vertical-align: middle;
    }
    @keyframes livePing {
        0%, 100% { opacity: 1; transform: scale(1); }
        50%       { opacity: 0.4; transform: scale(0.7); }
    }

    /* ── Smooth number flash ─────────────────────────────── */
    @keyframes numFlash {
        0%   { color: inherit; }
        30%  { color: #4f46e5; }
        100% { color: inherit; }
    }
    .num-updated { animation: numFlash 0.8s ease-out; }

    /* ── New row highlight ───────────────────────────────── */
    @keyframes rowHighlight {
        from { background-color: rgba(79, 70, 229, 0.12); }
        to   { background-color: transparent; }
    }
    .row-new { animation: rowHighlight 2s ease-out forwards; }

    /* ── Toast container ─────────────────────────────────── */
    #toastContainer {
        position: fixed;
        bottom: 1.5rem;
        right: 1.5rem;
        z-index: 9999;
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
        max-width: 340px;
    }

    .live-toast {
        background: white;
        border-radius: 14px;
        box-shadow: 0 8px 30px rgba(0,0,0,0.18);
        padding: 1rem 1.25rem;
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
        border-left: 4px solid #f59e0b;
        animation: toastSlide 0.35s ease-out;
    }
    .live-toast.toast-success { border-left-color: #22c55e; }
    @keyframes toastSlide {
        from { opacity: 0; transform: translateX(60px); }
        to   { opacity: 1; transform: translateX(0); }
    }
    .live-toast .toast-icon {
        font-size: 1.4rem;
        color: #f59e0b;
        flex-shrink: 0;
    }
    .live-toast.toast-success .toast-icon { color: #22c55e; }
    .live-toast .toast-body { flex: 1; }
    .live-toast .toast-title { font-weight: 700; font-size: 0.9rem; margin-bottom: 2px; }
    .live-toast .toast-text  { font-size: 0.8rem; color: #6b7280; }
    .live-toast .toast-close {
        background: none; border: none; font-size: 1rem;
        color: #9ca3af; cursor: pointer; padding: 0; line-height: 1;
    }

    /* ── Last-updated stamp ──────────────────────────────── */
    #lastUpdated {
        font-size: 0.72rem;
        color: #9ca3af;
    }

    /* Confirm button in the live table */
    .btn-confirm-txn {
        font-size: 0.78rem;
        padding: 0.25rem 0.6rem;
    }
</style>
@endsection

@section('content')

{{-- ── Toast Container ──────────────────────────────────────── --}}
<div id="toastContainer"></div>

{{-- ── Pending Orders Alert Banner ──────────────────────────── --}}
<div id="pendingBanner">
    <div class="pending-count-bubble" id="pendingCountBubble">0</div>
    <div class="flex-grow-1">
        <div class="fw-bold fs-6">Pending Order<span id="pendingPlural"></span> Awaiting Confirmation</div>
        <div style="font-size:0.82rem; opacity:0.9;">New kiosk order<span id="pendingPlural2"></span> received — please confirm to process.</div>
    </div>
    <a href="{{ route('admin.reports.transactions') }}" class="btn btn-sm btn-light fw-semibold rounded-pill px-3">
        <i class="bi bi-arrow-right-circle me-1"></i> Review
    </a>
</div>

{{-- ── Welcome Row ──────────────────────────────────────────── --}}
<div class="row mb-4">
    <div class="col-12">
        <div class="glass-card p-4 d-flex justify-content-between align-items-center">
            <div>
                <h3 class="fw-bold mb-1">Welcome back, {{ auth()->user()->name ?? 'Admin' }}!</h3>
                <p class="text-muted mb-0">
                    <span class="live-dot"></span>
                    Live dashboard &mdash; {{ \Carbon\Carbon::now()->format('F j, Y') }}
                    &nbsp;<span id="lastUpdated"></span>
                </p>
            </div>
            <div class="d-none d-md-block">
                <a href="{{ route('admin.reports.index') }}" class="btn btn-gradient px-4 py-2 rounded-pill shadow-sm">
                    <i class="bi bi-file-earmark-bar-graph me-2"></i> View Reports
                </a>
            </div>
        </div>
    </div>
</div>

{{-- ── Metrics Row 1 (Static — totals) ────────────────────── --}}
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
                    <h2 class="fw-bold mb-0">{{ number_format($currentInventoryCount ?? 0) }}</h2>
                </div>
                <div class="rounded p-3" style="background-color:rgba(124,58,237,0.1);color:var(--accent-color);">
                    <i class="bi bi-clipboard-data fs-4"></i>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ── Metrics Row 2 (Live — sales & low stock) ────────────── --}}
<div class="row g-4 mb-4">
    <div class="col-md-6 col-lg-3">
        <div class="glass-card p-4">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <p class="text-muted mb-1 fw-semibold">Today's Sales</p>
                    <h3 class="fw-bold mb-0 text-success" id="stat-today">₱{{ number_format($todaySales ?? 0, 2) }}</h3>
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
                    <h3 class="fw-bold mb-0 text-success" id="stat-weekly">₱{{ number_format($weeklySales ?? 0, 2) }}</h3>
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
                    <h3 class="fw-bold mb-0 text-success" id="stat-monthly">₱{{ number_format($monthlySales ?? 0, 2) }}</h3>
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
                    <h3 class="fw-bold mb-0 text-danger" id="stat-lowstock">{{ number_format($lowStockAlertsCount ?? 0) }}</h3>
                </div>
                <div class="rounded p-3 bg-danger bg-opacity-10 text-danger">
                    <i class="bi bi-exclamation-triangle fs-4"></i>
                </div>
            </div>
            <a href="{{ route('admin.inventory.low-stock') }}" class="text-decoration-none text-danger small mt-2 d-inline-block">View Details <i class="bi bi-arrow-right"></i></a>
        </div>
    </div>
</div>

{{-- ── Bottom Row: Transactions + Low Stock ─────────────────── --}}
<div class="row g-4 mb-4">

    {{-- Recent Transactions (live) --}}
    <div class="col-lg-7">
        <div class="glass-card h-100">
            <div class="card-header-gradient d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <span class="live-dot" style="background:#fff; width:6px; height:6px;"></span>
                    Recent Transactions
                </h5>
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
                        <tbody id="transactionsTbody">
                            @forelse($recentTransactions ?? [] as $transaction)
                            <tr data-txn-id="{{ $transaction->id }}">
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
                                        <form action="{{ route('admin.reports.transactions.confirm', $transaction->id) }}" method="POST" class="d-inline confirm-form">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success rounded-pill px-2 py-0 shadow-sm btn-confirm-txn" title="Confirm">
                                                <i class="bi bi-check-lg"></i>
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr id="noTxnRow">
                                <td colspan="6" class="text-center py-4 text-muted">No recent transactions found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Low Stock Products (static — changes rarely) --}}
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

@section('scripts')
<script>
const POLL_INTERVAL_MS = 5000;   // check every 5 seconds
const LIVE_DATA_URL    = '{{ route('admin.dashboard.live-data') }}';
const CSRF_TOKEN       = '{{ csrf_token() }}';

let previousPendingCount = {{ \App\Models\Transaction::where('status','pending')->count() }};
let knownTxnIds = new Set([{{ $recentTransactions->pluck('id')->join(',') }}]);

// ── Helpers ─────────────────────────────────────────────────────
function formatCurrency(amount) {
    return '₱' + parseFloat(amount).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
}

function flashElement(el) {
    el.classList.remove('num-updated');
    void el.offsetWidth; // reflow
    el.classList.add('num-updated');
}

function updateStat(id, newValue) {
    const el = document.getElementById(id);
    if (!el) return;
    if (el.textContent.trim() !== newValue) {
        el.textContent = newValue;
        flashElement(el);
    }
}

// ── Toast Notifications ─────────────────────────────────────────
function showToast(title, text, type = 'warning') {
    const container = document.getElementById('toastContainer');
    const toast = document.createElement('div');
    toast.className = 'live-toast' + (type === 'success' ? ' toast-success' : '');
    toast.innerHTML = `
        <i class="bi ${type === 'success' ? 'bi-check-circle-fill' : 'bi-bell-fill'} toast-icon"></i>
        <div class="toast-body">
            <div class="toast-title">${title}</div>
            <div class="toast-text">${text}</div>
        </div>
        <button class="toast-close" onclick="this.closest('.live-toast').remove()">&times;</button>
    `;
    container.appendChild(toast);
    setTimeout(() => {
        toast.style.transition = 'opacity 0.4s, transform 0.4s';
        toast.style.opacity    = '0';
        toast.style.transform  = 'translateX(60px)';
        setTimeout(() => toast.remove(), 400);
    }, 6000);
}

// ── Pending Banner ───────────────────────────────────────────────
function updatePendingBanner(count) {
    const banner = document.getElementById('pendingBanner');
    const bubble = document.getElementById('pendingCountBubble');
    const p1     = document.getElementById('pendingPlural');
    const p2     = document.getElementById('pendingPlural2');

    if (count > 0) {
        bubble.textContent = count;
        p1.textContent     = count !== 1 ? 's' : '';
        p2.textContent     = count !== 1 ? 's' : '';
        banner.classList.add('visible');
    } else {
        banner.classList.remove('visible');
    }
}

// ── Transactions Table ───────────────────────────────────────────
function buildStatusBadge(status) {
    if (status === 'completed') return '<span class="badge bg-success badge-custom">Completed</span>';
    if (status === 'pending')   return '<span class="badge bg-warning text-dark badge-custom">Pending</span>';
    return `<span class="badge bg-danger badge-custom">${status.charAt(0).toUpperCase() + status.slice(1)}</span>`;
}

function buildConfirmAction(txn) {
    if (txn.status !== 'pending') return '<span class="text-muted">-</span>';
    return `
        <form action="${txn.confirm_url}" method="POST" class="d-inline confirm-form">
            <input type="hidden" name="_token" value="${CSRF_TOKEN}">
            <button type="submit" class="btn btn-sm btn-success rounded-pill px-2 py-0 shadow-sm btn-confirm-txn" title="Confirm">
                <i class="bi bi-check-lg"></i>
            </button>
        </form>`;
}

function updateTransactionsTable(transactions) {
    const tbody = document.getElementById('transactionsTbody');
    if (!tbody) return;

    const newIds = new Set(transactions.map(t => t.id));
    const freshIds = [...newIds].filter(id => !knownTxnIds.has(id));

    // Rebuild rows
    if (transactions.length === 0) {
        tbody.innerHTML = '<tr id="noTxnRow"><td colspan="6" class="text-center py-4 text-muted">No recent transactions found.</td></tr>';
        knownTxnIds = newIds;
        return;
    }

    const rows = transactions.map(t => {
        const isNew = freshIds.includes(t.id);
        return `<tr data-txn-id="${t.id}" class="${isNew ? 'row-new' : ''}">
            <td><span class="fw-medium">#${t.transaction_number}</span></td>
            <td>${t.created_at}</td>
            <td>${t.items_count}</td>
            <td class="fw-bold">${formatCurrency(t.total_amount)}</td>
            <td>${buildStatusBadge(t.status)}</td>
            <td class="text-center">${buildConfirmAction(t)}</td>
        </tr>`;
    }).join('');

    tbody.innerHTML = rows;
    knownTxnIds = newIds;

    // Attach confirm form listeners
    attachConfirmListeners();
}

function attachConfirmListeners() {
    document.querySelectorAll('#transactionsTbody .confirm-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            if (!confirm('Confirm this transaction?')) e.preventDefault();
        });
    });
}

// Initial attach for server-rendered forms
attachConfirmListeners();

// ── Main Poll Function ───────────────────────────────────────────
async function pollDashboard() {
    try {
        const res  = await fetch(LIVE_DATA_URL, { headers: { 'Accept': 'application/json' } });
        if (!res.ok) return;
        const data = await res.json();

        // --- Sales stats ---
        updateStat('stat-today',    formatCurrency(data.today_sales));
        updateStat('stat-weekly',   formatCurrency(data.weekly_sales));
        updateStat('stat-monthly',  formatCurrency(data.monthly_sales));
        updateStat('stat-lowstock', data.low_stock_count.toString());

        // --- Pending banner & toast ---
        const newPending = data.pending_count;
        updatePendingBanner(newPending);

        if (newPending > previousPendingCount) {
            const added = newPending - previousPendingCount;
            showToast(
                `🔔 ${added} New Order${added > 1 ? 's' : ''} Incoming!`,
                `${newPending} order${newPending > 1 ? 's' : ''} pending confirmation.`
            );
        }
        previousPendingCount = newPending;

        // --- Transactions table ---
        updateTransactionsTable(data.recent_transactions);

        // --- Last updated stamp ---
        const lu = document.getElementById('lastUpdated');
        if (lu) {
            const t = new Date(data.timestamp);
            lu.textContent = 'Updated ' + t.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', second: '2-digit' });
        }

    } catch (err) {
        // Silent fail — network hiccup, retry on next tick
    }
}

// Kick off on load, then repeat
pollDashboard();
setInterval(pollDashboard, POLL_INTERVAL_MS);
</script>
@endsection
