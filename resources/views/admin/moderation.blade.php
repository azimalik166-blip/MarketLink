@extends('layouts.app')
@section('content')
<style>
.admin-moderation-pagination {
    display:flex;
    align-items:center;
    justify-content:center;
    gap:6px;
    flex-wrap:wrap;
    margin-top:18px;
}
.admin-moderation-pagination a,
.admin-moderation-pagination span {
    min-width:36px;
    height:36px;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    padding:0 10px;
    border:1px solid var(--line, #d7e3df);
    border-radius:10px;
    background:var(--surface, #fff);
    color:var(--ink, #17332d);
    font-size:12px;
    font-weight:700;
    text-decoration:none;
}
.admin-moderation-pagination a:hover {
    border-color:var(--green, #087e6e);
    color:var(--green, #087e6e);
    background:var(--surface-2, #f0f8f5);
}
.admin-moderation-pagination .active {
    border-color:var(--green, #087e6e);
    background:var(--green, #087e6e);
    color:#fff;
}
.admin-moderation-pagination .disabled {
    opacity:.45;
    cursor:not-allowed;
}
html.theme-dark .admin-moderation-pagination a,
html.theme-dark .admin-moderation-pagination span {
    background:#10251f;
    border-color:rgba(185,224,211,.15);
    color:#e7f2ee;
}
html.theme-dark .admin-moderation-pagination a:hover {
    background:#17352d;
    border-color:#79d8bf;
    color:#79d8bf;
}
html.theme-dark .admin-moderation-pagination .active {
    background:#0b7d69;
    border-color:#0b7d69;
    color:#fff;
}
</style>

<div class="container py-5">
    <span class="eyebrow">Admin</span>
    <h1>Moderation</h1>

    <div class="row g-4 mt-2">
        <div class="col-lg-6">
            <div class="panel p-4">
                <h5>Recent products</h5>

                @forelse($products as $p)
                    <div class="order-row flex-wrap">
                        <div>
                            <b>{{ $p->name }}</b>
                            <small>{{ $p->farmer->name }} · Rs {{ number_format($p->price) }}</small>
                        </div>
                        <form method="post" action="{{ route('admin.product.delete',$p) }}" onsubmit="return confirm('Remove this product?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">Remove</button>
                        </form>
                    </div>
                @empty
                    <p class="text-muted">No products.</p>
                @endforelse

                @if($products->hasPages())
                    <div class="admin-moderation-pagination" aria-label="Recent products pagination">
                        @if($products->onFirstPage())
                            <span class="disabled">‹</span>
                        @else
                            <a href="{{ $products->url($products->currentPage() - 1) }}" aria-label="Previous products page">‹</a>
                        @endif

                        @for($i = 1; $i <= $products->lastPage(); $i++)
                            @if($i === $products->currentPage())
                                <span class="active" aria-current="page">{{ $i }}</span>
                            @else
                                <a href="{{ $products->url($i) }}">{{ $i }}</a>
                            @endif
                        @endfor

                        @if($products->hasMorePages())
                            <a href="{{ $products->url($products->currentPage() + 1) }}" aria-label="Next products page">›</a>
                        @else
                            <span class="disabled">›</span>
                        @endif
                    </div>
                @endif
            </div>
        </div>

        <div class="col-lg-6">
            <div class="panel p-4">
                <h5>Recent reviews</h5>

                @forelse($reviews as $r)
                    <div class="border-bottom py-3">
                        <div class="d-flex justify-content-between align-items-start gap-2">
                            <div>
                                <b>{{ $r->product?->name ?? 'Product' }}</b> · <span class="text-warning">★ {{ $r->rating }}/5</span>
                            </div>
                            <form method="POST" action="{{ route('admin.review.delete',$r) }}" onsubmit="return confirm('Remove this review?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger rounded-pill">Remove</button>
                            </form>
                        </div>
                        <small>{{ $r->customer->name }}: {{ $r->comment ?: 'No comment' }}</small>
                        @if($r->farmer_reply)
                            <div class="small mt-1"><b>Farmer reply:</b> {{ $r->farmer_reply }}</div>
                        @endif
                    </div>
                @empty
                    <p class="text-muted">No reviews.</p>
                @endforelse

                @if($reviews->hasPages())
                    <div class="admin-moderation-pagination" aria-label="Recent reviews pagination">
                        @if($reviews->onFirstPage())
                            <span class="disabled">‹</span>
                        @else
                            <a href="{{ $reviews->url($reviews->currentPage() - 1) }}" aria-label="Previous reviews page">‹</a>
                        @endif

                        @for($i = 1; $i <= $reviews->lastPage(); $i++)
                            @if($i === $reviews->currentPage())
                                <span class="active" aria-current="page">{{ $i }}</span>
                            @else
                                <a href="{{ $reviews->url($i) }}">{{ $i }}</a>
                            @endif
                        @endfor

                        @if($reviews->hasMorePages())
                            <a href="{{ $reviews->url($reviews->currentPage() + 1) }}" aria-label="Next reviews page">›</a>
                        @else
                            <span class="disabled">›</span>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
