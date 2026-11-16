@extends('layouts.app')
@section('content')
<div class="dashboard-wrap"><div class="container">
<div class="dashboard-hero mb-4"><div><span class="eyebrow">Farmer studio</span><h1>Run {{ auth()->user()->farmerProfile?->stall_name ?? auth()->user()->name }}.</h1><p>Manage stock, approve pre-orders and keep pickup promises on track.</p></div><div class="d-flex gap-2"><a href="{{ route('farmer.products') }}" class="btn btn-outline-dark rounded-pill">Manage stock</a><a href="{{ route('farmer.orders') }}" class="btn btn-success rounded-pill">Incoming orders</a><a href="{{ route('farmer.stock-templates') }}" class="btn btn-outline-dark rounded-pill">Weekly templates</a></div></div>
<div class="row g-3 mb-4">@foreach([['products','Products','bi-basket'],['available','In stock','bi-check-circle'],['low_stock','Low stock','bi-exclamation-triangle'],['pending','Pending orders','bi-hourglass-split'],['accepted','Accepted','bi-check2'],['ready','Ready','bi-box-seam'],['completed','Completed','bi-patch-check']] as $s)<div class="col-6 col-md-4 col-xl-2"><div class="stat-card h-100"><i class="bi {{ $s[2] }}"></i><small>{{ $s[1] }}</small><strong>{{ $stats[$s[0]] }}</strong></div></div>@endforeach</div>
<div class="row g-4"><div class="col-xl-8"><div class="panel"><div class="panel-head"><div><span class="eyebrow">Last 7 days</span><h4 class="mb-0">Completed sales</h4></div><strong class="text-success">Rs {{ number_format($stats['completed_revenue']) }}</strong></div><div class="sales-chart">@foreach($salesValues as $i=>$value)<div class="sales-col"><div class="sales-bar" style="height:{{ max(8,min(100,$value > 0 ? ($value / max(1,$salesValues->max()))*100 : 8)) }}%" title="Rs {{ number_format($value) }}"></div><small>{{ $salesLabels[$i] }}</small></div>@endforeach</div></div></div><div class="col-xl-4"><div class="panel h-100"><div class="panel-head"><div><span class="eyebrow">Pipeline</span><h4 class="mb-0">Order revenue</h4></div></div><div class="display-5 fw-bold text-success">Rs {{ number_format($stats['revenue']) }}</div><div class="small text-muted mt-2">{{ $stats['rating'] }} ★ average</div><p class="text-muted">Accepted + ready + completed order value.</p><hr><div class="d-flex justify-content-between"><span>Pending</span><b>{{ $stats['pending'] }}</b></div><div class="d-flex justify-content-between mt-2"><span>Ready</span><b>{{ $stats['ready'] }}</b></div></div></div></div>
<div class="row g-4 mt-1"><div class="col-xl-7"><div class="panel"><div class="panel-head"><div><span class="eyebrow">Action queue</span><h4 class="mb-0">Latest orders</h4></div><a href="{{ route('farmer.orders') }}">View all</a></div>@forelse($orders as $o)<a class="order-card-link" href="{{ route('farmer.orders.show',$o) }}"><div class="order-row"><div><b>#{{ $o->order_number }}</b><small>{{ $o->customer->name }} · {{ $o->pickup_date->format('d M Y') }}</small></div><span class="status status-{{ $o->status }}">{{ ucfirst($o->status) }}</span><strong>Rs {{ number_format($o->total_amount) }}</strong></div></a>@empty<div class="empty-state">No incoming orders.</div>@endforelse</div><div class="panel recent-reviews-clean">
    <div class="panel-head">
        <div>
            <span class="eyebrow">Feedback</span>
            <h4 class="mb-0">Recent reviews</h4>
        </div>
    </div>

    @forelse($reviews as $r)
        @php
            $name = $r->customer?->name ?? 'Customer';
            $initials = collect(preg_split('/\s+/', trim($name)))
                ->filter()
                ->map(fn ($part) => strtoupper(substr($part, 0, 1)))
                ->take(2)
                ->join('');
            $initials = $initials ?: 'C';
        @endphp

        <article class="recent-review-item">

            <div class="recent-review-header">

                <div class="recent-review-customer">
                    <div class="recent-review-avatar">{{ $initials }}</div>

                    <div class="recent-review-customer-text">
                        <strong>{{ $name }}</strong>
                        <span>{{ $r->created_at?->format('d M Y') ?? 'Recent' }}</span>
                    </div>
                </div>

                <div class="recent-review-rating">
                    <span class="rating-number">{{ $r->rating }}.0</span>

                    <span class="rating-stars" aria-label="{{ $r->rating }} out of 5">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="{{ $i <= $r->rating ? 'active' : '' }}">★</i>
                        @endfor
                    </span>
                </div>

            </div>


            <div class="recent-review-comment">
                <i class="bi bi-quote"></i>

                <div>
                    <p>
                        {{ $r->comment ?: 'No written comment.' }}
                    </p>
                </div>
            </div>


            @if($r->farmer_reply)

                <div class="recent-review-reply">

                    <div class="recent-review-reply-top">
                        <span>
                            <i class="bi bi-reply-fill"></i>
                            Your reply
                        </span>

                        <small>
                            Response to customer
                        </small>
                    </div>

                    <p>
                        {{ $r->farmer_reply }}
                    </p>

                </div>

            @else

                <form
                    method="post"
                    action="{{ route('reviews.reply', $r) }}"
                    class="recent-review-reply-form"
                >
                    @csrf

                    <div class="recent-review-input-wrap">
                        <input
                            type="text"
                            name="farmer_reply"
                            maxlength="1000"
                            required
                            placeholder="Write a reply..."
                        >

                        <button type="submit">
                            <i class="bi bi-send"></i>
                            Reply
                        </button>
                    </div>
                </form>

            @endif

        </article>

    @empty

        <div class="recent-reviews-empty">

            <div class="recent-reviews-empty-icon">
                <i class="bi bi-chat-heart"></i>
            </div>

            <strong>No reviews yet</strong>

            <span>
                Completed-order feedback will appear here.
            </span>

        </div>

    @endforelse
</div></div><div class="col-xl-5">
    <div class="panel farmer-watchlist-final mb-4">

        <div class="panel-head">
            <div>
                <span class="eyebrow">Stock</span>
                <h4 class="mb-0">Watch list</h4>
                <small class="farmer-watch-subtitle">Current inventory at a glance</small>
            </div>

            <a href="{{ route('farmer.products') }}">
                Manage
            </a>
        </div>

        <div class="farmer-watch-items">

            @forelse($products as $p)

                @php
                    $stock = (int) $p->stock_quantity;
                    $maxStock = max(1, (int) $products->max('stock_quantity'));
                    $stockPercent = min(100, max(7, ($stock / $maxStock) * 100));
                    $isLow = $stock <= 5;
                    $isSoldOut = !$p->is_available || $stock <= 0;
                @endphp

                <div class="farmer-watch-item">

                    <div class="farmer-watch-top">

                        <div class="farmer-watch-product">

                            @php
                                $watchCategory = strtolower(trim((string) ($p->category?->name ?? '')));
                                $watchIcon = match ($watchCategory) {
                                    'fruits' => 'bi-apple',
                                    'dairy' => 'bi-cup-hot',
                                    'herbs' => 'bi-flower1',
                                    'baked goods', 'bakery', 'baked-goods' => 'bi-basket',
                                    'vegetables', 'vegetable' => 'bi-basket',
                                    default => 'bi-basket',
                                };
                            @endphp
                            <div class="farmer-watch-icon" aria-hidden="true">
                                <i class="bi {{ $watchIcon }}"></i>
                            </div>

                            <div class="farmer-watch-copy">

                                <strong>
                                    {{ $p->name }}
                                </strong>

                                <span>
                                    {{ $p->category?->name ?? 'Product' }}
                                    <b>·</b>
                                    Rs {{ number_format($p->price, 2) }}
                                    / {{ $p->unit }}
                                </span>

                            </div>

                        </div>


                        @if($isSoldOut)

                            <span class="farmer-stock-badge farmer-stock-badge-out">
                                Sold out
                            </span>

                        @elseif($isLow)

                            <span class="farmer-stock-badge farmer-stock-badge-low">
                                Low stock
                            </span>

                        @else

                            <span class="farmer-stock-badge farmer-stock-badge-ok">
                                In stock
                            </span>

                        @endif

                    </div>


                    <div class="farmer-watch-bottom">

                        <div class="farmer-watch-progress">
                            <span style="width: {{ $stockPercent }}%"></span>
                        </div>

                        <strong class="{{ $isLow || $isSoldOut ? 'danger-stock' : '' }}">
                            {{ $stock }} {{ $p->unit }}
                        </strong>

                    </div>

                </div>

            @empty

                <div class="farmer-watch-empty">
                    <i class="bi bi-box-seam"></i>
                    <strong>No products yet</strong>
                    <span>Add products to start tracking stock.</span>
                </div>

            @endforelse

        </div>

    </div>

</div></div>

<div class="panel mt-4 farmer-best-final">

    <div class="panel-head">
        <div>
            <span class="eyebrow">Sales insights</span>
            <h4 class="mb-0">Best-selling products</h4>
            <small class="farmer-best-subtitle">Products generating the most completed sales</small>
        </div>

        <a href="{{ route('farmer.orders.export') }}">
            Export CSV
        </a>
    </div>

    @php
        $maxSold = max(1, (int) $topProducts->max('sold_qty'));
    @endphp

    <div class="farmer-best-list">

        @forelse($topProducts as $row)

            @php
                $soldQty = (int) $row->sold_qty;
                $barWidth = min(100, max(8, ($soldQty / $maxSold) * 100));
            @endphp

            <article class="farmer-best-item">

                <div class="farmer-best-rank">
                    {{ $loop->iteration }}
                </div>


                <div class="farmer-best-main">

                    <div class="farmer-best-title-row">

                        <div>
                            <strong>
                                {{ $row->product?->name ?? 'Product' }}
                            </strong>

                            <span>
                                {{ $soldQty }}
                                {{ $row->product?->unit ?? 'units' }}
                                sold
                            </span>
                        </div>

                        <b>
                            Rs {{ number_format($row->sold_value) }}
                        </b>

                    </div>


                    <div class="farmer-best-progress">
                        <span style="width: {{ $barWidth }}%"></span>
                    </div>

                </div>

            </article>

        @empty

            <div class="farmer-best-empty">

                <div class="farmer-best-empty-icon">
                    <i class="bi bi-bar-chart"></i>
                </div>

                <strong>No sales insights yet</strong>

                <span>
                    Complete orders to build your best-selling products report.
                </span>

            </div>

        @endforelse

    </div>

</div>
</div></div>

<style>
/* ONLY the Recent Reviews panel. No other section is styled here. */
.recent-reviews-clean {
    overflow: hidden;
}

.recent-reviews-clean .panel-head {
    margin-bottom: 4px;
}

.recent-review-item {
    padding: 15px 0;
}

.recent-review-item + .recent-review-item {
    border-top: 1px solid var(--line);
}

.recent-review-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 14px;
}

.recent-review-customer {
    display: flex;
    align-items: center;
    gap: 10px;
    min-width: 0;
}

.recent-review-avatar {
    width: 38px;
    height: 38px;
    flex: 0 0 38px;
    display: grid;
    place-items: center;
    border-radius: 11px;
    background: linear-gradient(135deg, #13896e, #4bc49c);
    color: #fff;
    font: 800 .72rem Manrope, sans-serif;
}

.recent-review-customer-text {
    min-width: 0;
}

.recent-review-customer-text strong,
.recent-review-customer-text span {
    display: block;
}

.recent-review-customer-text strong {
    color: var(--ink);
    font-size: .83rem;
    font-weight: 800;
    line-height: 1.2;
}

.recent-review-customer-text span {
    margin-top: 3px;
    color: var(--muted);
    font-size: .66rem;
}

.recent-review-rating {
    display: flex;
    align-items: center;
    gap: 7px;
    flex: 0 0 auto;
    padding: 6px 9px;
    border: 1px solid var(--line);
    border-radius: 999px;
    background: var(--surface-2);
}

.recent-review-rating .rating-number {
    color: var(--ink);
    font: 800 .68rem Manrope, sans-serif;
}

.recent-review-rating .rating-stars {
    display: inline-flex;
    gap: 1px;
    color: #d4dcd8;
    font-size: .75rem;
    line-height: 1;
}

.recent-review-rating .rating-stars i {
    font-style: normal;
}

.recent-review-rating .rating-stars i.active {
    color: #f2b51a;
}

.recent-review-comment {
    display: flex;
    gap: 8px;
    margin-top: 10px;
    padding: 11px 12px;
    border: 1px solid var(--line);
    border-radius: 14px;
    background: var(--surface-2);
}

.recent-review-comment > i {
    flex: 0 0 auto;
    margin-top: 1px;
    color: #78c5a4;
    font-size: .95rem;
}

.recent-review-comment p {
    margin: 0;
    color: var(--ink);
    font-size: .76rem;
    line-height: 1.52;
    overflow-wrap: anywhere;
}

.recent-review-reply {
    margin-top: 9px;
    padding: 10px 12px;
    border-left: 3px solid var(--green);
    border-radius: 0 12px 12px 0;
    background: color-mix(in srgb, var(--green) 7%, var(--surface) 93%);
}

.recent-review-reply-top {
    display: flex;
    align-items: baseline;
    justify-content: space-between;
    gap: 10px;
}

.recent-review-reply-top span {
    color: var(--green);
    font-size: .66rem;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: .07em;
}

.recent-review-reply-top span i {
    margin-right: 4px;
}

.recent-review-reply-top small {
    color: var(--muted);
    font-size: .61rem;
}

.recent-review-reply p {
    margin: 6px 0 0;
    color: var(--ink);
    font-size: .72rem;
    line-height: 1.48;
    overflow-wrap: anywhere;
}

.recent-review-reply-form {
    margin-top: 9px;
}

.recent-review-input-wrap {
    display: flex;
    align-items: center;
    gap: 7px;
    min-height: 37px;
    padding: 4px;
    border: 1px solid var(--line);
    border-radius: 12px;
    background: var(--surface);
}

.recent-review-input-wrap input {
    min-width: 0;
    flex: 1;
    border: 0;
    outline: 0;
    padding: 6px 7px;
    background: transparent;
    color: var(--ink);
    font-size: .72rem;
}

.recent-review-input-wrap input::placeholder {
    color: var(--muted);
}

.recent-review-input-wrap button {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    flex: 0 0 auto;
    border: 0;
    border-radius: 9px;
    min-height: 29px;
    padding: 0 10px;
    background: var(--green);
    color: #fff;
    font-size: .67rem;
    font-weight: 700;
}

.recent-reviews-empty {
    display: grid;
    justify-items: center;
    gap: 5px;
    padding: 28px 8px 10px;
    text-align: center;
}

.recent-reviews-empty-icon {
    width: 40px;
    height: 40px;
    display: grid;
    place-items: center;
    margin-bottom: 2px;
    border-radius: 12px;
    background: var(--surface-2);
    color: var(--green);
}

.recent-reviews-empty strong {
    color: var(--ink);
    font-size: .77rem;
}

.recent-reviews-empty span {
    color: var(--muted);
    font-size: .66rem;
}

@media (max-width: 767.98px) {
    .recent-review-header {
        align-items: flex-start;
        flex-direction: column;
    }

    .recent-review-rating {
        margin-left: 48px;
    }

    .recent-review-input-wrap {
        flex-wrap: wrap;
    }

    .recent-review-input-wrap input {
        width: 100%;
    }

    .recent-review-input-wrap button {
        width: 100%;
        justify-content: center;
    }
}
</style>


<style>
/* Farmer Watch List + Best-selling ONLY.
   Latest Orders and Recent Reviews are intentionally untouched. */

.farmer-watchlist-final {
    overflow: hidden;
}

.farmer-watchlist-final .panel-head {
    margin-bottom: 2px;
}

.farmer-watch-subtitle,
.farmer-best-subtitle {
    display: block;
    margin-top: 3px;
    color: var(--muted);
    font-size: .66rem;
}

.farmer-watch-items {
    margin-top: 2px;
}

.farmer-watch-item {
    padding: 14px 0;
}

.farmer-watch-item + .farmer-watch-item {
    border-top: 1px solid var(--line);
}

.farmer-watch-top {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 12px;
}

.farmer-watch-product {
    display: flex;
    align-items: center;
    gap: 10px;
    min-width: 0;
    flex: 1;
}

.farmer-watch-icon {
    width: 36px;
    height: 36px;
    flex: 0 0 36px;
    display: grid;
    place-items: center;
    border-radius: 11px;
    background: var(--surface-2);
    color: var(--green);
    font-size: .95rem;
    line-height: 1;
}

.farmer-watch-icon i {
    display: inline-block;
    line-height: 1;
}

.farmer-watch-copy {
    min-width: 0;
}

.farmer-watch-copy strong {
    display: block;
    color: var(--ink);
    font-size: .83rem;
    font-weight: 800;
    line-height: 1.3;
    overflow-wrap: anywhere;
}

.farmer-watch-copy span {
    display: block;
    margin-top: 3px;
    color: var(--muted);
    font-size: .67rem;
    line-height: 1.35;
}

.farmer-watch-copy span b {
    padding: 0 3px;
    color: #a2afa9;
    font-weight: 600;
}

.farmer-stock-badge {
    flex: 0 0 auto;
    padding: 5px 8px;
    border-radius: 999px;
    font-size: .6rem;
    line-height: 1;
    font-weight: 800;
    letter-spacing: .05em;
    text-transform: uppercase;
}

.farmer-stock-badge-ok {
    color: #087548;
    background: #ebf8f1;
    border: 1px solid #cfe9dc;
}

.farmer-stock-badge-low {
    color: #9f2c24;
    background: #fff0ee;
    border: 1px solid #f3d0cc;
}

.farmer-stock-badge-out {
    color: #7b2a26;
    background: #f8e3e1;
    border: 1px solid #ebc2be;
}

.farmer-watch-bottom {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-top: 9px;
}

.farmer-watch-progress {
    flex: 1;
    height: 7px;
    overflow: hidden;
    border: 1px solid var(--line);
    border-radius: 999px;
    background: var(--surface-2);
}

.farmer-watch-progress span {
    display: block;
    height: 100%;
    border-radius: inherit;
    background: linear-gradient(90deg, #168a6c, #55c89f);
}

.farmer-watch-bottom strong {
    min-width: 60px;
    text-align: right;
    color: var(--green);
    font-size: .7rem;
    white-space: nowrap;
}

.farmer-watch-bottom strong.danger-stock {
    color: #b42318;
}

.farmer-watch-empty,
.farmer-best-empty {
    display: grid;
    justify-items: center;
    gap: 5px;
    padding: 28px 8px 12px;
    text-align: center;
}

.farmer-watch-empty i {
    width: 40px;
    height: 40px;
    display: grid;
    place-items: center;
    margin-bottom: 3px;
    border-radius: 12px;
    background: var(--surface-2);
    color: var(--green);
}

.farmer-watch-empty strong,
.farmer-best-empty strong {
    color: var(--ink);
    font-size: .78rem;
}

.farmer-watch-empty span,
.farmer-best-empty span {
    color: var(--muted);
    font-size: .66rem;
    line-height: 1.45;
}

.farmer-best-final {
    overflow: hidden;
}

.farmer-best-list {
    margin-top: 4px;
}

.farmer-best-item {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 16px 0;
}

.farmer-best-item + .farmer-best-item {
    border-top: 1px solid var(--line);
}

.farmer-best-rank {
    width: 38px;
    height: 38px;
    flex: 0 0 38px;
    display: grid;
    place-items: center;
    border-radius: 12px;
    background: linear-gradient(135deg, #f0f8f3, #fff3d9);
    color: var(--green);
    font: 800 .78rem Manrope, sans-serif;
}

.farmer-best-main {
    flex: 1;
    min-width: 0;
}

.farmer-best-title-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 14px;
}

.farmer-best-title-row strong {
    display: block;
    color: var(--ink);
    font-size: .84rem;
    font-weight: 800;
    line-height: 1.25;
    overflow-wrap: anywhere;
}

.farmer-best-title-row span {
    display: block;
    margin-top: 3px;
    color: var(--muted);
    font-size: .67rem;
}

.farmer-best-title-row > b {
    flex: 0 0 auto;
    color: var(--green);
    font-size: .78rem;
    white-space: nowrap;
}

.farmer-best-progress {
    height: 7px;
    margin-top: 9px;
    overflow: hidden;
    border: 1px solid var(--line);
    border-radius: 999px;
    background: var(--surface-2);
}

.farmer-best-progress span {
    display: block;
    height: 100%;
    border-radius: inherit;
    background: linear-gradient(90deg, #10786d, #48bf95);
}

.farmer-best-empty-icon {
    width: 40px;
    height: 40px;
    display: grid;
    place-items: center;
    margin-bottom: 3px;
    border-radius: 12px;
    background: var(--surface-2);
    color: var(--green);
}

html.theme-dark .farmer-stock-badge-ok {
    color: #9ce7c8;
    background: #12392f;
    border-color: #245b4b;
}

html.theme-dark .farmer-stock-badge-low {
    color: #ffb4ac;
    background: #3c211f;
    border-color: #633934;
}

html.theme-dark .farmer-stock-badge-out {
    color: #ffb3aa;
    background: #40221f;
    border-color: #673934;
}

html.theme-dark .farmer-best-rank {
    background: linear-gradient(135deg, #153830, #403517);
}

@media (max-width: 767.98px) {
    .farmer-watch-top {
        align-items: flex-start;
        flex-direction: column;
    }

    .farmer-stock-badge {
        align-self: flex-start;
    }

    .farmer-best-title-row {
        align-items: flex-start;
        flex-direction: column;
        gap: 4px;
    }

    .farmer-best-title-row > b {
        font-size: .76rem;
    }
}
</style>


<style>
/* Farmer dashboard: keep feedback directly under Latest Orders. */
@media (min-width: 1200px) {
    .dashboard-wrap .row.g-4.mt-1 > .col-xl-7 > .recent-reviews-clean {
        margin-top: 1rem !important;
    }
}
</style>

@endsection
