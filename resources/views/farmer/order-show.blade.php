@extends('layouts.app')
@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4"><div><span class="eyebrow">Farmer Studio</span><h1>Order #{{ $order->order_number }}</h1><p class="text-muted mb-0">Customer pickup order details.</p></div><a href="{{ route('farmer.orders') }}" class="btn btn-outline-dark rounded-pill"><i class="bi bi-arrow-left me-1"></i>Back to orders</a></div>
    <div class="row g-4">
        <div class="col-lg-8"><div class="panel mb-4"><div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3"><div><span class="eyebrow">Customer</span><h4 class="mb-0">{{ $order->customer->name }}</h4><small class="text-muted">{{ $order->customer->email }}</small></div><span class="status status-{{ $order->status }}">{{ ucfirst($order->status) }}</span></div>
        @if($order->notes)<div class="reply-box mb-3"><strong>Customer note</strong><p>{{ $order->notes }}</p></div>@endif
        <h5>Items</h5>@foreach($order->items as $item)<div class="order-row"><div><b>{{ $item->product?->name ?? 'Product' }}</b><small>{{ $item->quantity }} × Rs {{ number_format($item->unit_price) }}</small></div><strong>Rs {{ number_format($item->line_total) }}</strong></div>@endforeach
        <div class="d-flex justify-content-between pt-4"><strong>Total</strong><strong>Rs {{ number_format($order->total_amount) }}</strong></div></div></div>
        <div class="col-lg-4"><div class="panel mb-4"><span class="eyebrow">Pickup</span><h4 class="mt-2">{{ $order->pickup_date->format('d M Y') }}</h4><p class="mb-1">{{ $order->pickup_slot }}</p><p class="text-muted">{{ $order->market?->name ?? 'Market' }}</p></div>
        <div class="panel"><span class="eyebrow">Actions</span><div class="d-grid gap-2 mt-3">
            @if($order->status==='placed')<form method="POST" action="{{ route('farmer.orders.status',$order) }}">@csrf<input type="hidden" name="status" value="accepted"><button class="btn btn-success rounded-pill">Accept Order</button></form><form method="POST" action="{{ route('farmer.orders.status',$order) }}" onsubmit="return confirm('Decline this order and return stock?');">@csrf<input type="hidden" name="status" value="declined"><button class="btn btn-outline-danger rounded-pill">Decline</button></form>
            @elseif($order->status==='accepted')<form method="POST" action="{{ route('farmer.orders.status',$order) }}">@csrf<input type="hidden" name="status" value="ready"><button class="btn btn-success rounded-pill">Mark Ready</button></form><form method="POST" action="{{ route('farmer.orders.status',$order) }}" onsubmit="return confirm('Cancel this order and restore stock?');">@csrf<input type="hidden" name="status" value="cancelled"><button class="btn btn-outline-danger rounded-pill">Cancel Order</button></form>
            @elseif($order->status==='ready')<form method="POST" action="{{ route('farmer.orders.status',$order) }}">@csrf<input type="hidden" name="status" value="completed"><button class="btn btn-dark rounded-pill">Mark Completed</button></form>@else<div class="text-muted small">This order has no further actions.</div>@endif
        </div></div></div>
    </div>
</div>
@endsection
