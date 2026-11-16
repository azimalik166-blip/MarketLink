

<?php $__env->startSection('content'); ?>
<style>
    .farmer-storefront { padding-top: 2.5rem; padding-bottom: 4rem; }
    .farmer-storefront .storefront-hero {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 1.5rem;
        padding: clamp(1.5rem, 4vw, 3rem);
        margin-bottom: 1.75rem;
        border-radius: var(--radius);
        background: linear-gradient(115deg, #e7f4ec 0%, #f7f4e8 100%);
    }
    .farmer-storefront .storefront-hero h1 { margin: .35rem 0 .65rem; }
    .farmer-storefront .storefront-hero p { max-width: 42rem; margin-bottom: 1rem; color: var(--muted); }
    .farmer-storefront .storefront-grid { align-items: start; }
    .farmer-storefront .storefront-main { min-width: 0; }
    .farmer-storefront .storefront-aside { display: grid; gap: 1rem; }
    .farmer-storefront .storefront-section { padding: clamp(1rem, 2vw, 1.5rem); }
    .farmer-storefront .storefront-products { row-gap: 1rem; }
    .farmer-storefront .storefront-product-photo { height: 220px; }
    .farmer-storefront .storefront-product-copy h5 { min-height: 2.8rem; margin: .45rem 0 1rem; }
    .farmer-storefront .storefront-meta { min-height: 1.2rem; }
    .farmer-storefront .storefront-aside .panel { padding: 1.25rem; }
    .farmer-storefront .storefront-aside h4 { font-size: 1.05rem; }
    .farmer-storefront .storefront-map { display: inline-flex; align-items: center; }
    @media (max-width: 767.98px) {
        .farmer-storefront .storefront-hero { align-items: flex-start; flex-direction: column; }
        .farmer-storefront .storefront-product-photo { height: 180px; }
    }
</style>

<div class="container farmer-storefront">
    <header class="storefront-hero">
        <div>
            <span class="eyebrow">Local farmer</span>
            <h1><?php echo e($user->farmerProfile?->stall_name ?? $user->name); ?></h1>
            <p><?php echo e($user->farmerProfile?->bio ?? 'Local farmer on MarketLink.'); ?></p>
            <div class="d-flex flex-wrap gap-2">
                <span class="status status-ready"><i class="bi bi-star-fill me-1"></i><?php echo e(number_format($rating, 1)); ?> rating</span>
                <span class="status status-active"><i class="bi bi-calendar3 me-1"></i><?php echo e($user->farmerProfile?->operating_days ?? 'Market days'); ?></span>
            </div>
        </div>
        <?php if(auth()->guard()->check()): ?>
            <?php if(auth()->user()->role === 'customer'): ?>
                <form method="POST" action="<?php echo e(route('favorites.toggle')); ?>">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="farmer_id" value="<?php echo e($user->id); ?>">
                    <button class="btn btn-outline-danger rounded-pill" type="submit">
                        <i class="bi <?php echo e($isFavorite ? 'bi-heart-fill' : 'bi-heart'); ?> me-1"></i><?php echo e($isFavorite ? 'Saved farmer' : 'Favorite farmer'); ?>

                    </button>
                </form>
            <?php endif; ?>
        <?php endif; ?>
    </header>

    <div class="row g-4 storefront-grid">
        <section class="col-xl-8 storefront-main" aria-label="Farmer products">
            <div class="panel storefront-section">
                <div class="panel-head">
                    <div>
                        <span class="eyebrow">Fresh from the farm</span>
                        <h2 class="h4 mb-0">Available products</h2>
                    </div>
                    <span class="text-muted small"><?php echo e($products->total()); ?> items</span>
                </div>

                <div class="row g-3 storefront-products">
                    <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="col-md-6">
                            <article class="product-card h-100">
                                <div class="product-photo storefront-product-photo">
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
                                    <span class="stock-pill"><i class="bi bi-box-seam me-1"></i><?php echo e($product->stock_quantity); ?> <?php echo e($product->unit); ?> left</span>
                                </div>
                                <div class="p-3 storefront-product-copy">
                                    <div class="small text-muted storefront-meta"><?php echo e($product->category?->name ?? 'Farm goods'); ?><?php if($product->market): ?> · <?php echo e($product->market->name); ?><?php endif; ?></div>
                                    <h5><?php echo e($product->name); ?></h5>
                                    <div class="d-flex justify-content-between align-items-center gap-2">
                                        <strong class="price">Rs <?php echo e(number_format($product->price, 2)); ?></strong>
                                        <a class="btn btn-sm btn-success rounded-pill" href="<?php echo e(route('products.show', $product)); ?>">View product</a>
                                    </div>
                                </div>
                            </article>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="col-12"><div class="empty-state">No products are available right now.</div></div>
                    <?php endif; ?>
                </div>

                <?php if($products->hasPages()): ?>
                    <div class="mt-4"><?php echo e($products->links()); ?></div>
                <?php endif; ?>
            </div>
        </section>

        <aside class="col-xl-4 storefront-aside">
            <section class="panel">
                <span class="eyebrow">Pickup information</span>
                <h2 class="h4 mt-2"><?php echo e($user->farmerProfile?->operating_days ?? 'Market days'); ?></h2>
                <p class="text-muted"><?php echo e($user->farmerProfile?->pickup_windows ?? 'Pickup windows are shown during checkout.'); ?></p>
                <p class="mb-0"><i class="bi bi-geo-alt me-1"></i><?php echo e($user->farmerProfile?->address); ?></p>
                <?php if($user->farmerProfile?->latitude && $user->farmerProfile?->longitude): ?>
                    <a class="btn btn-sm btn-outline-success rounded-pill mt-3 storefront-map" target="_blank" rel="noopener" href="https://www.openstreetmap.org/?mlat=<?php echo e($user->farmerProfile->latitude); ?>&mlon=<?php echo e($user->farmerProfile->longitude); ?>#map=16/<?php echo e($user->farmerProfile->latitude); ?>/<?php echo e($user->farmerProfile->longitude); ?>">
                        <i class="bi bi-sign-turn-right me-1"></i>Open map
                    </a>
                <?php endif; ?>
            </section>

            <section class="panel">
                <span class="eyebrow">From customers</span>
                <h2 class="h4 mt-2">Reviews</h2>
                <?php $__empty_1 = true; $__currentLoopData = $reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="review-mini">
                        <div class="stars"><?php echo e(str_repeat('★', $review->rating)); ?><?php echo e(str_repeat('☆', 5 - $review->rating)); ?></div>
                        <b><?php echo e($review->customer->name); ?></b>
                        <p><?php echo e($review->comment); ?></p>
                        <?php if($review->farmer_reply): ?>
                            <small class="text-success"><?php echo e($review->farmer_reply); ?></small>
                        <?php endif; ?>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="empty-state">No reviews yet.</div>
                <?php endif; ?>
            </section>
        </aside>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\MarketLink\resources\views\farmers\show.blade.php ENDPATH**/ ?>