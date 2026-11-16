<?php $__env->startSection('content'); ?>

<div class="dashboard-wrap">

    <div class="container">

        <div class="dashboard-hero mb-4">

            <div>
                <span class="eyebrow">Shopping bag</span>
                <h1>Your market cart</h1>
                <p>
                    Add several products, adjust quantities and check out
                    with pickup details.
                </p>
            </div>

            <a
                href="<?php echo e(route('products.index')); ?>"
                class="btn btn-outline-dark rounded-pill"
            >
                <i class="bi bi-arrow-left me-1"></i>
                Continue shopping
            </a>

        </div>


        <?php if($items->isEmpty()): ?>

            <div class="favorites-empty">

                <div class="favorites-empty-icon">
                    <i class="bi bi-bag"></i>
                </div>

                <h3>Your cart is empty</h3>

                <p>
                    Explore local products and add something fresh.
                </p>

                <a
                    href="<?php echo e(route('products.index')); ?>"
                    class="btn btn-success rounded-pill px-4"
                >
                    Browse products
                </a>

            </div>

        <?php else: ?>

            <div class="row g-4">

                <div class="col-xl-8">

                    <div class="panel">

                        <div class="cart-heading">
                            <div>
                                <span class="eyebrow">Saved items</span>
                                <h4 class="mb-0">
                                    <?php echo e($cartCount); ?>

                                    <?php echo e($cartCount === 1 ? 'item' : 'items'); ?>

                                </h4>
                            </div>
                        </div>


                        <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                            <div class="cart-row">

                                <div class="cart-art"><?php if (isset($component)) { $__componentOriginalf7e2b17340f32a2cc74824a83da24f93 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf7e2b17340f32a2cc74824a83da24f93 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.product-media','data' => ['product' => $item->product]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('product-media'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['product' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($item->product)]); ?>
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


                                <div class="flex-grow-1">

                                    <h5 class="mb-1">
                                        <?php echo e($item->product->name); ?>

                                    </h5>

                                    <small class="text-muted">
                                        <?php echo e($item->product->farmer
                                                ->farmerProfile
                                                ?->stall_name
                                            ?? $item->product->farmer->name); ?>

                                    </small>

                                    <div class="mt-1 text-success fw-bold">
                                        Rs <?php echo e(number_format(
                                                $item->product->price,
                                                2
                                            )); ?>

                                        /
                                        <?php echo e($item->product->unit); ?>

                                    </div>

                                    <?php if($item->product->stock_quantity <= 5): ?>
                                        <span class="badge bg-warning-subtle text-warning-emphasis mt-2">
                                            Only <?php echo e($item->product->stock_quantity); ?>

                                            <?php echo e($item->product->unit); ?> left
                                        </span>
                                    <?php endif; ?>

                                </div>


                                <form
                                    method="POST"
                                    action="<?php echo e(route('cart.update', $item->product)); ?>"
                                    class="cart-quantity-form"
                                >

                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('PATCH'); ?>

                                    <label
                                        class="visually-hidden"
                                        for="qty_<?php echo e($item->id); ?>"
                                    >
                                        Quantity
                                    </label>

                                    <input
                                        id="qty_<?php echo e($item->id); ?>"
                                        type="number"
                                        name="quantity"
                                        min="0"
                                        max="<?php echo e($item->product->stock_quantity); ?>"
                                        value="<?php echo e($item->quantity); ?>"
                                        class="form-control"
                                    >

                                    <button
                                        class="btn btn-outline-dark btn-sm rounded-pill"
                                        type="submit"
                                    >
                                        Update
                                    </button>

                                </form>


                                <strong class="text-nowrap">
                                    Rs <?php echo e(number_format(
                                            $item->product->price * $item->quantity
                                        )); ?>

                                </strong>


                                <form
                                    method="POST"
                                    action="<?php echo e(route('cart.remove', $item->product)); ?>"
                                >

                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>

                                    <button
                                        type="submit"
                                        class="btn btn-outline-danger btn-sm rounded-circle"
                                        title="Remove"
                                        aria-label="Remove <?php echo e($item->product->name); ?>"
                                    >
                                        <i class="bi bi-trash"></i>
                                    </button>

                                </form>

                            </div>

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    </div>

                </div>


                <div class="col-xl-4">

                    <div
                        class="checkout-card sticky-xl-top"
                        style="top:90px"
                    >

                        <span class="eyebrow">
                            Summary
                        </span>

                        <h4 class="mt-2">
                            Cart total
                        </h4>


                        <div class="d-flex justify-content-between my-3">
                            <span>Items</span>
                            <strong><?php echo e($cartCount); ?></strong>
                        </div>


                        <div class="d-flex justify-content-between pb-3 border-bottom">
                            <span>Subtotal</span>

                            <strong>
                                Rs <?php echo e(number_format($total)); ?>

                            </strong>
                        </div>


                        <div class="pay-note mt-3">

                            <i class="bi bi-wallet2"></i>

                            <div>
                                <strong>Pay at pickup</strong>

                                <small>
                                    No online payment is required.
                                </small>
                            </div>

                        </div>


                        <a
                            href="<?php echo e(route('checkout')); ?>"
                            class="btn btn-success w-100 rounded-pill mt-4 py-3"
                        >
                            Continue to checkout
                            <i class="bi bi-arrow-right ms-1"></i>
                        </a>


                        <form
                            method="POST"
                            action="<?php echo e(route('cart.clear')); ?>"
                            class="mt-2"
                            onsubmit="return confirm('Clear all items from your cart?');"
                        >

                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>

                            <button
                                class="btn btn-outline-secondary w-100 rounded-pill"
                                type="submit"
                            >
                                Clear cart
                            </button>

                        </form>

                    </div>

                </div>

            </div>

        <?php endif; ?>

    </div>

</div>


<style>
    .cart-heading {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 7px;
    }

    .cart-quantity-form {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .cart-quantity-form input {
        width: 78px;
    }

    @media (max-width: 767px) {
        .cart-quantity-form {
            width: 100%;
            justify-content: flex-start;
        }

        .cart-quantity-form input {
            width: 90px;
        }
    }
</style>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\MarketLink\resources\views\cart\index.blade.php ENDPATH**/ ?>