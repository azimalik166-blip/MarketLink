<?php $__env->startSection('content'); ?>
<style>
.admin-moderation-pagination {
    display:flex;
    align-items:center;
    justify-content:center;
    gap:6px;
    flex-wrap:wrap;
    margin-top:18px;
}
.admin-moderation-pagination a,
.admin-moderation-pagination span {
    min-width:36px;
    height:36px;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    padding:0 10px;
    border:1px solid var(--line, #d7e3df);
    border-radius:10px;
    background:var(--surface, #fff);
    color:var(--ink, #17332d);
    font-size:12px;
    font-weight:700;
    text-decoration:none;
}
.admin-moderation-pagination a:hover {
    border-color:var(--green, #087e6e);
    color:var(--green, #087e6e);
    background:var(--surface-2, #f0f8f5);
}
.admin-moderation-pagination .active {
    border-color:var(--green, #087e6e);
    background:var(--green, #087e6e);
    color:#fff;
}
.admin-moderation-pagination .disabled {
    opacity:.45;
    cursor:not-allowed;
}
html.theme-dark .admin-moderation-pagination a,
html.theme-dark .admin-moderation-pagination span {
    background:#10251f;
    border-color:rgba(185,224,211,.15);
    color:#e7f2ee;
}
html.theme-dark .admin-moderation-pagination a:hover {
    background:#17352d;
    border-color:#79d8bf;
    color:#79d8bf;
}
html.theme-dark .admin-moderation-pagination .active {
    background:#0b7d69;
    border-color:#0b7d69;
    color:#fff;
}
</style>

<div class="container py-5">
    <span class="eyebrow">Admin</span>
    <h1>Moderation</h1>

    <div class="row g-4 mt-2">
        <div class="col-lg-6">
            <div class="panel p-4">
                <h5>Recent products</h5>

                <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="order-row flex-wrap">
                        <div>
                            <b><?php echo e($p->name); ?></b>
                            <small><?php echo e($p->farmer->name); ?> · Rs <?php echo e(number_format($p->price)); ?></small>
                        </div>
                        <form method="post" action="<?php echo e(route('admin.product.delete',$p)); ?>" onsubmit="return confirm('Remove this product?')">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button class="btn btn-sm btn-outline-danger">Remove</button>
                        </form>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p class="text-muted">No products.</p>
                <?php endif; ?>

                <?php if($products->hasPages()): ?>
                    <div class="admin-moderation-pagination" aria-label="Recent products pagination">
                        <?php if($products->onFirstPage()): ?>
                            <span class="disabled">‹</span>
                        <?php else: ?>
                            <a href="<?php echo e($products->url($products->currentPage() - 1)); ?>" aria-label="Previous products page">‹</a>
                        <?php endif; ?>

                        <?php for($i = 1; $i <= $products->lastPage(); $i++): ?>
                            <?php if($i === $products->currentPage()): ?>
                                <span class="active" aria-current="page"><?php echo e($i); ?></span>
                            <?php else: ?>
                                <a href="<?php echo e($products->url($i)); ?>"><?php echo e($i); ?></a>
                            <?php endif; ?>
                        <?php endfor; ?>

                        <?php if($products->hasMorePages()): ?>
                            <a href="<?php echo e($products->url($products->currentPage() + 1)); ?>" aria-label="Next products page">›</a>
                        <?php else: ?>
                            <span class="disabled">›</span>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="panel p-4">
                <h5>Recent reviews</h5>

                <?php $__empty_1 = true; $__currentLoopData = $reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="border-bottom py-3">
                        <div class="d-flex justify-content-between align-items-start gap-2">
                            <div>
                                <b><?php echo e($r->product?->name ?? 'Product'); ?></b> · <span class="text-warning">★ <?php echo e($r->rating); ?>/5</span>
                            </div>
                            <form method="POST" action="<?php echo e(route('admin.review.delete',$r)); ?>" onsubmit="return confirm('Remove this review?')">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button class="btn btn-sm btn-outline-danger rounded-pill">Remove</button>
                            </form>
                        </div>
                        <small><?php echo e($r->customer->name); ?>: <?php echo e($r->comment ?: 'No comment'); ?></small>
                        <?php if($r->farmer_reply): ?>
                            <div class="small mt-1"><b>Farmer reply:</b> <?php echo e($r->farmer_reply); ?></div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p class="text-muted">No reviews.</p>
                <?php endif; ?>

                <?php if($reviews->hasPages()): ?>
                    <div class="admin-moderation-pagination" aria-label="Recent reviews pagination">
                        <?php if($reviews->onFirstPage()): ?>
                            <span class="disabled">‹</span>
                        <?php else: ?>
                            <a href="<?php echo e($reviews->url($reviews->currentPage() - 1)); ?>" aria-label="Previous reviews page">‹</a>
                        <?php endif; ?>

                        <?php for($i = 1; $i <= $reviews->lastPage(); $i++): ?>
                            <?php if($i === $reviews->currentPage()): ?>
                                <span class="active" aria-current="page"><?php echo e($i); ?></span>
                            <?php else: ?>
                                <a href="<?php echo e($reviews->url($i)); ?>"><?php echo e($i); ?></a>
                            <?php endif; ?>
                        <?php endfor; ?>

                        <?php if($reviews->hasMorePages()): ?>
                            <a href="<?php echo e($reviews->url($reviews->currentPage() + 1)); ?>" aria-label="Next reviews page">›</a>
                        <?php else: ?>
                            <span class="disabled">›</span>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\MarketLink\resources\views\admin\moderation.blade.php ENDPATH**/ ?>