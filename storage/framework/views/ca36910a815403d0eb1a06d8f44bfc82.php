<?php $__env->startSection('content'); ?>
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div><span class="eyebrow">Customer</span><h1>My orders</h1><p class="text-muted mb-0">Follow every reservation from placement to pickup.</p></div>
        <a href="<?php echo e(route('products.index')); ?>" class="btn btn-success rounded-pill">Browse products</a>
    <a href="<?php echo e(route('customer.orders.export')); ?>" class="btn btn-outline-dark rounded-pill">Export CSV</a></div>
    <form class="filter-bar mb-4"><div class="row g-2 align-items-end"><div class="col-md-4"><label>Status</label><select name="status" class="form-select"><option value="">All statuses</option><?php $__currentLoopData = ['placed','accepted','ready','completed','cancelled','declined']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($s); ?>" <?php if(request('status')===$s): echo 'selected'; endif; ?>><?php echo e(ucfirst($s)); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></div><div class="col-md-auto"><button class="btn btn-success rounded-pill">Filter</button></div></div></form>
    <div class="panel">
        <?php $__empty_1 = true; $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $o): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="order-row flex-wrap">
                <div class="flex-grow-1"><a class="order-card-link" href="<?php echo e(route('customer.orders.show',$o)); ?>"><div><b>#<?php echo e($o->order_number); ?></b><small><?php echo e($o->pickup_date->format('d M Y')); ?> · <?php echo e($o->pickup_slot); ?> · <?php echo e($o->market?->name ?? 'Market'); ?></small><small><?php echo e($o->items->pluck('product.name')->filter()->join(', ')); ?></small></div></a></div>
                <span class="status status-<?php echo e($o->status); ?>"><?php echo e(ucfirst($o->status)); ?></span><strong>Rs <?php echo e(number_format($o->total_amount)); ?></strong>
                <div class="d-flex gap-2 flex-wrap">
                    <?php if(in_array($o->status,['placed','accepted'],true)): ?><a href="<?php echo e(route('customer.orders.edit',$o)); ?>" class="btn btn-sm btn-outline-success rounded-pill">Edit</a><?php endif; ?>
                    <a href="<?php echo e(route('orders.receipt',$o)); ?>" class="btn btn-sm btn-outline-dark rounded-pill">Receipt</a>
                    <?php if(in_array($o->status,['placed','accepted'],true)): ?><form method="POST" action="<?php echo e(route('orders.cancel',$o)); ?>" data-ajax-cancel><?php echo csrf_field(); ?><button class="btn btn-sm btn-outline-danger rounded-pill">Cancel</button></form><?php endif; ?>
                    <?php if(in_array($o->status,['completed','cancelled','declined'],true)): ?><a href="<?php echo e(route('orders.reorder',$o)); ?>" class="btn btn-sm btn-outline-success rounded-pill">Reorder</a><?php endif; ?>
                    <a href="<?php echo e(route('customer.orders.show',$o)); ?>" class="btn btn-sm btn-outline-dark rounded-pill">View</a>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="empty-state"><i class="bi bi-bag fs-2"></i><h4 class="mt-2">No orders yet</h4><p>Start exploring local products.</p><a href="<?php echo e(route('products.index')); ?>" class="btn btn-success rounded-pill">Browse products</a></div>
        <?php endif; ?>
    </div>
    <div class="mt-4"><?php echo e($orders->links()); ?></div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\MarketLink\resources\views\orders\customer.blade.php ENDPATH**/ ?>