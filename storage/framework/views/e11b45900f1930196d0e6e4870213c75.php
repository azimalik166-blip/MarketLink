<?php $__env->startSection('content'); ?>
<div class="dashboard-wrap customer-dashboard"><div class="container"><div class="dashboard-hero mb-4"><div><span class="eyebrow">Customer space</span><h1>Hello, <?php echo e(auth()->user()->name); ?></h1><p>Your local market activity, saved places and pickup history.</p></div><div class="d-flex gap-2 flex-wrap"><a href="<?php echo e(route('products.index')); ?>" class="btn btn-success rounded-pill">Find Product</a><a href="<?php echo e(route('customer.markets')); ?>" class="btn btn-outline-dark rounded-pill">Preferred markets</a></div></div>
<div class="row g-3 mb-4"><?php $__currentLoopData = [['Orders','orders','bi-bag-check'],['Waiting','pending','bi-clock-history'],['Accepted','accepted','bi-check2'],['Ready','ready','bi-box-seam'],['Completed','completed','bi-patch-check'],['Favorites','favorites','bi-heart']]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><div class="col-6 col-md-4 col-xl-2"><div class="stat-card h-100"><i class="bi <?php echo e($s[2]); ?>"></i><small><?php echo e($s[0]); ?></small><strong><?php echo e($stats[$s[1]]); ?></strong></div></div><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></div>
<div class="row g-4 align-items-start"><div class="col-xl-8"><div class="panel"><div class="panel-head"><div><span class="eyebrow">Latest activity</span><h4 class="mb-0">My orders</h4></div><a href="<?php echo e(route('customer.orders')); ?>">View all</a></div><?php $__empty_1 = true; $__currentLoopData = $latestOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $o): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><a class="order-card-link dashboard-order-link" href="<?php echo e(route('customer.orders.show',$o)); ?>"><div class="dashboard-order-row"><div><b>#<?php echo e($o->order_number); ?></b><small><?php echo e($o->pickup_date->format('d M Y')); ?> · <?php echo e($o->pickup_slot); ?> · <?php echo e($o->market?->name ?? 'Market'); ?></small></div><span class="status status-<?php echo e($o->status); ?>"><?php echo e(ucfirst($o->status)); ?></span><strong>Rs <?php echo e(number_format($o->total_amount)); ?></strong></div></a><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><div class="empty-state">No orders yet. Start with fresh produce.</div><?php endif; ?></div></div><div class="col-xl-4"><div class="panel mb-4"><div class="panel-head"><div><span class="eyebrow">Quick access</span><h4 class="mb-0">Your market tools</h4></div></div><a class="quick-link" href="<?php echo e(route('customer.favorites')); ?>"><i class="bi bi-heart"></i><span>Favorites<small><?php echo e($stats['favorites']); ?> saved item(s)</small></span><i class="bi bi-chevron-right ms-auto"></i></a><a class="quick-link" href="<?php echo e(route('notifications.index')); ?>"><i class="bi bi-bell"></i><span>Notifications<small>Stay updated on your orders</small></span><i class="bi bi-chevron-right ms-auto"></i></a><a class="quick-link" href="<?php echo e(route('customer.profile')); ?>"><i class="bi bi-person"></i><span>Profile<small>Update your details</small></span><i class="bi bi-chevron-right ms-auto"></i></a></div><div class="feature-card customer-spend-card"><span class="eyebrow">Completed pickup spend</span><div class="display-5 fw-bold text-success">Rs <?php echo e(number_format($stats['spent'])); ?></div><p class="text-muted mb-0">Recorded from completed orders.</p></div></div></div>
<?php if($recentProducts->isNotEmpty()): ?><div class="section pt-5"><div class="section-head"><div><span class="eyebrow">Your activity</span><h2>Recently viewed</h2></div></div><div class="row g-4"><?php $__currentLoopData = $recentProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><div class="col-6 col-lg-3"><div class="product-card h-100"><div class="product-photo"><?php if (isset($component)) { $__componentOriginalf7e2b17340f32a2cc74824a83da24f93 = $component; } ?>
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
<?php endif; ?></div><div class="p-3"><h5><?php echo e($p->name); ?></h5><div class="price">Rs <?php echo e(number_format($p->price,2)); ?></div><a href="<?php echo e(route('products.show',$p)); ?>" class="btn btn-sm btn-success rounded-pill mt-3 w-100">View again</a></div></div></div><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></div></div><?php endif; ?>
<div class="section pt-5"><div class="section-head"><div><span class="eyebrow">Recommended</span><h2>Popular with MarketLink shoppers</h2></div><a href="<?php echo e(route('products.index')); ?>" class="btn btn-outline-success rounded-pill">Browse all</a></div><div class="row g-4"><?php $__currentLoopData = $recommended; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><div class="col-6 col-lg-3"><div class="product-card h-100"><div class="product-photo"><?php if (isset($component)) { $__componentOriginalf7e2b17340f32a2cc74824a83da24f93 = $component; } ?>
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
<?php endif; ?></div><div class="p-3"><div class="small text-muted"><?php echo e($p->category?->name); ?></div><h5><?php echo e($p->name); ?></h5><div class="d-flex justify-content-between align-items-center"><strong class="price">Rs <?php echo e(number_format($p->price,2)); ?></strong><span class="small text-warning"><?php echo e(number_format((float)($p->reviews_avg_rating??0),1)); ?> ★</span></div><a href="<?php echo e(route('products.show',$p)); ?>" class="btn btn-sm btn-success rounded-pill mt-3 w-100">View product</a></div></div></div><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></div></div>
</div></div>
<style>.customer-dashboard .customer-spend-card,.customer-dashboard .stat-card{height:auto!important;min-height:0}.dashboard-order-link{display:block;color:inherit;text-decoration:none!important}.dashboard-order-row{display:flex;align-items:center;gap:15px;padding:14px 4px;border:0!important;border-bottom:0!important;border-radius:14px;transition:.15s}.dashboard-order-link:hover .dashboard-order-row{background:var(--surface-2);transform:translateX(2px)}.dashboard-order-row>div:first-child{flex:1;min-width:0}.dashboard-order-row small{display:block;margin-top:4px;color:var(--muted)}.dashboard-order-row b{color:var(--green)}@media(max-width:600px){.dashboard-order-row{flex-wrap:wrap}.dashboard-order-row>strong{margin-left:auto}}
html.theme-dark .dashboard-order-link:hover .dashboard-order-row{background:var(--surface-2)}
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\MarketLink\resources\views\customer\dashboard.blade.php ENDPATH**/ ?>