@extends('layouts.app')
@section('content')
<div class="container py-5 farmer-orders-page">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <span class="eyebrow">Farmer Studio</span>
            <h1>Incoming pre-orders</h1>
            <p class="text-muted mb-0">Approve, prepare and complete customer pickups.</p>
        </div>
    </div>

    <form class="filter-bar mb-4">
        <div class="row g-2 align-items-end">
            <div class="col-md-4">
                <label>Status</label>
                <select name="status" class="form-select">
                    <option value="">All statuses</option>
                    @foreach(['placed','accepted','ready','completed','cancelled','declined'] as $s)
                        <option value="{{ $s }}" @selected(request('status') === $s)>{{ ucfirst($s) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-auto">
                <button class="btn btn-success rounded-pill"><i class="bi bi-funnel me-1"></i>Filter</button>
            </div>
        </div>
    </form>

    <div class="panel farmer-orders-panel">
        @forelse($orders as $o)
            <div class="farmer-order-card">
                <div class="farmer-order-main">
                    <a class="order-card-link" href="{{ route('farmer.orders.show',$o) }}">
                        <div class="farmer-order-title">
                            <b>#{{ $o->order_number }}</b>
                            <span class="status status-{{ $o->status }}">{{ ucfirst($o->status) }}</span>
                        </div>
                        <small><i class="bi bi-person me-1"></i>{{ $o->customer->name }} · <i class="bi bi-calendar3 me-1"></i>{{ $o->pickup_date->format('d M Y') }} · <i class="bi bi-clock me-1"></i>{{ $o->pickup_slot }}</small>
                        <small><i class="bi bi-bag me-1"></i>{{ $o->items->pluck('product.name')->filter()->join(', ') }}</small>
                        @if($o->notes)<small><i class="bi bi-chat-left-text me-1"></i>Note: {{ $o->notes }}</small>@endif
                    </a>
                </div>
                <strong class="farmer-order-total">Rs {{ number_format($o->total_amount) }}</strong>
                <div class="farmer-order-actions d-flex gap-2 flex-wrap">
                    @if($o->status==='placed')
                        <form method="POST" action="{{ route('farmer.orders.status',$o) }}">@csrf<input type="hidden" name="status" value="accepted"><button class="btn btn-sm btn-success rounded-pill"><i class="bi bi-check-circle me-1"></i>Accept</button></form>
                        <form method="POST" action="{{ route('farmer.orders.status',$o) }}" onsubmit="return confirm('Decline and restore stock?');">@csrf<input type="hidden" name="status" value="declined"><button class="btn btn-sm btn-outline-danger rounded-pill"><i class="bi bi-x-circle me-1"></i>Decline</button></form>
                    @elseif($o->status==='accepted')
                        <form method="POST" action="{{ route('farmer.orders.status',$o) }}">@csrf<input type="hidden" name="status" value="ready"><button class="btn btn-sm btn-success rounded-pill"><i class="bi bi-box-seam me-1"></i>Ready</button></form>
                        <form method="POST" action="{{ route('farmer.orders.status',$o) }}" onsubmit="return confirm('Cancel and restore stock?');">@csrf<input type="hidden" name="status" value="cancelled"><button class="btn btn-sm btn-outline-danger rounded-pill"><i class="bi bi-x-circle me-1"></i>Cancel</button></form>
                    @elseif($o->status==='ready')
                        <form method="POST" action="{{ route('farmer.orders.status',$o) }}">@csrf<input type="hidden" name="status" value="completed"><button class="btn btn-sm btn-dark rounded-pill"><i class="bi bi-check2-all me-1"></i>Complete</button></form>
                    @endif
                    <a href="{{ route('farmer.orders.show',$o) }}" class="btn btn-sm btn-outline-dark rounded-pill"><i class="bi bi-eye me-1"></i>View</a>
                </div>
            </div>
        @empty
            <div class="empty-state"><i class="bi bi-box-seam fs-2"></i><h4 class="mt-2">No incoming orders</h4><p>New customer pre-orders will appear here.</p></div>
        @endforelse
    </div>

    @if($orders->hasPages())
        @php
            $ordersCurrentPage = $orders->currentPage();
            $ordersLastPage = $orders->lastPage();
            $ordersQuery = request()->except('page');
        @endphp
        <div class="farmer-orders-pagination mt-4" aria-label="Incoming orders pagination">
            <div class="farmer-pagination-top">
                <a class="farmer-pagination-control {{ $orders->onFirstPage() ? 'disabled' : '' }}"
                   href="{{ $orders->onFirstPage() ? '#' : $orders->appends($ordersQuery)->previousPageUrl() }}"
                   @if($orders->onFirstPage()) aria-disabled="true" tabindex="-1" @endif>
                    <i class="bi bi-chevron-left"></i> Previous
                </a>

                <span class="farmer-pagination-summary">
                    Showing {{ $orders->firstItem() }} to {{ $orders->lastItem() }} of {{ $orders->total() }} results
                </span>

                <a class="farmer-pagination-control {{ $orders->currentPage() >= $ordersLastPage ? 'disabled' : '' }}"
                   href="{{ $orders->currentPage() >= $ordersLastPage ? '#' : $orders->appends($ordersQuery)->nextPageUrl() }}"
                   @if($orders->currentPage() >= $ordersLastPage) aria-disabled="true" tabindex="-1" @endif>
                    Next <i class="bi bi-chevron-right"></i>
                </a>
            </div>

            <div class="farmer-pagination-numbers">
                @for($page = 1; $page <= $ordersLastPage; $page++)
                    @if($page === $ordersCurrentPage)
                        <span class="farmer-pagination-number active" aria-current="page">{{ $page }}</span>
                    @else
                        <a class="farmer-pagination-number"
                           href="{{ $orders->appends($ordersQuery)->url($page) }}">{{ $page }}</a>
                    @endif
                @endfor
            </div>
        </div>
    @endif
</div>

<style>
/* Incoming Orders only — scoped to this page so no other page/function is affected. */
.farmer-orders-page .farmer-orders-panel{overflow:hidden}
.farmer-orders-page .farmer-order-card{display:grid;grid-template-columns:minmax(0,1fr) auto auto;align-items:center;gap:22px;padding:18px 8px;border-bottom:1px solid var(--line);border-radius:16px}
.farmer-orders-page .farmer-order-card:last-child{border-bottom:0}
.farmer-orders-page .farmer-order-card:hover{background:var(--surface-2)}
.farmer-orders-page .farmer-order-main{min-width:0}
.farmer-orders-page .farmer-order-title{display:flex;align-items:center;gap:10px;flex-wrap:wrap;margin-bottom:5px}
.farmer-orders-page .farmer-order-title b{font-size:.86rem}
.farmer-orders-page .farmer-order-main small{display:block;color:var(--muted);font-size:.68rem;line-height:1.55;margin-top:3px}
.farmer-orders-page .farmer-order-main small i{color:var(--green)}
.farmer-orders-page .farmer-order-total{color:var(--green);font:800 1rem Manrope;white-space:nowrap}
.farmer-orders-page .farmer-order-actions{justify-content:flex-end}
.farmer-orders-page .farmer-order-actions form{margin:0}
.farmer-orders-page .farmer-order-actions .btn{white-space:nowrap}

/* Fix Laravel paginator SVGs that otherwise render as huge arrows when the default paginator view is used. */
.farmer-orders-page .farmer-orders-pagination nav{display:flex;justify-content:center;width:100%;font-size:.78rem}
.farmer-orders-page .farmer-orders-pagination nav svg{width:16px!important;height:16px!important;max-width:16px!important;max-height:16px!important;display:inline-block}
.farmer-orders-page .farmer-orders-pagination nav a,
.farmer-orders-page .farmer-orders-pagination nav span{font-size:.72rem!important;line-height:1.2!important}
.farmer-orders-page .farmer-orders-pagination nav [aria-current="page"] span{background:var(--green);color:#fff;border-color:var(--green)}
.farmer-orders-page .farmer-orders-pagination nav a:hover{color:var(--green)}

@media(max-width:991.98px){
    .farmer-orders-page .farmer-order-card{grid-template-columns:minmax(0,1fr) auto;gap:12px}
    .farmer-orders-page .farmer-order-actions{grid-column:1/-1;justify-content:flex-start}
}
@media(max-width:575.98px){
    .farmer-orders-page .farmer-order-card{grid-template-columns:1fr;padding:16px 4px}
    .farmer-orders-page .farmer-order-total{justify-self:start}
    .farmer-orders-page .farmer-order-actions{grid-column:auto}
    .farmer-orders-page .farmer-order-actions .btn{font-size:.68rem}
}

/* MarketLink pagination — matches the compact two-row reference style. */
.farmer-orders-page .farmer-orders-pagination{
    display:flex;
    flex-direction:column;
    align-items:center;
    gap:10px;
    padding:0 0 4px;
}
.farmer-orders-page .farmer-pagination-top{
    display:flex;
    align-items:center;
    justify-content:center;
    gap:0;
    flex-wrap:wrap;
}
.farmer-orders-page .farmer-pagination-control{
    min-width:80px;
    height:38px;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap:6px;
    padding:0 14px;
    border:1px solid #d7e3df;
    background:#fff;
    color:#087e6e;
    text-decoration:none;
    font-size:11px;
    font-weight:700;
    transition:background .18s ease,color .18s ease,border-color .18s ease;
}
.farmer-orders-page .farmer-pagination-control:first-child{
    border-radius:10px 0 0 10px;
}
.farmer-orders-page .farmer-pagination-control:last-child{
    border-radius:0 10px 10px 0;
}
.farmer-orders-page .farmer-pagination-control:hover{
    background:#f0f8f5;
    border-color:#b9d8d0;
    color:#05695c;
}
.farmer-orders-page .farmer-pagination-control.disabled{
    opacity:.45;
    pointer-events:none;
}
.farmer-orders-page .farmer-pagination-summary{
    height:38px;
    display:inline-flex;
    align-items:center;
    padding:0 13px;
    border-top:1px solid #d7e3df;
    border-bottom:1px solid #d7e3df;
    background:#fff;
    color:#657873;
    font-size:10px;
    white-space:nowrap;
}
.farmer-orders-page .farmer-pagination-numbers{
    display:flex;
    align-items:center;
    justify-content:center;
}
.farmer-orders-page .farmer-pagination-number{
    width:46px;
    height:38px;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    border:1px solid #d7e3df;
    border-left:0;
    background:#fff;
    color:#087e6e;
    text-decoration:none;
    font-size:11px;
    font-weight:700;
}
.farmer-orders-page .farmer-pagination-number:first-child{
    border-left:1px solid #d7e3df;
    border-radius:9px 0 0 9px;
}
.farmer-orders-page .farmer-pagination-number:last-child{
    border-radius:0 9px 9px 0;
}
.farmer-orders-page .farmer-pagination-number:hover{
    background:#f0f8f5;
    color:#05695c;
}
.farmer-orders-page .farmer-pagination-number.active{
    background:#087e6e;
    border-color:#087e6e;
    color:#fff;
    box-shadow:0 6px 14px rgba(8,126,110,.16);
}
@media(max-width:575.98px){
    .farmer-orders-page .farmer-pagination-top{
        width:100%;
        display:grid;
        grid-template-columns:auto 1fr auto;
    }
    .farmer-orders-page .farmer-pagination-control{
        min-width:70px;
        padding:0 9px;
    }
    .farmer-orders-page .farmer-pagination-summary{
        justify-content:center;
        overflow:hidden;
        text-overflow:ellipsis;
    }
    .farmer-orders-page .farmer-pagination-numbers{
        max-width:100%;
        overflow-x:auto;
        justify-content:flex-start;
        padding-bottom:2px;
    }
    .farmer-orders-page .farmer-pagination-number{
        flex:0 0 42px;
    }
}

</style>
@endsection
