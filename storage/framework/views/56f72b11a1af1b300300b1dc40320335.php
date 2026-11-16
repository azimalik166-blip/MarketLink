<?php $__env->startSection('content'); ?>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-xl-8">
            <div class="mb-4"><span class="eyebrow">Pickup reservation</span><h1>Reserve <?php echo e($p->name); ?></h1><p class="text-muted mb-0">Choose an available date and pickup slot.</p></div>
            <div class="checkout-card">
                <div class="d-flex justify-content-between gap-3 flex-wrap mb-4">
                    <div><strong><?php echo e($p->name); ?></strong><small class="d-block text-muted"><?php echo e($p->unit); ?> · Rs <?php echo e(number_format($p->price,2)); ?></small></div>
                    <span class="status status-ready"><?php echo e($p->stock_quantity); ?> <?php echo e($p->unit); ?> available</span>
                </div>

                <?php if($slots->isEmpty()): ?>
                    <div class="alert alert-warning rounded-4">This farmer has no pickup slots configured for the next 14 days.</div>
                    <a href="<?php echo e(route('products.index')); ?>" class="btn btn-outline-dark rounded-pill">Back to products</a>
                <?php else: ?>
                    <form method="POST" action="<?php echo e(route('orders.store')); ?>">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="product_id" value="<?php echo e($p->id); ?>">
                        <div class="row g-3">
                            <div class="col-md-6"><label>Quantity</label><input class="form-control" type="number" min="1" max="<?php echo e($p->stock_quantity); ?>" name="quantity" value="<?php echo e($items['quantity']); ?>" required></div>
                            <div class="col-md-6"><label>Pickup slot</label><select class="form-select" name="pickup_slot_id" required><option value="">Choose a slot</option><?php $__currentLoopData = $slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slot): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($slot->id); ?>"><?php echo e($slot->slot_date->format('d M Y')); ?> · <?php echo e($slot->label()); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></div>
                            <div class="col-12"><label>Note for farmer <span class="text-muted fw-normal">(optional)</span></label><textarea class="form-control" name="notes" rows="3" maxlength="1000" placeholder="Anything the farmer should know?"></textarea></div>
                        </div>
                        <div class="pay-note mt-4"><i class="bi bi-cash-coin"></i><div><b>Pay at pickup</b><small>MarketLink does not process online payments. Payment is settled directly with the farmer at the market.</small></div></div>
                        <button class="btn btn-success w-100 rounded-pill py-3 mt-4"><i class="bi bi-bag-check me-1"></i>Place pre-order</button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\MarketLink\resources\views\orders\create.blade.php ENDPATH**/ ?>