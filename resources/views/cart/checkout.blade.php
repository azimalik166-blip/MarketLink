@extends('layouts.app')

@section('content')
<div class="dashboard-wrap">
    <div class="container">
        <div class="dashboard-hero mb-4">
            <div>
                <span class="eyebrow">Checkout</span>
                <h1>Choose your pickup details</h1>
                <p>Select the exact date and time that works for you. No preset pickup slot is required.</p>
            </div>
            <a href="{{ route('cart.index') }}" class="btn btn-outline-dark rounded-pill">
                <i class="bi bi-arrow-left me-1"></i> Back to cart
            </a>
        </div>

        @if($groups->isNotEmpty())
            <form method="POST" action="{{ route('checkout.store') }}" id="checkoutForm">
                @csrf

                <div class="row g-4 align-items-start">
                    <div class="col-xl-8">
                        @foreach($groups as $group)
                            <section class="panel checkout-group mb-4">
                                <div class="checkout-group-head">
                                    <div class="checkout-farmer-block">
                                        <span class="checkout-farmer-icon"><i class="bi bi-person-badge"></i></span>
                                        <div>
                                            <span class="eyebrow">Farmer</span>
                                            <h4>{{ $group['farmer']->farmerProfile?->stall_name ?? $group['farmer']->name }}</h4>
                                            <p><i class="bi bi-shop me-1"></i>{{ $group['market']?->name ?? 'Market' }}</p>
                                        </div>
                                    </div>
                                    <div class="checkout-group-total">Rs {{ number_format($group['total']) }}</div>
                                </div>

                                <div class="checkout-pickup-box">
                                    <div class="checkout-pickup-title">
                                        <span><i class="bi bi-calendar-heart me-2"></i>Pickup details</span>
                                        <small>Choose a date and time that works for you.</small>
                                    </div>

                                    <div class="row g-3 mt-1">
                                        <div class="col-md-6">
                                            <label class="checkout-label" for="date_{{ md5($group['key']) }}">Pickup date</label>
                                            <div class="checkout-input-wrap">
                                                <i class="bi bi-calendar3 input-leading-icon"></i>
                                                <input
                                                    id="date_{{ md5($group['key']) }}"
                                                    name="groups[{{ $group['key'] }}][pickup_date]"
                                                    type="date"
                                                    class="form-control pickup-date"
                                                    min="{{ now()->toDateString() }}"
                                                    required
                                                >
                                                <button type="button" class="input-picker-btn" data-target="date_{{ md5($group['key']) }}" aria-label="Choose pickup date">
                                                    <i class="bi bi-calendar-event"></i>
                                                </button>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="checkout-label" for="time_{{ md5($group['key']) }}">Pickup time</label>
                                            <div class="checkout-input-wrap">
                                                <i class="bi bi-clock input-leading-icon"></i>
                                                <input
                                                    id="time_{{ md5($group['key']) }}"
                                                    name="groups[{{ $group['key'] }}][pickup_time]"
                                                    type="time"
                                                    class="form-control pickup-time"
                                                    required
                                                >
                                                <button type="button" class="input-picker-btn" data-target="time_{{ md5($group['key']) }}" aria-label="Choose pickup time">
                                                    <i class="bi bi-clock-history"></i>
                                                </button>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <label class="checkout-label" for="notes_{{ md5($group['key']) }}">
                                                Note to farmer <span>(optional)</span>
                                            </label>
                                            <textarea
                                                id="notes_{{ md5($group['key']) }}"
                                                name="groups[{{ $group['key'] }}][notes]"
                                                rows="3"
                                                class="form-control checkout-note"
                                                maxlength="1000"
                                                placeholder="Anything the farmer should know?"
                                            ></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="checkout-items">
                                    <div class="checkout-items-head">
                                        <span><i class="bi bi-bag-check me-1"></i> Your order</span>
                                        <small>{{ $group['items']->sum('quantity') }} item(s)</small>
                                    </div>

                                    @foreach($group['items'] as $item)
                                        @php($product = $item->product)
                                        <div class="checkout-item">
                                            <div class="checkout-item-main">
                                                <span class="checkout-product-media">
                                                    <x-product-media :product="$product" />
                                                </span>
                                                <div class="checkout-item-copy">
                                                    <strong>{{ $product->name }}</strong>
                                                    <small>Qty {{ $item->quantity }} · Rs {{ number_format($product->price, 2) }} / {{ $product->unit }}</small>
                                                </div>
                                            </div>
                                            <strong class="checkout-item-total">Rs {{ number_format($product->price * $item->quantity) }}</strong>
                                        </div>
                                    @endforeach
                                </div>
                            </section>
                        @endforeach
                    </div>

                    <div class="col-xl-4">
                        <aside class="checkout-card">
                            <span class="eyebrow">Order summary</span>
                            <div class="checkout-total">Rs {{ number_format($grandTotal) }}</div>
                            <div class="checkout-summary-row">
                                <span>Farmers</span>
                                <strong>{{ $groups->count() }}</strong>
                            </div>
                            <div class="checkout-summary-row">
                                <span>Pickup method</span>
                                <strong>Market pickup</strong>
                            </div>
                            <div class="checkout-summary-row">
                                <span>Payment</span>
                                <strong>Pay in person</strong>
                            </div>

                            <div class="pay-note">
                                <i class="bi bi-shop-window"></i>
                                <div>
                                    <strong>Pickup only</strong>
                                    <small>Pay each farmer in person when you collect the order.</small>
                                </div>
                            </div>

                            <div class="checkout-summary-tip">
                                <i class="bi bi-calendar-check"></i>
                                <span>You choose the exact pickup date and time for each farmer.</span>
                            </div>

                            <button type="submit" class="btn btn-success w-100 rounded-pill mt-4 py-3">
                                <i class="bi bi-check2-circle me-1"></i> Place pre-orders
                            </button>
                        </aside>
                    </div>
                </div>
            </form>
        @else
            <div class="empty-state">Your cart is empty.</div>
        @endif
    </div>
</div>

<style>
    .checkout-group{overflow:hidden;border-radius:22px;}
    .checkout-group-head{display:flex;justify-content:space-between;align-items:flex-start;gap:20px;padding-bottom:18px;border-bottom:1px solid var(--line);}
    .checkout-farmer-block{display:flex;align-items:center;gap:14px;min-width:0;}
    .checkout-farmer-icon{width:52px;height:52px;border-radius:17px;display:grid;place-items:center;background:linear-gradient(135deg,rgba(12,145,120,.13),rgba(250,185,49,.20));color:var(--green);font-size:1.15rem;flex:0 0 auto;}
    .checkout-farmer-block h4{margin:2px 0 2px;font-size:1.2rem;}
    .checkout-farmer-block p{margin:0;color:var(--muted);font-size:.92rem;}
    .checkout-group-total{color:var(--green);font-weight:800;font-size:1.12rem;white-space:nowrap;}

    .checkout-pickup-box{margin-top:18px;border:1px solid var(--line);border-radius:20px;padding:18px;background:linear-gradient(135deg,rgba(14,149,123,.045),rgba(255,194,61,.055));}
    .checkout-pickup-title{display:flex;justify-content:space-between;align-items:center;gap:12px;flex-wrap:wrap;font-weight:800;}
    .checkout-pickup-title span i{color:var(--green);}
    .checkout-pickup-title small{color:var(--muted);font-weight:500;}
    .checkout-label{display:block;margin:0 0 8px;font-weight:700;font-size:.9rem;}
    .checkout-label span{color:var(--muted);font-weight:500;}

    .checkout-input-wrap{position:relative;display:flex;align-items:center;}
    .checkout-input-wrap .form-control{min-height:50px;border-radius:14px;padding-left:42px;padding-right:48px;border-color:var(--line);background:var(--card);}
    .checkout-input-wrap .form-control:focus{border-color:var(--green);box-shadow:0 0 0 .2rem rgba(12,145,120,.12);}
    .input-leading-icon{position:absolute;left:15px;z-index:2;color:var(--green);pointer-events:none;}
    .input-picker-btn{position:absolute;right:7px;width:36px;height:36px;border:0;border-radius:10px;background:var(--soft);color:var(--green);display:grid;place-items:center;z-index:2;}
    .input-picker-btn:hover{background:rgba(12,145,120,.13);}

    .checkout-note{min-height:102px;border-radius:14px;resize:vertical;}
    .checkout-items{margin-top:18px;border-top:1px solid var(--line);padding-top:14px;}
    .checkout-items-head{display:flex;justify-content:space-between;gap:12px;align-items:center;margin-bottom:8px;font-weight:800;}
    .checkout-items-head i{color:var(--green);}
    .checkout-items-head small{color:var(--muted);font-weight:600;}
    .checkout-item{display:flex;justify-content:space-between;align-items:center;gap:15px;padding:13px 0;border-bottom:1px solid rgba(16,81,70,.10);}
    .checkout-item:last-child{border-bottom:0;padding-bottom:2px;}
    .checkout-item-main{display:flex;align-items:center;gap:12px;min-width:0;}
    .checkout-product-media{width:48px;height:48px;display:block;overflow:hidden;border-radius:14px;background:var(--soft);flex:0 0 auto;}
    .checkout-product-media img,.checkout-product-media picture{width:100%;height:100%;display:block;object-fit:cover;}
    .checkout-item-copy{min-width:0;display:flex;flex-direction:column;gap:4px;}
    .checkout-item-copy strong{font-size:.98rem;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;}
    .checkout-item-copy small{color:var(--muted);font-size:.83rem;}
    .checkout-item-total{white-space:nowrap;color:var(--ink);font-size:.95rem;}

    .checkout-card{border:1px solid var(--line);border-radius:22px;padding:22px;background:linear-gradient(145deg,#fff,rgba(255,248,229,.45));box-shadow:0 16px 36px rgba(13,70,61,.07);}
    .checkout-card .checkout-total{position:static !important;top:auto !important;z-index:auto;display:block;margin:8px 0 16px;color:var(--green);font:800 2.45rem/1 Manrope,sans-serif;letter-spacing:-.04em;}
    .checkout-summary-row{display:flex;justify-content:space-between;gap:12px;padding:11px 0;border-top:1px solid var(--line);font-size:.92rem;}
    .checkout-summary-row span{color:var(--muted);}
    .checkout-summary-row strong{font-weight:750;text-align:right;}
    .pay-note{display:flex;gap:11px;align-items:flex-start;margin-top:16px;padding:14px;border-radius:15px;background:var(--soft);}
    .pay-note>i{color:var(--green);font-size:1.15rem;margin-top:2px;}
    .pay-note strong{display:block;font-size:.92rem;}
    .pay-note small{display:block;color:var(--muted);line-height:1.45;margin-top:2px;}
    .checkout-summary-tip{display:flex;gap:10px;align-items:flex-start;margin-top:12px;padding:13px 14px;border-radius:15px;background:rgba(12,145,120,.07);color:var(--muted);font-size:.86rem;line-height:1.45;}
    .checkout-summary-tip i{color:var(--green);margin-top:2px;}

    @media (max-width: 1199.98px){.checkout-card{position:static;}}
    @media (max-width: 575.98px){
        .checkout-group-head{align-items:flex-start;}
        .checkout-farmer-block{align-items:flex-start;}
        .checkout-farmer-icon{width:46px;height:46px;border-radius:14px;}
        .checkout-group-total{font-size:1rem;}
        .checkout-pickup-box{padding:15px;}
        .checkout-card{padding:18px;}
        .checkout-card .checkout-total{font-size:2.15rem;}
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('checkoutForm');
    if (!form) return;

    const dateInputs = Array.from(form.querySelectorAll('.pickup-date'));
    const timeInputs = Array.from(form.querySelectorAll('.pickup-time'));

    form.querySelectorAll('.input-picker-btn').forEach(function (button) {
        button.addEventListener('click', function () {
            const input = document.getElementById(button.dataset.target);
            if (!input) return;
            input.focus();
            if (typeof input.showPicker === 'function') {
                try { input.showPicker(); return; } catch (e) {}
            }
            input.click();
        });
    });

    dateInputs.forEach(function (input) {
        input.addEventListener('change', function () {
            input.classList.remove('is-invalid');
        });
    });

    timeInputs.forEach(function (input) {
        input.addEventListener('change', function () {
            input.classList.remove('is-invalid');
        });
    });

    form.addEventListener('submit', function (event) {
        let valid = true;
        dateInputs.forEach(function (input) {
            const missing = !input.value;
            input.classList.toggle('is-invalid', missing);
            if (missing) valid = false;
        });
        timeInputs.forEach(function (input) {
            const missing = !input.value;
            input.classList.toggle('is-invalid', missing);
            if (missing) valid = false;
        });
        if (!valid) {
            event.preventDefault();
            const firstInvalid = form.querySelector('.is-invalid');
            firstInvalid?.scrollIntoView({ behavior: 'smooth', block: 'center' });
            firstInvalid?.focus();
        }
    });
});
</script>
@endsection
