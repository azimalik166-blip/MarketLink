@extends('layouts.app')

@section('content')
<style>
    .farmer-storefront { padding-top: 2.5rem; padding-bottom: 4rem; }
    .farmer-storefront .storefront-hero {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 1.5rem;
        padding: clamp(1.5rem, 4vw, 3rem);
        margin-bottom: 1.75rem;
        border-radius: var(--radius);
        background: linear-gradient(115deg, #e7f4ec 0%, #f7f4e8 100%);
    }
    .farmer-storefront .storefront-hero h1 { margin: .35rem 0 .65rem; }
    .farmer-storefront .storefront-hero p { max-width: 42rem; margin-bottom: 1rem; color: var(--muted); }
    .farmer-storefront .storefront-grid { align-items: start; }
    .farmer-storefront .storefront-main { min-width: 0; }
    .farmer-storefront .storefront-aside { display: grid; gap: 1rem; }
    .farmer-storefront .storefront-section { padding: clamp(1rem, 2vw, 1.5rem); }
    .farmer-storefront .storefront-products { row-gap: 1rem; }
    .farmer-storefront .storefront-product-photo { height: 220px; }
    .farmer-storefront .storefront-product-copy h5 { min-height: 2.8rem; margin: .45rem 0 1rem; }
    .farmer-storefront .storefront-meta { min-height: 1.2rem; }
    .farmer-storefront .storefront-aside .panel { padding: 1.25rem; }
    .farmer-storefront .storefront-aside h4 { font-size: 1.05rem; }
    .farmer-storefront .storefront-map { display: inline-flex; align-items: center; }
    @media (max-width: 767.98px) {
        .farmer-storefront .storefront-hero { align-items: flex-start; flex-direction: column; }
        .farmer-storefront .storefront-product-photo { height: 180px; }
    }
</style>

<div class="container farmer-storefront">
    <header class="storefront-hero">
        <div>
            <span class="eyebrow">Local farmer</span>
            <h1>{{ $user->farmerProfile?->stall_name ?? $user->name }}</h1>
            <p>{{ $user->farmerProfile?->bio ?? 'Local farmer on MarketLink.' }}</p>
            <div class="d-flex flex-wrap gap-2">
                <span class="status status-ready"><i class="bi bi-star-fill me-1"></i>{{ number_format($rating, 1) }} rating</span>
                <span class="status status-active"><i class="bi bi-calendar3 me-1"></i>{{ $user->farmerProfile?->operating_days ?? 'Market days' }}</span>
            </div>
        </div>
        @auth
            @if(auth()->user()->role === 'customer')
                <form method="POST" action="{{ route('favorites.toggle') }}">
                    @csrf
                    <input type="hidden" name="farmer_id" value="{{ $user->id }}">
                    <button class="btn btn-outline-danger rounded-pill" type="submit">
                        <i class="bi {{ $isFavorite ? 'bi-heart-fill' : 'bi-heart' }} me-1"></i>{{ $isFavorite ? 'Saved farmer' : 'Favorite farmer' }}
                    </button>
                </form>
            @endif
        @endauth
    </header>

    <div class="row g-4 storefront-grid">
        <section class="col-xl-8 storefront-main" aria-label="Farmer products">
            <div class="panel storefront-section">
                <div class="panel-head">
                    <div>
                        <span class="eyebrow">Fresh from the farm</span>
                        <h2 class="h4 mb-0">Available products</h2>
                    </div>
                    <span class="text-muted small">{{ $products->total() }} items</span>
                </div>

                <div class="row g-3 storefront-products">
                    @forelse($products as $product)
                        <div class="col-md-6">
                            <article class="product-card h-100">
                                <div class="product-photo storefront-product-photo">
                                    <x-product-media :product="$product" />
                                    <span class="stock-pill"><i class="bi bi-box-seam me-1"></i>{{ $product->stock_quantity }} {{ $product->unit }} left</span>
                                </div>
                                <div class="p-3 storefront-product-copy">
                                    <div class="small text-muted storefront-meta">{{ $product->category?->name ?? 'Farm goods' }}@if($product->market) · {{ $product->market->name }}@endif</div>
                                    <h5>{{ $product->name }}</h5>
                                    <div class="d-flex justify-content-between align-items-center gap-2">
                                        <strong class="price">Rs {{ number_format($product->price, 2) }}</strong>
                                        <a class="btn btn-sm btn-success rounded-pill" href="{{ route('products.show', $product) }}">View product</a>
                                    </div>
                                </div>
                            </article>
                        </div>
                    @empty
                        <div class="col-12"><div class="empty-state">No products are available right now.</div></div>
                    @endforelse
                </div>

                @if($products->hasPages())
                    <div class="mt-4">{{ $products->links('pagination::bootstrap-5') }}</div>
                @endif
            </div>
        </section>

        <aside class="col-xl-4 storefront-aside">
            <section class="panel">
                <span class="eyebrow">Pickup information</span>
                <h2 class="h4 mt-2">{{ $user->farmerProfile?->operating_days ?? 'Market days' }}</h2>
                <p class="text-muted">{{ $user->farmerProfile?->pickup_windows ?? 'Pickup windows are shown during checkout.' }}</p>
                <p class="mb-0"><i class="bi bi-geo-alt me-1"></i>{{ $user->farmerProfile?->address }}</p>
                @if($user->farmerProfile?->latitude && $user->farmerProfile?->longitude)
                    <a class="btn btn-sm btn-outline-success rounded-pill mt-3 storefront-map" target="_blank" rel="noopener" href="https://www.openstreetmap.org/?mlat={{ $user->farmerProfile->latitude }}&mlon={{ $user->farmerProfile->longitude }}#map=16/{{ $user->farmerProfile->latitude }}/{{ $user->farmerProfile->longitude }}">
                        <i class="bi bi-sign-turn-right me-1"></i>Open map
                    </a>
                @endif
            </section>

            <section class="panel">
                <span class="eyebrow">From customers</span>
                <h2 class="h4 mt-2">Reviews</h2>
                @forelse($reviews as $review)
                    <div class="review-mini">
                        <div class="stars">{{ str_repeat('★', $review->rating) }}{{ str_repeat('☆', 5 - $review->rating) }}</div>
                        <b>{{ $review->customer->name }}</b>
                        <p>{{ $review->comment }}</p>
                        @if($review->farmer_reply)
                            <small class="text-success">{{ $review->farmer_reply }}</small>
                        @endif
                    </div>
                @empty
                    <div class="empty-state">No reviews yet.</div>
                @endforelse
            </section>
        </aside>
    </div>
</div>
@endsection