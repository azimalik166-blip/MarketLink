@extends('layouts.app')
@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-xl-8">
            <div class="mb-4"><span class="eyebrow">Pickup reservation</span><h1>Reserve {{ $p->name }}</h1><p class="text-muted mb-0">Choose an available date and pickup slot.</p></div>
            <div class="checkout-card">
                <div class="d-flex justify-content-between gap-3 flex-wrap mb-4">
                    <div><strong>{{ $p->name }}</strong><small class="d-block text-muted">{{ $p->unit }} · Rs {{ number_format($p->price,2) }}</small></div>
                    <span class="status status-ready">{{ $p->stock_quantity }} {{ $p->unit }} available</span>
                </div>

                @if($slots->isEmpty())
                    <div class="alert alert-warning rounded-4">This farmer has no pickup slots configured for the next 14 days.</div>
                    <a href="{{ route('products.index') }}" class="btn btn-outline-dark rounded-pill">Back to products</a>
                @else
                    <form method="POST" action="{{ route('orders.store') }}">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $p->id }}">
                        <div class="row g-3">
                            <div class="col-md-6"><label>Quantity</label><input class="form-control" type="number" min="1" max="{{ $p->stock_quantity }}" name="quantity" value="{{ $items['quantity'] }}" required></div>
                            <div class="col-md-6"><label>Pickup slot</label><select class="form-select" name="pickup_slot_id" required><option value="">Choose a slot</option>@foreach($slots as $slot)<option value="{{ $slot->id }}">{{ $slot->slot_date->format('d M Y') }} · {{ $slot->label() }}</option>@endforeach</select></div>
                            <div class="col-12"><label>Note for farmer <span class="text-muted fw-normal">(optional)</span></label><textarea class="form-control" name="notes" rows="3" maxlength="1000" placeholder="Anything the farmer should know?"></textarea></div>
                        </div>
                        <div class="pay-note mt-4"><i class="bi bi-cash-coin"></i><div><b>Pay at pickup</b><small>MarketLink does not process online payments. Payment is settled directly with the farmer at the market.</small></div></div>
                        <button class="btn btn-success w-100 rounded-pill py-3 mt-4"><i class="bi bi-bag-check me-1"></i>Place pre-order</button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
