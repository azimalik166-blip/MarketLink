@extends('layouts.app')
@section('content')
<div class="container py-5">
    <a href="{{ route('products.index') }}" class="back-link"><i class="bi bi-arrow-left"></i> Back to products</a>

    <div class="product-detail-grid mt-4">
        <div class="detail-media-card">
            <div class="detail-photo">
                <x-product-media :product="$product" />
            </div>
            <div class="detail-trust-row"><span><i class="bi bi-patch-check"></i> Local farmer</span><span><i class="bi bi-calendar3"></i> Weekly stock</span><span><i class="bi bi-wallet2"></i> Pay at pickup</span></div>
        </div>

        <div class="detail-copy">
            <span class="eyebrow">{{ $product->category?->name }}</span>
            <h1>{{ $product->name }}</h1>
            <p class="section-copy">{{ $product->description }}</p>
            <div class="detail-rating"><span class="stars">{{ number_format((float)($product->reviews->avg('rating') ?? 0),1) }} ★</span><span>{{ $product->reviews->count() }} reviews</span></div>
            <div class="price-lg">Rs {{ number_format($product->price,2) }} <small>/ {{ $product->unit }}</small></div>

            <div class="info-stack">
                <div class="info-row"><i class="bi bi-shop"></i><div><b><a href="{{ route('farmers.show',$product->farmer) }}" class="text-reset text-decoration-none">{{ $product->farmer->farmerProfile?->stall_name ?? $product->farmer->name }}</a></b><small>{{ $product->farmer->farmerProfile?->address }}</small></div></div>
                <div class="info-row"><i class="bi bi-calendar3"></i><div><b>Pickup</b><small>{{ $product->market?->name ?? 'Market' }} · {{ $product->farmer->farmerProfile?->pickup_windows }}</small></div></div>
            </div>

            <div class="detail-actions mt-4">
                @auth
                    @if(auth()->user()->role==='customer')
                        <form action="{{ route('cart.add') }}" method="POST" class="detail-buy-form cart-ajax-form">
                            @csrf
                            <div class="input-group mb-2"><button class="btn btn-outline-secondary qty-minus" type="button">−</button><input type="number" min="1" max="{{ $product->stock_quantity }}" value="1" name="quantity" class="form-control qty-input"><button class="btn btn-outline-secondary qty-plus" type="button">+</button><input type="hidden" name="product_id" value="{{ $product->id }}"></div>
                            <button class="btn btn-success w-100 rounded-pill py-3" type="submit" @disabled(!$product->is_available || !$product->stock_quantity)><i class="bi bi-bag-plus me-1"></i>Add to cart</button>
                        </form>
                        <form method="POST" action="{{ route('favorites.toggle') }}"><div>@csrf<input type="hidden" name="product_id" value="{{ $product->id }}"><button class="btn btn-outline-dark detail-heart" type="submit" title="Favorite"><i class="bi {{ $isFavorite?'bi-heart-fill text-danger':'bi-heart' }}"></i></button></div></form>
                    @endif
                @else
                    <a class="btn btn-success rounded-pill px-4 py-3" href="{{ route('login') }}">Sign in to reserve</a>
                @endauth
            </div>

            <div class="detail-note"><i class="bi bi-info-circle"></i><div><strong>Pickup only</strong><span>Online payment is not required. Pay the farmer in person at pickup.</span></div></div>
        </div>
    </div>

    <div class="row g-4 mt-5">
        <div class="col-lg-7">
            <div class="section-head"><div><span class="eyebrow">Community feedback</span><h2>Customer reviews</h2></div></div>
            @forelse($product->reviews as $r)
                <article class="modern-review-card"><div class="review-card-top"><div class="reviewer-info"><div class="review-avatar">{{ strtoupper(substr($r->customer->name,0,1)) }}</div><div><strong>{{ $r->customer->name }}</strong><small class="d-block text-muted">{{ $r->created_at->format('d M Y') }}</small></div></div><div class="stars">{{ str_repeat('★',$r->rating) }}{{ str_repeat('☆',5-$r->rating) }}</div></div><div class="review-comment"><i class="bi bi-quote"></i><p class="mb-0">{{ $r->comment ?: 'This customer left a rating without a written comment.' }}</p></div>@if($r->farmer_reply)<div class="reply-box mt-3"><strong><i class="bi bi-shop me-1"></i>Farmer reply</strong><p class="mb-0 mt-1">{{ $r->farmer_reply }}</p></div>@endif</article>
            @empty
                <div class="reviews-empty"><div class="empty-review-icon"><i class="bi bi-chat-heart"></i></div><h4>No reviews yet</h4><p>Be the first customer to share your experience.</p></div>
            @endforelse
        </div>
        <div class="col-lg-5">
            <div class="sticky-xl-top product-location-card"><div class="map-card-head"><div><span class="eyebrow">Pickup point</span><h4 class="mb-0">{{ $product->market?->name ?? 'Market location' }}</h4></div></div>@if($product->market?->latitude && $product->market?->longitude)<div id="productMap" class="map-box"></div>@else<div class="map-empty"><i class="bi bi-geo-alt"></i><p>Market location is not available.</p></div>@endif</div>
        </div>
    </div>

    @if($related->count()||$recentProducts->count())
        <section class="section section-tight-bottom"><div class="section-head"><div><span class="eyebrow">Keep exploring</span><h2>More from MarketLink</h2></div></div><div class="row g-4">@foreach($related->take(4) as $rp)<div class="col-6 col-lg-3"><a href="{{ route('products.show',$rp) }}" class="product-card d-block h-100 text-decoration-none"><div class="product-visual"><x-product-media :product="$rp" /></div><div class="product-content"><span class="product-meta">{{ $rp->category?->name }}</span><h3>{{ $rp->name }}</h3><strong class="price">Rs {{ number_format($rp->price,2) }}</strong></div></a></div>@endforeach</div></section>
    @endif
</div>

<script>
document.addEventListener('DOMContentLoaded',function(){
    const minus=document.querySelector('.qty-minus'); const plus=document.querySelector('.qty-plus'); const qty=document.querySelector('.qty-input');
    if(minus&&plus&&qty){minus.addEventListener('click',()=>qty.value=Math.max(1,Number(qty.value||1)-1));plus.addEventListener('click',()=>qty.value=Math.min(Number(qty.max||999999),Number(qty.value||1)+1));}
});
</script>
@endsection
@push('scripts')
@if($product->market?->latitude && $product->market?->longitude)
<script>document.addEventListener('DOMContentLoaded',function(){ML.singleMap('productMap',{{ $product->market->latitude }},{{ $product->market->longitude }},@json($product->market->name));});</script>
@endif
@endpush
