@extends('layouts.app')
@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4"><div><span class="eyebrow">Order Details</span><h1>Order #{{ $order->order_number }}</h1><p class="text-muted mb-0">Track your MarketLink pre-order.</p></div><a href="{{ route('customer.orders') }}" class="btn btn-outline-dark rounded-pill"><i class="bi bi-arrow-left me-1"></i>Back to Orders</a></div>
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="panel mb-4">
                <div class="d-flex justify-content-between align-items-center mb-4"><div><span class="eyebrow">Status</span><h4 class="mb-0">Order Timeline</h4></div><span class="status status-{{ $order->status }}" data-order-status>{{ ucfirst($order->status) }}</span></div>
                @php $steps=[['placed','Order Placed','bi-bag-check'],['accepted','Accepted by Farmer','bi-check-circle'],['ready','Ready for Pickup','bi-box-seam'],['completed','Completed','bi-check2-all']]; $rank=['placed'=>1,'accepted'=>2,'ready'=>3,'completed'=>4]; $cur=$rank[$order->status]??0; @endphp
                @if(in_array($order->status,['cancelled','declined'],true))
                    <div class="alert alert-danger rounded-4 mb-0"><strong>{{ $order->status==='cancelled'?'Order Cancelled':'Order Declined' }}</strong><div>{{ $order->status==='cancelled'?'This order has been cancelled.':'The farmer declined this order.' }}</div></div>
                @else
                    <div class="timeline">@foreach($steps as [$key,$title,$icon]) @php $done=$cur>=$rank[$key]; @endphp<div class="timeline-item {{ $done?'done':'' }}"><div class="timeline-dot"><i class="bi {{ $icon }}"></i></div><div><b>{{ $title }}</b><p>{{ $order->status===$key?'Current status':($done?'Completed':'Waiting') }}</p></div></div>@endforeach</div>
                @endif
            </div>

            <div class="panel mb-4"><div class="mb-3"><span class="eyebrow">Items</span><h4 class="mb-0">Order Items</h4></div>@forelse($order->items as $item)<div class="order-row"><div><b>{{ $item->product?->name ?? 'Product' }}</b><small>Quantity: {{ $item->quantity }} × Rs {{ number_format($item->unit_price) }}</small></div><strong>Rs {{ number_format($item->line_total) }}</strong></div>@empty<div class="empty-state">No items found.</div>@endforelse<div class="d-flex justify-content-between pt-4"><strong>Total</strong><strong class="fs-5">Rs {{ number_format($order->total_amount) }}</strong></div></div>

            @if($order->status==='completed')
                <div class="panel review-form-panel">
                    <span class="eyebrow">Your Experience</span><h4 class="mb-1">Review your products</h4><p class="text-muted">Select 1–5 stars for each product you purchased.</p>
                    @foreach($order->items as $item)
                        @php $existing=$item->product?->reviews?->first(); @endphp
                        @if($item->product)
                            <form method="POST" action="{{ route('reviews.store') }}" class="review-form-card mb-3" data-review-form>
                                @csrf<input type="hidden" name="order_id" value="{{ $order->id }}"><input type="hidden" name="product_id" value="{{ $item->product_id }}"><input type="hidden" name="rating" value="{{ $existing?->rating ?? 0 }}" data-rating-input>
                                <div class="d-flex justify-content-between align-items-start gap-3 flex-wrap"><div><strong>{{ $item->product->name }}</strong><small class="d-block text-muted">Purchased quantity: {{ $item->quantity }}</small></div>@if($existing)<span class="status status-ready">Reviewed</span>@endif</div>
                                <div class="star-picker mt-3" data-star-picker>@for($i=1;$i<=5;$i++)<button type="button" class="rating-star {{ $existing && $i <= $existing->rating ? 'active':'' }}" data-rating="{{ $i }}" aria-label="{{ $i }} star"><i class="bi bi-star-fill"></i></button>@endfor</div>
                                <div class="rating-text" data-rating-text>{{ $existing?($existing->rating.' / 5'):'Select a rating' }}</div>
                                <textarea name="comment" class="form-control mt-3" rows="3" maxlength="1000" placeholder="Tell the farmer about this product...">{{ $existing?->comment }}</textarea>
                                <button class="btn btn-success rounded-pill mt-3">{{ $existing?'Update Review':'Submit Review' }}</button>
                            </form>
                        @endif
                    @endforeach
                </div>
            @endif
        </div>

        <div class="col-lg-4">
            @if(in_array($order->status,['placed','accepted'],true))
                <a href="{{ route('customer.orders.edit',$order) }}" class="btn btn-success rounded-pill w-100 mb-3"><i class="bi bi-pencil-square me-1"></i>Modify Order</a>
            @endif
            <a href="{{ route('orders.receipt',$order) }}" class="btn btn-outline-dark rounded-pill w-100 mb-3"><i class="bi bi-receipt me-1"></i>View / Print Receipt</a>
            <div class="panel mb-4"><span class="eyebrow">Pickup</span><h4 class="mt-2">Pickup Details</h4><div class="mt-3"><div class="mb-3"><small class="text-muted d-block">Date</small><strong>{{ $order->pickup_date->format('d M Y') }}</strong></div><div class="mb-3"><small class="text-muted d-block">Time Slot</small><strong>{{ $order->pickup_slot }}</strong></div><div><small class="text-muted d-block">Market</small><strong>{{ $order->market?->name ?? 'Market' }}</strong></div></div></div>
            <div class="panel mb-4"><span class="eyebrow">Farmer</span><h4 class="mt-2">{{ $order->farmer?->name ?? 'Farmer' }}</h4>@if($order->farmer?->farmerProfile)<p class="text-muted mb-0">{{ $order->farmer->farmerProfile->stall_name }}</p>@endif</div>
            <div class="panel mb-4"><span class="eyebrow">Payment</span><h4 class="mt-2">Pay at Pickup</h4><p class="text-muted mb-0">Payment is made in person when you collect your order.</p></div>
            @if($order->notes)<div class="panel mb-4"><span class="eyebrow">Note</span><h4 class="mt-2">Your Notes</h4><p class="text-muted mb-0">{{ $order->notes }}</p></div>@endif
            @if(in_array($order->status,['placed','accepted'],true))<div class="panel" data-cancel-panel><form method="POST" action="{{ route('orders.cancel',$order) }}" data-ajax-cancel>@csrf<button class="btn btn-outline-danger rounded-pill w-100">Cancel Order</button></form></div>@endif
            @if(in_array($order->status,['completed','cancelled','declined'],true))<a href="{{ route('orders.reorder',$order) }}" class="btn btn-outline-success rounded-pill w-100 mt-3">Reorder available items</a>@endif
        </div>
    </div>
</div>

<style>
.review-form-panel{background:var(--surface-2)}.review-form-card{padding:18px;border:1px solid var(--line);border-radius:18px;background:var(--surface)}.star-picker{display:flex;gap:4px}.rating-star{width:45px;height:45px;border:0;border-radius:11px;background:transparent;color:#d5ddd8;font-size:1.7rem;display:grid;place-items:center;cursor:pointer;transition:.15s}.rating-star:hover,.rating-star.active{color:#f3b51b;background:#fff8de;transform:translateY(-1px)}.rating-text{font-size:.82rem;color:var(--muted);margin-top:5px}@media(max-width:480px){.rating-star{width:40px;height:40px;font-size:1.5rem}}
</style>

<script>
document.addEventListener('DOMContentLoaded',function(){
 document.querySelectorAll('[data-review-form]').forEach(function(form){
   const input=form.querySelector('[data-rating-input]'), text=form.querySelector('[data-rating-text]'), stars=[...form.querySelectorAll('.rating-star')];
   const names={1:'Poor',2:'Fair',3:'Good',4:'Very good',5:'Excellent'};
   function select(value){input.value=value;text.textContent=value+' / 5 — '+names[value];stars.forEach(s=>{const on=Number(s.dataset.rating)<=value;s.classList.toggle('active',on);const i=s.querySelector('i');if(i)i.className=on?'bi bi-star-fill':'bi bi-star';});}
   stars.forEach(s=>s.addEventListener('click',()=>select(Number(s.dataset.rating))));
   form.addEventListener('submit',e=>{if(Number(input.value)<1){e.preventDefault();text.textContent='Please select a rating from 1 to 5 stars.';}});
 });
});
</script>
@endsection
