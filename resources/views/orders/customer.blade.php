@extends('layouts.app')
@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div><span class="eyebrow">Customer</span><h1>My orders</h1><p class="text-muted mb-0">Follow every reservation from placement to pickup.</p></div>
        <a href="{{ route('products.index') }}" class="btn btn-success rounded-pill">Browse products</a>
    <a href="{{ route('customer.orders.export') }}" class="btn btn-outline-dark rounded-pill">Export CSV</a></div>
    <form class="filter-bar mb-4"><div class="row g-2 align-items-end"><div class="col-md-4"><label>Status</label><select name="status" class="form-select"><option value="">All statuses</option>@foreach(['placed','accepted','ready','completed','cancelled','declined'] as $s)<option value="{{ $s }}" @selected(request('status')===$s)>{{ ucfirst($s) }}</option>@endforeach</select></div><div class="col-md-auto"><button class="btn btn-success rounded-pill">Filter</button></div></div></form>
    <div class="panel">
        @forelse($orders as $o)
            <div class="order-row flex-wrap">
                <div class="flex-grow-1"><a class="order-card-link" href="{{ route('customer.orders.show',$o) }}"><div><b>#{{ $o->order_number }}</b><small>{{ $o->pickup_date->format('d M Y') }} · {{ $o->pickup_slot }} · {{ $o->market?->name ?? 'Market' }}</small><small>{{ $o->items->pluck('product.name')->filter()->join(', ') }}</small></div></a></div>
                <span class="status status-{{ $o->status }}">{{ ucfirst($o->status) }}</span><strong>Rs {{ number_format($o->total_amount) }}</strong>
                <div class="d-flex gap-2 flex-wrap">
                    @if(in_array($o->status,['placed','accepted'],true))<a href="{{ route('customer.orders.edit',$o) }}" class="btn btn-sm btn-outline-success rounded-pill">Edit</a>@endif
                    <a href="{{ route('orders.receipt',$o) }}" class="btn btn-sm btn-outline-dark rounded-pill">Receipt</a>
                    @if(in_array($o->status,['placed','accepted'],true))<form method="POST" action="{{ route('orders.cancel',$o) }}" data-ajax-cancel>@csrf<button class="btn btn-sm btn-outline-danger rounded-pill">Cancel</button></form>@endif
                    @if(in_array($o->status,['completed','cancelled','declined'],true))<a href="{{ route('orders.reorder',$o) }}" class="btn btn-sm btn-outline-success rounded-pill">Reorder</a>@endif
                    <a href="{{ route('customer.orders.show',$o) }}" class="btn btn-sm btn-outline-dark rounded-pill">View</a>
                </div>
            </div>
        @empty
            <div class="empty-state"><i class="bi bi-bag fs-2"></i><h4 class="mt-2">No orders yet</h4><p>Start exploring local products.</p><a href="{{ route('products.index') }}" class="btn btn-success rounded-pill">Browse products</a></div>
        @endforelse
    </div>
    <div class="mt-4">{{ $orders->links() }}</div>
</div>
@endsection
