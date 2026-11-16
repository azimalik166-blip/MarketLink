<?php $__env->startSection('content'); ?>

<div class="dashboard-wrap favorites-page">

    <div class="container">

        <div class="dashboard-hero mb-4">

            <div>
                <span class="eyebrow">Customer</span>
                <h1>Your Favorites</h1>
                <p>
                    Keep your favorite products and farmers close for your
                    next market pickup.
                </p>
            </div>

            <a
                href="<?php echo e(route('products.index')); ?>"
                class="btn btn-success rounded-pill px-4"
            >
                <i class="bi bi-search me-1"></i>
                Explore products
            </a>

        </div>


        <div class="row g-4">

            <?php $__empty_1 = true; $__currentLoopData = $favorites; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $f): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                <?php if($f->product): ?>

                    <div class="col-md-6 col-xl-4">

                        <article class="favorite-card">

                            <div class="favorite-card-top">

                                <span class="favorite-category">
                                    <?php echo e($f->product->category?->name ?? 'Product'); ?>

                                </span>

                                <i class="bi bi-heart-fill favorite-heart"></i>

                            </div>


                            <div class="favorite-art favorite-photo"><?php if (isset($component)) { $__componentOriginalf7e2b17340f32a2cc74824a83da24f93 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf7e2b17340f32a2cc74824a83da24f93 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.product-media','data' => ['product' => $f->product]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('product-media'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['product' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($f->product)]); ?>
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


                            <div class="favorite-content">

                                <h4>
                                    <?php echo e($f->product->name); ?>

                                </h4>

                                <p class="favorite-farmer">
                                    <i class="bi bi-shop me-1"></i>
                                    <?php echo e($f->product->farmer?->farmerProfile?->stall_name
                                        ?? $f->product->farmer?->name
                                        ?? 'Local farmer'); ?>

                                </p>


                                <div class="d-flex justify-content-between align-items-center mb-3">

                                    <div class="favorite-price">
                                        Rs <?php echo e(number_format($f->product->price, 2)); ?>

                                        <small>/ <?php echo e($f->product->unit); ?></small>
                                    </div>

                                    <?php if($f->product->is_available && $f->product->stock_quantity > 0): ?>

                                        <span class="favorite-stock">
                                            <?php echo e($f->product->stock_quantity); ?> left
                                        </span>

                                    <?php else: ?>

                                        <span class="favorite-stock sold">
                                            Sold out
                                        </span>

                                    <?php endif; ?>

                                </div>


                                <div class="d-flex gap-2">

                                    <a
                                        href="<?php echo e(route('products.show', $f->product)); ?>"
                                        class="btn btn-success rounded-pill flex-grow-1"
                                    >
                                        View product
                                    </a>

                                    <form
                                        method="POST"
                                        action="<?php echo e(route('favorites.toggle')); ?>"
                                    >
                                        <?php echo csrf_field(); ?>

                                        <input
                                            type="hidden"
                                            name="product_id"
                                            value="<?php echo e($f->product->id); ?>"
                                        >

                                        <button
                                            type="submit"
                                            class="btn btn-outline-danger rounded-pill"
                                            title="Remove from favorites"
                                            aria-label="Remove from favorites"
                                        >
                                            <i class="bi bi-heart-fill"></i>
                                        </button>

                                    </form>

                                </div>

                            </div>

                        </article>

                    </div>

                <?php elseif($f->farmer): ?>

                    <div class="col-md-6 col-xl-4">

                        <article class="favorite-card">

                            <div class="favorite-card-top">
                                <span class="favorite-category">
                                    Farmer
                                </span>

                                <i class="bi bi-heart-fill favorite-heart"></i>
                            </div>

                            <div class="favorite-art farmer-art">
                                <i class="bi bi-shop"></i>
                            </div>

                            <div class="favorite-content">

                                <h4>
                                    <?php echo e($f->farmer->farmerProfile?->stall_name
                                        ?? $f->farmer->name); ?>

                                </h4>

                                <p class="favorite-farmer">
                                    <i class="bi bi-geo-alt me-1"></i>
                                    <?php echo e($f->farmer->farmerProfile?->address ?? 'Local market farmer'); ?>

                                </p>

                                <form
                                    method="POST"
                                    action="<?php echo e(route('favorites.toggle')); ?>"
                                >
                                    <?php echo csrf_field(); ?>

                                    <input
                                        type="hidden"
                                        name="farmer_id"
                                        value="<?php echo e($f->farmer_id); ?>"
                                    >

                                    <button
                                        type="submit"
                                        class="btn btn-outline-danger rounded-pill w-100"
                                    >
                                        <i class="bi bi-heart-fill me-1"></i>
                                        Remove favorite
                                    </button>

                                </form>

                            </div>

                        </article>

                    </div>

                <?php endif; ?>

            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                <div class="col-12">

                    <div class="favorites-empty">

                        <div class="favorites-empty-icon">
                            <i class="bi bi-heart"></i>
                        </div>

                        <h3>
                            No favorites yet
                        </h3>

                        <p>
                            Tap the heart on a product to save it here.
                        </p>

                        <a
                            href="<?php echo e(route('products.index')); ?>"
                            class="btn btn-success rounded-pill px-4"
                        >
                            Browse products
                        </a>

                    </div>

                </div>

            <?php endif; ?>

        </div>

    </div>

</div>


<style>
    .favorite-card {
        height: 100%;
        overflow: hidden;
        border: 1px solid var(--line);
        border-radius: 24px;
        background: #fff;
        box-shadow: 0 10px 30px rgba(9,56,47,.05);
        transition: transform .2s ease, box-shadow .2s ease;
    }

    .favorite-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 18px 40px rgba(9,56,47,.10);
    }

    .favorite-card-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 16px 18px 0;
    }

    .favorite-category {
        padding: 6px 10px;
        border-radius: 999px;
        background: #eef8f4;
        color: var(--green);
        text-transform: uppercase;
        letter-spacing: .08em;
        font-size: .66rem;
        font-weight: 800;
    }

    .favorite-heart {
        color: #e5484d;
    }

    .favorite-art {
        height: 155px;
        margin: 14px 18px 0;
        border-radius: 18px;
        display: grid;
        place-items: center;
        background: linear-gradient(135deg, #e7f7ef, #fff1d4);
        font-size: 5.2rem;
    }

    .farmer-art {
        color: var(--green);
        font-size: 4rem;
    }

    .favorite-content {
        padding: 19px 20px 21px;
    }

    .favorite-content h4 {
        margin-bottom: 7px;
        font-size: 1.15rem;
        font-weight: 800;
    }

    .favorite-farmer {
        color: var(--muted);
        min-height: 25px;
        font-size: .84rem;
        margin-bottom: 17px;
    }

    .favorite-price {
        color: var(--green);
        font: 800 1.15rem Manrope, sans-serif;
    }

    .favorite-price small {
        color: var(--muted);
        font: 400 .78rem 'DM Sans', sans-serif;
    }

    .favorite-stock {
        padding: 5px 9px;
        border-radius: 999px;
        background: #eaf7ef;
        color: #16743d;
        font-size: .68rem;
        font-weight: 800;
    }

    .favorite-stock.sold {
        background: #feecec;
        color: #b42318;
    }

    .favorites-empty {
        padding: 70px 25px;
        text-align: center;
        border: 1px dashed #d5e4dc;
        border-radius: 24px;
        background: #fbfdfc;
    }

    .favorites-empty-icon {
        width: 68px;
        height: 68px;
        margin: 0 auto 18px;
        display: grid;
        place-items: center;
        border-radius: 50%;
        background: #edf7f2;
        color: var(--green);
        font-size: 1.7rem;
    }

    .favorites-empty h3 {
        font-weight: 800;
    }

    .favorites-empty p {
        color: var(--muted);
        margin-bottom: 20px;
    }

    /* DARK MODE */
    .theme-dark .favorite-card {
        background: var(--surface);
        border-color: var(--line);
        box-shadow: var(--shadow);
        color: var(--ink);
    }

    .theme-dark .favorite-card:hover {
        border-color: #356257;
        box-shadow: var(--shadow-lg);
    }

    .theme-dark .favorite-category {
        background: rgba(79, 195, 157, .12);
        color: var(--green);
        border: 1px solid rgba(79, 195, 157, .12);
    }

    .theme-dark .favorite-art {
        background: linear-gradient(135deg, #15382f, #302a1a);
    }

    .theme-dark .farmer-art {
        color: var(--green);
    }

    .theme-dark .favorite-content h4 {
        color: var(--ink);
    }

    .theme-dark .favorite-farmer {
        color: var(--muted);
    }

    .theme-dark .favorite-price {
        color: var(--green);
    }

    .theme-dark .favorite-price small {
        color: var(--muted);
    }

    .theme-dark .favorite-stock {
        background: rgba(79, 195, 157, .12);
        color: #70d9b5;
    }

    .theme-dark .favorite-stock.sold {
        background: rgba(255, 141, 131, .12);
        color: var(--danger);
    }

    .theme-dark .favorites-empty {
        background: var(--surface);
        border-color: var(--line);
        color: var(--ink);
        box-shadow: var(--shadow);
    }

    .theme-dark .favorites-empty-icon {
        background: rgba(79, 195, 157, .10);
        color: var(--green);
    }

    .theme-dark .favorites-empty h3 {
        color: var(--ink);
    }

    .theme-dark .favorites-empty p {
        color: var(--muted);
    }

    .theme-dark .favorite-card .btn-outline-danger {
        background: rgba(255, 141, 131, .06);
        border-color: rgba(255, 141, 131, .55);
        color: var(--danger);
    }

    .theme-dark .favorite-card .btn-outline-danger:hover {
        background: var(--danger);
        border-color: var(--danger);
        color: #071512;
    }
</style>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\MarketLink\resources\views\customer\favorites.blade.php ENDPATH**/ ?>