@extends('layouts.admin')

@section('title', 'System Settings')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold mb-0">System Settings</h2>
    <button type="submit" form="settingsForm" class="btn btn-gradient rounded-pill px-4 shadow-sm">
        <i class="bi bi-save me-2"></i> Save Changes
    </button>
</div>

<div class="row g-4">
    <div class="col-lg-3 d-none d-lg-block">
        <div class="glass-card p-0 sticky-top" style="top: 100px;">
            <div class="list-group list-group-flush rounded-3">
                <a href="#store-info" class="list-group-item list-group-item-action bg-transparent border-bottom-0 py-3 active fw-semibold" style="color: var(--primary-color);">
                    <i class="bi bi-shop me-2"></i> Store Information
                </a>
                <a href="#pricing-config" class="list-group-item list-group-item-action bg-transparent border-bottom-0 py-3 text-muted">
                    <i class="bi bi-percent me-2"></i> Pricing & Markup
                </a>
                <a href="#tax-config" class="list-group-item list-group-item-action bg-transparent border-bottom-0 py-3 text-muted">
                    <i class="bi bi-calculator me-2"></i> Tax Configuration
                </a>
                <a href="#receipt-settings" class="list-group-item list-group-item-action bg-transparent border-bottom-0 py-3 text-muted">
                    <i class="bi bi-receipt me-2"></i> Receipt Settings
                </a>
                <a href="#system-settings" class="list-group-item list-group-item-action bg-transparent py-3 text-muted">
                    <i class="bi bi-pc-display me-2"></i> Terminal Settings
                </a>
            </div>
        </div>
    </div>

    <div class="col-lg-9">
        <form id="settingsForm" action="{{ route('admin.settings.store') }}" method="POST">
            @csrf
            
            <!-- Store Info -->
            <div id="store-info" class="glass-card p-4 mb-4">
                <h5 class="fw-bold mb-4 border-bottom pb-2">Store Information</h5>
                
                <div class="row mb-4">
                    <div class="col-md-12">
                        <label class="form-label fw-semibold">Store Name</label>
                        <input type="text" name="store_name" class="form-control form-control-custom" value="{{ $settings['store_name'] ?? 'PureVibe Kiosk' }}">
                    </div>
                </div>
                
                <div class="row mb-4">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Contact Email</label>
                        <input type="email" name="contact_email" class="form-control form-control-custom" value="{{ $settings['contact_email'] ?? 'support@purevibe.com' }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Contact Phone</label>
                        <input type="text" name="contact_phone" class="form-control form-control-custom" value="{{ $settings['contact_phone'] ?? '(555) 123-4567' }}">
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold">Store Address</label>
                    <textarea name="store_address" class="form-control form-control-custom" rows="3">{{ $settings['store_address'] ?? '123 Grocery Lane&#10;Market District' }}</textarea>
                </div>
            </div>

            <!-- Pricing & Markup -->
            <div id="pricing-config" class="glass-card p-4 mb-4">
                <h5 class="fw-bold mb-1 border-bottom pb-2 d-flex align-items-center gap-2">
                    <i class="bi bi-percent text-primary"></i> Pricing &amp; Markup
                </h5>
                <p class="text-muted small mb-4">The global markup is applied to a product's supplier cost price to calculate its selling price. You can override this per-product in the Products section.</p>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Default Markup Percentage (%)</label>
                        <div class="input-group">
                            <input type="number" step="0.01" min="0" max="9999" name="default_markup_percentage"
                                   id="markupInput"
                                   class="form-control form-control-custom"
                                   value="{{ $settings['default_markup_percentage'] ?? '20' }}"
                                   oninput="updateMarkupPreview()">
                            <span class="input-group-text">%</span>
                        </div>
                        <small class="text-muted">e.g. 20% markup on a ₱100 cost = ₱120 selling price.</small>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Live Preview</label>
                        <div class="glass-card p-3 text-center" style="background: rgba(var(--bs-primary-rgb),.06);">
                            <div class="text-muted small mb-1">Cost: ₱100 &rarr; Selling Price</div>
                            <div class="fw-bold fs-4 text-primary" id="markupPreview">₱120.00</div>
                        </div>
                    </div>
                </div>

                <div class="alert alert-info border-0 rounded-3 small mb-0">
                    <i class="bi bi-info-circle me-2"></i>
                    <strong>How it works:</strong> When a stock entry is approved, if a <em>unit cost</em> is recorded for a product,
                    the system automatically recalculates the product's selling price using:<br>
                    <code class="ms-2">Selling Price = Cost × (1 + Markup%)</code><br>
                    Old stock (sold before the update) keeps its original price in transaction history.
                    New stock reflects the updated selling price going forward.
                </div>
            </div>

            <!-- Tax Config -->
            <div id="tax-config" class="glass-card p-4 mb-4">
                <h5 class="fw-bold mb-4 border-bottom pb-2">Tax Configuration</h5>
                
                <div class="row mb-4">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Default Tax Rate (%)</label>
                        <div class="input-group">
                            <input type="number" step="0.01" name="default_tax_rate" class="form-control form-control-custom" value="{{ $settings['default_tax_rate'] ?? '12' }}">
                            <span class="input-group-text">%</span>
                        </div>
                    </div>
                    <div class="col-md-6 d-flex align-items-end pb-2">
                        <div class="form-check form-switch fs-5">
                            <input name="prices_include_tax" value="1" class="form-check-input" type="checkbox" role="switch" {{ isset($settings['prices_include_tax']) && $settings['prices_include_tax'] ? 'checked' : '' }}>
                            <label class="form-check-label fs-6 mt-1 ms-2">Prices include tax</label>
                        </div>
                    </div>
                </div>
                
                <div class="mb-4">
                    <label class="form-label fw-semibold">Tax Name</label>
                    <input type="text" name="tax_name" class="form-control form-control-custom" value="{{ $settings['tax_name'] ?? 'VAT' }}">
                    <small class="text-muted">This name will appear on the customer's receipt.</small>
                </div>
            </div>

            <!-- Receipt Settings -->
            <div id="receipt-settings" class="glass-card p-4 mb-4">
                <h5 class="fw-bold mb-4 border-bottom pb-2">Receipt Settings</h5>
                
                <div class="mb-4">
                    <label class="form-label fw-semibold">Receipt Header Message</label>
                    <textarea name="receipt_header" class="form-control form-control-custom" rows="2">{{ $settings['receipt_header'] ?? 'Welcome to PureVibe!' }}</textarea>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold">Receipt Footer Message</label>
                    <textarea name="receipt_footer" class="form-control form-control-custom" rows="2">{{ $settings['receipt_footer'] ?? 'Thank you for shopping with us!&#10;Please come again.' }}</textarea>
                </div>
            </div>

            <!-- System Settings -->
            <div id="system-settings" class="glass-card p-4 mb-4">
                <h5 class="fw-bold mb-4 border-bottom pb-2">Terminal Settings</h5>
                
                <div class="row mb-4">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Idle Timeout (seconds)</label>
                        <input type="number" name="idle_timeout" class="form-control form-control-custom" value="{{ $settings['idle_timeout'] ?? '120' }}">
                        <small class="text-muted">Return to welcome screen after inactivity.</small>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Currency Symbol</label>
                        <input type="text" name="currency_symbol" class="form-control form-control-custom" value="{{ $settings['currency_symbol'] ?? '₱' }}">
                    </div>
                </div>


            </div>
            
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Markup preview
    window.updateMarkupPreview = function() {
        const markup = parseFloat(document.getElementById('markupInput').value) || 0;
        const selling = 100 * (1 + markup / 100);
        document.getElementById('markupPreview').textContent = '₱' + selling.toFixed(2);
    };
    document.addEventListener('DOMContentLoaded', function() {
        updateMarkupPreview();
    });

    // Simple script to highlight active section on scroll
    document.addEventListener('DOMContentLoaded', function() {
        const links = document.querySelectorAll('.list-group-item');
        
        links.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const targetId = this.getAttribute('href').substring(1);
                const targetElement = document.getElementById(targetId);
                
                links.forEach(l => {
                    l.classList.remove('active', 'fw-semibold');
                    l.classList.add('text-muted');
                    l.style.color = '';
                });
                
                this.classList.add('active', 'fw-semibold');
                this.classList.remove('text-muted');
                this.style.color = 'var(--primary-color)';
                
                window.scrollTo({
                    top: targetElement.offsetTop - 100,
                    behavior: 'smooth'
                });
            });
        });
    });
</script>
@endsection
