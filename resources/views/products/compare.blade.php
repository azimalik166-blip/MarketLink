@extends('layouts.app')
@section('content')
<div class="container py-5">
<div class="d-flex justify-content-between align-items-end gap-3 flex-wrap mb-4"><div><span class="eyebrow">Compare</span><h1>Product comparison</h1><p class="text-muted mb-0">Compare price, stock, farmer and ratings before choosing your pickup.</p></div><a href="{{ route('products.index') }}" class="btn btn-outline-dark rounded-pill">Back to products</a></div>
<div class="compare-grid" style="grid-template-columns:repeat({{ $products->count() }},minmax(0,1fr));">
@foreach($products as $p)
<div class="compare-card panel">
<div class="compare-art"><x-product-media :product="$p" /></div>
<h4>{{ $p->name }}</h4><span class="badge bg-success-subtle text-success align-self-start">{{ $p->category?->name }}</span>
<div class="compare-row"><small>Price</small><strong>Rs {{ number_format($p->price,2) }} / {{ $p->unit }}</strong></div>
<div class="compare-row"><small>Stock</small><strong>{{ $p->stock_quantity }} {{ $p->unit }}</strong></div>
<div class="compare-row"><small>Rating</small><strong class="text-warning">{{ number_format((float)($p->reviews_avg_rating??0),1) }} ★</strong></div>
<div class="compare-row"><small>Farmer</small><strong>{{ $p->farmer?->farmerProfile?->stall_name ?? $p->farmer?->name }}</strong></div>
<div class="compare-row"><small>Market</small><strong>{{ $p->market?->name ?? 'Farmer location' }}</strong></div>
<a class="btn btn-success rounded-pill w-100 mt-3" href="{{ route('products.show',$p) }}">View product</a>
</div>
@endforeach
</div></div>
<style>.compare-grid{display:grid;gap:18px;align-items:stretch}.compare-card{padding:18px}.compare-art{height:170px;border-radius:18px;display:grid;place-items:center;background:linear-gradient(135deg,#e7f7ef,#fff1d4);overflow:hidden;margin-bottom:18px;font-size:5rem}.compare-art img{width:100%;height:100%;object-fit:cover}.compare-row{display:flex;justify-content:space-between;gap:15px;padding:12px 0;border-bottom:1px solid var(--line)}.compare-row small{color:var(--muted)}.compare-row strong{font-size:.84rem;text-align:right}.compare-card h4{font-weight:800}</style>
@endsection
