<?php $__env->startSection('content'); ?>
<div class="container py-5">
<div class="d-flex justify-content-between align-items-end gap-3 flex-wrap mb-4"><div><span class="eyebrow">Compare</span><h1>Product comparison</h1><p class="text-muted mb-0">Compare price, stock, farmer and ratings before choosing your pickup.</p></div><a href="<?php echo e(route('products.index')); ?>" class="btn btn-outline-dark rounded-pill">Back to products</a></div>
<div class="compare-grid" style="grid-template-columns:repeat(<?php echo e($products->count()); ?>,minmax(0,1fr));">
<?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<div class="compare-card panel">
<div class="compare-art"><?php if (isset($component)) { $__componentOriginalf7e2b17340f32a2cc74824a83da24f93 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf7e2b17340f32a2cc74824a83da24f93 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.product-media','data' => ['product' => $p]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('product-media'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['product' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($p)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf7e2b17340f32a2cc74824a83da24f93)): ?>
<?php $attributes = $__attributesOriginalf7e2b17340f32a2cc74824a83da24f93; ?>
<?php unset($__attributesOriginalf7e2b17340f32a2cc74824a83da24f93); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf7e2b17340f32a2cc74824a83da24f93)): ?>
<?php $component = $__componentOriginalf7e2b17340f32a2cc74824a83da24f93; ?>
<?php unset($__componentOriginalf7e2b17340f32a2cc74824a83da24f93); ?>
<?php endif; ?></div>
<h4><?php echo e($p->name); ?></h4><span class="badge bg-success-subtle text-success align-self-start"><?php echo e($p->category?->name); ?></span>
<div class="compare-row"><small>Price</small><strong>Rs <?php echo e(number_format($p->price,2)); ?> / <?php echo e($p->unit); ?></strong></div>
<div class="compare-row"><small>Stock</small><strong><?php echo e($p->stock_quantity); ?> <?php echo e($p->unit); ?></strong></div>
<div class="compare-row"><small>Rating</small><strong class="text-warning"><?php echo e(number_format((float)($p->reviews_avg_rating??0),1)); ?> ★</strong></div>
<div class="compare-row"><small>Farmer</small><strong><?php echo e($p->farmer?->farmerProfile?->stall_name ?? $p->farmer?->name); ?></strong></div>
<div class="compare-row"><small>Market</small><strong><?php echo e($p->market?->name ?? 'Farmer location'); ?></strong></div>
<a class="btn btn-success rounded-pill w-100 mt-3" href="<?php echo e(route('products.show',$p)); ?>">View product</a>
</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div></div>
<style>.compare-grid{display:grid;gap:18px;align-items:stretch}.compare-card{padding:18px}.compare-art{height:170px;border-radius:18px;display:grid;place-items:center;background:linear-gradient(135deg,#e7f7ef,#fff1d4);overflow:hidden;margin-bottom:18px;font-size:5rem}.compare-art img{width:100%;height:100%;object-fit:cover}.compare-row{display:flex;justify-content:space-between;gap:15px;padding:12px 0;border-bottom:1px solid var(--line)}.compare-row small{color:var(--muted)}.compare-row strong{font-size:.84rem;text-align:right}.compare-card h4{font-weight:800}</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\MarketLink\resources\views\products\compare.blade.php ENDPATH**/ ?>