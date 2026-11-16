<?php $__env->startSection('content'); ?>
<div class="container py-5">
    <a href="<?php echo e(route('products.index')); ?>" class="back-link"><i class="bi bi-arrow-left"></i> Back to products</a>

    <div class="product-detail-grid mt-4">
        <div class="detail-media-card">
            <div class="detail-photo">
                <?php if (isset($component)) { $__componentOriginalf7e2b17340f32a2cc74824a83da24f93 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf7e2b17340f32a2cc74824a83da24f93 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.product-media','data' => ['product' => $product]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('product-media'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['product' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($product)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf7e2b17340f32a2cc74824a83da24f93)): ?>
<?php $attributes = $__attributesOriginalf7e2b17340f32a2cc74824a83da24f93; ?>
<?php unset($__attributesOriginalf7e2b17340f32a2cc74824a83da24f93); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf7e2b17340f32a2cc74824a83da24f93)): ?>
<?php $component = $__componentOriginalf7e2b17340f32a2cc74824a83da24f93; ?>
<?php unset($__componentOriginalf7e2b17340f32a2cc74824a83da24f93); ?>
<?php endif; ?>
            </div>
            <div class="detail-trust-row"><span><i class="bi bi-patch-check"></i> Local farmer</span><span><i class="bi bi-calendar3"></i> Weekly stock</span><span><i class="bi bi-wallet2"></i> Pay at pickup</span></div>
        </div>

        <div class="detail-copy">
            <span class="eyebrow"><?php echo e($product->category?->name); ?></span>
            <h1><?php echo e($product->name); ?></h1>
            <p class="section-copy"><?php echo e($product->description); ?></p>
            <div class="detail-rating"><span class="stars"><?php echo e(number_format((float)($product->reviews->avg('rating') ?? 0),1)); ?> ★</span><span><?php echo e($product->reviews->count()); ?> reviews</span></div>
            <div class="price-lg">Rs <?php echo e(number_format($product->price,2)); ?> <small>/ <?php echo e($product->unit); ?></small></div>

            <div class="info-stack">
                <div class="info-row"><i class="bi bi-shop"></i><div><b><a href="<?php echo e(route('farmers.show',$product->farmer)); ?>" class="text-reset text-decoration-none"><?php echo e($product->farmer->farmerProfile?->stall_name ?? $product->farmer->name); ?></a></b><small><?php echo e($product->farmer->farmerProfile?->address); ?></small></div></div>
                <div class="info-row"><i class="bi bi-calendar3"></i><div><b>Pickup</b><small><?php echo e($product->market?->name ?? 'Market'); ?> · <?php echo e($product->farmer->farmerProfile?->pickup_windows); ?></small></div></div>
            </div>

            <div class="detail-actions mt-4">
                <?php if(auth()->guard()->check()): ?>
                    <?php if(auth()->user()->role==='customer'): ?>
                        <form action="<?php echo e(route('cart.add')); ?>" method="POST" class="detail-buy-form cart-ajax-form">
                            <?php echo csrf_field(); ?>
                            <div class="input-group mb-2"><button class="btn btn-outline-secondary qty-minus" type="button">−</button><input type="number" min="1" max="<?php echo e($product->stock_quantity); ?>" value="1" name="quantity" class="form-control qty-input"><button class="btn btn-outline-secondary qty-plus" type="button">+</button><input type="hidden" name="product_id" value="<?php echo e($product->id); ?>"></div>
                            <button class="btn btn-success w-100 rounded-pill py-3" type="submit" <?php if(!$product->is_available || !$product->stock_quantity): echo 'disabled'; endif; ?>><i class="bi bi-bag-plus me-1"></i>Add to cart</button>
                        </form>
                        <form method="POST" action="<?php echo e(route('favorites.toggle')); ?>"><div><?php echo csrf_field(); ?><input type="hidden" name="product_id" value="<?php echo e($product->id); ?>"><button class="btn btn-outline-dark detail-heart" type="submit" title="Favorite"><i class="bi <?php echo e($isFavorite?'bi-heart-fill text-danger':'bi-heart'); ?>"></i></button></div></form>
                    <?php endif; ?>
                <?php else: ?>
                    <a class="btn btn-success rounded-pill px-4 py-3" href="<?php echo e(route('login')); ?>">Sign in to reserve</a>
                <?php endif; ?>
            </div>

            <div class="detail-note"><i class="bi bi-info-circle"></i><div><strong>Pickup only</strong><span>Online payment is not required. Pay the farmer in person at pickup.</span></div></div>
        </div>
    </div>

    <div class="row g-4 mt-5">
        <div class="col-lg-7">
            <div class="section-head"><div><span class="eyebrow">Community feedback</span><h2>Customer reviews</h2></div></div>
            <?php $__empty_1 = true; $__currentLoopData = $product->reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <article class="modern-review-card"><div class="review-card-top"><div class="reviewer-info"><div class="review-avatar"><?php echo e(strtoupper(substr($r->customer->name,0,1))); ?></div><div><strong><?php echo e($r->customer->name); ?></strong><small class="d-block text-muted"><?php echo e($r->created_at->format('d M Y')); ?></small></div></div><div class="stars"><?php echo e(str_repeat('★',$r->rating)); ?><?php echo e(str_repeat('☆',5-$r->rating)); ?></div></div><div class="review-comment"><i class="bi bi-quote"></i><p class="mb-0"><?php echo e($r->comment ?: 'This customer left a rating without a written comment.'); ?></p></div><?php if($r->farmer_reply): ?><div class="reply-box mt-3"><strong><i class="bi bi-shop me-1"></i>Farmer reply</strong><p class="mb-0 mt-1"><?php echo e($r->farmer_reply); ?></p></div><?php endif; ?></article>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="reviews-empty"><div class="empty-review-icon"><i class="bi bi-chat-heart"></i></div><h4>No reviews yet</h4><p>Be the first customer to share your experience.</p></div>
            <?php endif; ?>
        </div>
        <div class="col-lg-5">
            <div class="sticky-xl-top product-location-card"><div class="map-card-head"><div><span class="eyebrow">Pickup point</span><h4 class="mb-0"><?php echo e($product->market?->name ?? 'Market location'); ?></h4></div></div><?php if($product->market?->latitude && $product->market?->longitude): ?><div id="productMap" class="map-box"></div><?php else: ?><div class="map-empty"><i class="bi bi-geo-alt"></i><p>Market location is not available.</p></div><?php endif; ?></div>
        </div>
    </div>

    <?php if($related->count()||$recentProducts->count()): ?>
        <section class="section section-tight-bottom"><div class="section-head"><div><span class="eyebrow">Keep exploring</span><h2>More from MarketLink</h2></div></div><div class="row g-4"><?php $__currentLoopData = $related->take(4); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><div class="col-6 col-lg-3"><a href="<?php echo e(route('products.show',$rp)); ?>" class="product-card d-block h-100 text-decoration-none"><div class="product-visual"><?php if (isset($component)) { $__componentOriginalf7e2b17340f32a2cc74824a83da24f93 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf7e2b17340f32a2cc74824a83da24f93 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.product-media','data' => ['product' => $rp]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('product-media'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['product' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($rp)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf7e2b17340f32a2cc74824a83da24f93)): ?>
<?php $attributes = $__attributesOriginalf7e2b17340f32a2cc74824a83da24f93; ?>
<?php unset($__attributesOriginalf7e2b17340f32a2cc74824a83da24f93); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf7e2b17340f32a2cc74824a83da24f93)): ?>
<?php $component = $__componentOriginalf7e2b17340f32a2cc74824a83da24f93; ?>
<?php unset($__componentOriginalf7e2b17340f32a2cc74824a83da24f93); ?>
<?php endif; ?></div><div class="product-content"><span class="product-meta"><?php echo e($rp->category?->name); ?></span><h3><?php echo e($rp->name); ?></h3><strong class="price">Rs <?php echo e(number_format($rp->price,2)); ?></strong></div></a></div><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></div></section>
    <?php endif; ?>
</div>

<script>
document.addEventListener('DOMContentLoaded',function(){
    const minus=document.querySelector('.qty-minus'); const plus=document.querySelector('.qty-plus'); const qty=document.querySelector('.qty-input');
    if(minus&&plus&&qty){minus.addEventListener('click',()=>qty.value=Math.max(1,Number(qty.value||1)-1));plus.addEventListener('click',()=>qty.value=Math.min(Number(qty.max||999999),Number(qty.value||1)+1));}
});
</script>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
<?php if($product->market?->latitude && $product->market?->longitude): ?>
<script>document.addEventListener('DOMContentLoaded',function(){ML.singleMap('productMap',<?php echo e($product->market->latitude); ?>,<?php echo e($product->market->longitude); ?>,<?php echo json_encode($product->market->name, 15, 512) ?>);});</script>
<?php endif; ?>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Digital Dominators --- MarketLink\resources\views/products/show.blade.php ENDPATH**/ ?>