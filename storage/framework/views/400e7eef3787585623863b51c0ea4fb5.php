<?php $__env->startSection('content'); ?>
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4"><div><span class="eyebrow">Order Details</span><h1>Order #<?php echo e($order->order_number); ?></h1><p class="text-muted mb-0">Track your MarketLink pre-order.</p></div><a href="<?php echo e(route('customer.orders')); ?>" class="btn btn-outline-dark rounded-pill"><i class="bi bi-arrow-left me-1"></i>Back to Orders</a></div>
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="panel mb-4">
                <div class="d-flex justify-content-between align-items-center mb-4"><div><span class="eyebrow">Status</span><h4 class="mb-0">Order Timeline</h4></div><span class="status status-<?php echo e($order->status); ?>" data-order-status><?php echo e(ucfirst($order->status)); ?></span></div>
                <?php $steps=[['placed','Order Placed','bi-bag-check'],['accepted','Accepted by Farmer','bi-check-circle'],['ready','Ready for Pickup','bi-box-seam'],['completed','Completed','bi-check2-all']]; $rank=['placed'=>1,'accepted'=>2,'ready'=>3,'completed'=>4]; $cur=$rank[$order->status]??0; ?>
                <?php if(in_array($order->status,['cancelled','declined'],true)): ?>
                    <div class="alert alert-danger rounded-4 mb-0"><strong><?php echo e($order->status==='cancelled'?'Order Cancelled':'Order Declined'); ?></strong><div><?php echo e($order->status==='cancelled'?'This order has been cancelled.':'The farmer declined this order.'); ?></div></div>
                <?php else: ?>
                    <div class="timeline"><?php $__currentLoopData = $steps; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as [$key,$title,$icon]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <?php $done=$cur>=$rank[$key]; ?><div class="timeline-item <?php echo e($done?'done':''); ?>"><div class="timeline-dot"><i class="bi <?php echo e($icon); ?>"></i></div><div><b><?php echo e($title); ?></b><p><?php echo e($order->status===$key?'Current status':($done?'Completed':'Waiting')); ?></p></div></div><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></div>
                <?php endif; ?>
            </div>

            <div class="panel mb-4"><div class="mb-3"><span class="eyebrow">Items</span><h4 class="mb-0">Order Items</h4></div><?php $__empty_1 = true; $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><div class="order-row"><div><b><?php echo e($item->product?->name ?? 'Product'); ?></b><small>Quantity: <?php echo e($item->quantity); ?> × Rs <?php echo e(number_format($item->unit_price)); ?></small></div><strong>Rs <?php echo e(number_format($item->line_total)); ?></strong></div><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><div class="empty-state">No items found.</div><?php endif; ?><div class="d-flex justify-content-between pt-4"><strong>Total</strong><strong class="fs-5">Rs <?php echo e(number_format($order->total_amount)); ?></strong></div></div>

            <?php if($order->status==='completed'): ?>
                <div class="panel review-form-panel">
                    <span class="eyebrow">Your Experience</span><h4 class="mb-1">Review your products</h4><p class="text-muted">Select 1–5 stars for each product you purchased.</p>
                    <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php $existing=$item->product?->reviews?->first(); ?>
                        <?php if($item->product): ?>
                            <form method="POST" action="<?php echo e(route('reviews.store')); ?>" class="review-form-card mb-3" data-review-form>
                                <?php echo csrf_field(); ?><input type="hidden" name="order_id" value="<?php echo e($order->id); ?>"><input type="hidden" name="product_id" value="<?php echo e($item->product_id); ?>"><input type="hidden" name="rating" value="<?php echo e($existing?->rating ?? 0); ?>" data-rating-input>
                                <div class="d-flex justify-content-between align-items-start gap-3 flex-wrap"><div><strong><?php echo e($item->product->name); ?></strong><small class="d-block text-muted">Purchased quantity: <?php echo e($item->quantity); ?></small></div><?php if($existing): ?><span class="status status-ready">Reviewed</span><?php endif; ?></div>
                                <div class="star-picker mt-3" data-star-picker><?php for($i=1;$i<=5;$i++): ?><button type="button" class="rating-star <?php echo e($existing && $i <= $existing->rating ? 'active':''); ?>" data-rating="<?php echo e($i); ?>" aria-label="<?php echo e($i); ?> star"><i class="bi bi-star-fill"></i></button><?php endfor; ?></div>
                                <div class="rating-text" data-rating-text><?php echo e($existing?($existing->rating.' / 5'):'Select a rating'); ?></div>
                                <textarea name="comment" class="form-control mt-3" rows="3" maxlength="1000" placeholder="Tell the farmer about this product..."><?php echo e($existing?->comment); ?></textarea>
                                <button class="btn btn-success rounded-pill mt-3"><?php echo e($existing?'Update Review':'Submit Review'); ?></button>
                            </form>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="col-lg-4">
            <?php if(in_array($order->status,['placed','accepted'],true)): ?>
                <a href="<?php echo e(route('customer.orders.edit',$order)); ?>" class="btn btn-success rounded-pill w-100 mb-3"><i class="bi bi-pencil-square me-1"></i>Modify Order</a>
            <?php endif; ?>
            <a href="<?php echo e(route('orders.receipt',$order)); ?>" class="btn btn-outline-dark rounded-pill w-100 mb-3"><i class="bi bi-receipt me-1"></i>View / Print Receipt</a>
            <div class="panel mb-4"><span class="eyebrow">Pickup</span><h4 class="mt-2">Pickup Details</h4><div class="mt-3"><div class="mb-3"><small class="text-muted d-block">Date</small><strong><?php echo e($order->pickup_date->format('d M Y')); ?></strong></div><div class="mb-3"><small class="text-muted d-block">Time Slot</small><strong><?php echo e($order->pickup_slot); ?></strong></div><div><small class="text-muted d-block">Market</small><strong><?php echo e($order->market?->name ?? 'Market'); ?></strong></div></div></div>
            <div class="panel mb-4"><span class="eyebrow">Farmer</span><h4 class="mt-2"><?php echo e($order->farmer?->name ?? 'Farmer'); ?></h4><?php if($order->farmer?->farmerProfile): ?><p class="text-muted mb-0"><?php echo e($order->farmer->farmerProfile->stall_name); ?></p><?php endif; ?></div>
            <div class="panel mb-4"><span class="eyebrow">Payment</span><h4 class="mt-2">Pay at Pickup</h4><p class="text-muted mb-0">Payment is made in person when you collect your order.</p></div>
            <?php if($order->notes): ?><div class="panel mb-4"><span class="eyebrow">Note</span><h4 class="mt-2">Your Notes</h4><p class="text-muted mb-0"><?php echo e($order->notes); ?></p></div><?php endif; ?>
            <?php if(in_array($order->status,['placed','accepted'],true)): ?><div class="panel" data-cancel-panel><form method="POST" action="<?php echo e(route('orders.cancel',$order)); ?>" data-ajax-cancel><?php echo csrf_field(); ?><button class="btn btn-outline-danger rounded-pill w-100">Cancel Order</button></form></div><?php endif; ?>
            <?php if(in_array($order->status,['completed','cancelled','declined'],true)): ?><a href="<?php echo e(route('orders.reorder',$order)); ?>" class="btn btn-outline-success rounded-pill w-100 mt-3">Reorder available items</a><?php endif; ?>
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\MarketLink\resources\views\orders\show.blade.php ENDPATH**/ ?>