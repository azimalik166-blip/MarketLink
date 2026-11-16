<?php $__env->startSection('content'); ?>
<div class="page-head"><div class="container"><span class="eyebrow">Explore</span><h1>Fresh weekly market stock</h1><p>Search products, compare offers and choose a pickup market.</p></div></div>
<div class="container py-5">
<form class="filter-bar mb-4" method="GET" action="<?php echo e(route('products.index')); ?>"><div class="row g-2 align-items-end"><div class="col-lg-4"><label><i class="bi bi-search me-1"></i>Search</label><input name="q" value="<?php echo e(request('q')); ?>" class="form-control" placeholder="Tomatoes, eggs, mangoes..."></div><div class="col-md-3 col-lg-2"><label><i class="bi bi-tags me-1"></i>Category</label><select name="category" class="form-select"><option value="">All</option><?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($c->id); ?>" <?php if(request('category')==$c->id): echo 'selected'; endif; ?>><?php echo e($c->name); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></div><div class="col-md-3 col-lg-2"><label><i class="bi bi-shop me-1"></i>Market</label><select name="market" class="form-select"><option value="">All</option><?php $__currentLoopData = $markets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($m->id); ?>" <?php if(request('market')==$m->id): echo 'selected'; endif; ?>><?php echo e($m->name); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></div><div class="col-md-3 col-lg-2"><label><i class="bi bi-person-badge me-1"></i>Farmer</label><select name="farmer" class="form-select"><option value="">All</option><?php $__currentLoopData = $farmers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $f): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($f->id); ?>" <?php if(request('farmer')==$f->id): echo 'selected'; endif; ?>><?php echo e($f->farmerProfile?->stall_name ?? $f->name); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></div><div class="col-md-3 col-lg-2"><label><i class="bi bi-sort-down me-1"></i>Sort</label><select name="sort" class="form-select"><option value="latest">Newest</option><option value="price_low" <?php if(request('sort')==='price_low'): echo 'selected'; endif; ?>>Price low → high</option><option value="price_high" <?php if(request('sort')==='price_high'): echo 'selected'; endif; ?>>Price high → low</option><option value="top_rated" <?php if(request('sort')==='top_rated'): echo 'selected'; endif; ?>>Top rated</option><option value="name" <?php if(request('sort')==='name'): echo 'selected'; endif; ?>>Name</option></select></div><div class="col-md-auto"><button class="btn btn-success rounded-pill"><i class="bi bi-funnel me-1"></i>Apply</button></div></div></form>
<style>
.compare-toolbar{background:linear-gradient(135deg,rgba(18,137,111,.08),rgba(255,193,7,.10));border:1px solid rgba(18,137,111,.16);border-radius:18px;padding:12px 14px}.compare-summary{display:flex;align-items:center;gap:8px;font-weight:600;color:#35534b}.compare-summary .compare-count{display:inline-flex;align-items:center;justify-content:center;min-width:30px;height:26px;padding:0 9px;border-radius:999px;background:#fff;border:1px solid rgba(18,137,111,.18);color:#087f68;font-size:.8rem}.compare-action{border:1px solid rgba(18,137,111,.28)!important;color:#087f68!important;background:#fff!important;transition:.2s ease}.compare-action:not(:disabled):hover{background:#087f68!important;color:#fff!important;transform:translateY(-1px)}.compare-action:disabled{opacity:.55;cursor:not-allowed}.compare-control{display:inline-flex;align-items:center;gap:7px;cursor:pointer;user-select:none;margin:0}.compare-control input{position:absolute;opacity:0;pointer-events:none}.compare-box{width:24px;height:24px;border:1.5px solid #a7c8c0;border-radius:8px;background:#fff;display:inline-flex;align-items:center;justify-content:center;color:#fff;transition:.2s ease;box-shadow:0 2px 7px rgba(12,65,56,.06)}.compare-box i{font-size:14px;transform:scale(.7);opacity:0;transition:.2s ease}.compare-control input:checked + .compare-box{background:#0b8972;border-color:#0b8972;box-shadow:0 4px 12px rgba(11,137,114,.22)}.compare-control input:checked + .compare-box i{opacity:1;transform:scale(1)}.compare-label{font-size:.78rem;font-weight:650;color:#44635b}.product-card.compare-picked{border-color:rgba(11,137,114,.48);box-shadow:0 0 0 3px rgba(11,137,114,.08),0 14px 30px rgba(12,65,56,.10)}
@media (max-width:575px){.compare-toolbar{padding:10px}.compare-label{font-size:.75rem}}
</style>
<style>
.market-pagination-wrap{display:flex;flex-direction:column;align-items:center;gap:10px}.market-pagination{display:flex;align-items:center;justify-content:center;gap:8px;flex-wrap:wrap;width:100%}.market-page-numbers{display:flex;align-items:center;gap:6px;flex-wrap:wrap;justify-content:center}.market-page-number,.market-page-arrow{display:inline-flex;align-items:center;justify-content:center;min-height:38px;border:1px solid var(--line);background:var(--surface);color:var(--ink);text-decoration:none;box-shadow:0 4px 12px rgba(12,65,56,.05);transition:transform .18s ease,background .18s ease,border-color .18s ease,color .18s ease,box-shadow .18s ease}.market-page-number{min-width:38px;padding:0 10px;border-radius:11px;font-size:.78rem;font-weight:700}.market-page-arrow{gap:7px;padding:0 13px;border-radius:12px;font-size:.76rem;font-weight:750;color:var(--green)}.market-page-number:hover,.market-page-arrow:hover{transform:translateY(-1px);border-color:rgba(11,137,114,.35);color:var(--green);background:var(--surface-2);box-shadow:0 8px 18px rgba(12,65,56,.09)}.market-page-number.active{background:linear-gradient(135deg,#0b8972,#087964);border-color:#0b8972;color:#fff;box-shadow:0 8px 18px rgba(11,137,114,.20)}.market-page-arrow.disabled{opacity:.42;pointer-events:none}.market-pagination-meta{font-size:.72rem;color:var(--muted)}html.theme-dark .market-page-number,html.theme-dark .market-page-arrow{background:var(--surface);border-color:var(--line);color:var(--ink);box-shadow:none}html.theme-dark .market-page-number:hover,html.theme-dark .market-page-arrow:hover{background:var(--surface-2);border-color:var(--green);color:var(--ink)}html.theme-dark .market-page-number.active{background:var(--green);border-color:var(--green);color:#07251f}@media (max-width:575px){.market-pagination{gap:6px}.market-page-arrow{padding:0 10px}.market-page-arrow span{display:none}.market-page-number{min-width:34px;padding:0 8px}}
</style>
<div id="productsCompareControls" class="compare-toolbar d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
    <div class="compare-summary"><i class="bi bi-columns-gap"></i><span><?php echo e($products->total()); ?> product(s) available</span><span class="compare-count" id="compareCount">0</span></div>
    <button class="btn btn-sm rounded-pill px-3 compare-action" type="button" id="compareButton" disabled aria-disabled="true">
        <i class="bi bi-columns-gap me-1"></i>Compare selected
    </button>
</div>
<div class="row g-4" id="productsGrid">
<?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
<div class="col-6 col-md-4 col-xl-3"><div class="product-card h-100" data-product-card="<?php echo e($product->id); ?>"><div class="product-photo"><?php if (isset($component)) { $__componentOriginalf7e2b17340f32a2cc74824a83da24f93 = $component; } ?>
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
<?php endif; ?><span class="stock-pill"><i class="bi bi-box-seam me-1"></i><?php echo e($product->stock_quantity); ?> <?php echo e($product->unit); ?> left</span></div><div class="p-3"><div class="small text-muted"><?php echo e($product->category?->name); ?> · <?php echo e($product->market?->name ?? 'Market'); ?></div><h5 class="mt-1"><a class="text-decoration-none text-dark" href="<?php echo e(route('products.show',$product)); ?>"><?php echo e($product->name); ?></a></h5><div class="d-flex justify-content-between align-items-center"><strong class="price">Rs <?php echo e(number_format($product->price,2)); ?></strong><span class="small">/<?php echo e($product->unit); ?></span></div><div class="small mt-1 text-warning"><?php echo e(number_format((float)($product->reviews_avg_rating??0),1)); ?> ★ <span class="text-muted"><?php echo e($product->reviews_count); ?> reviews</span></div><div class="d-flex gap-2 mt-3 align-items-center"><label class="compare-control"><input type="checkbox" name="ids[]" value="<?php echo e($product->id); ?>"><span class="compare-box"><i class="bi bi-check2"></i></span><span class="compare-label">Compare</span></label><a href="<?php echo e(route('products.show',$product)); ?>" class="btn btn-sm btn-success rounded-pill flex-grow-1"><i class="bi bi-eye me-1"></i>View</a><?php if(auth()->guard()->check()): ?> <?php if(auth()->user()->role==='customer'): ?><form method="post" action="<?php echo e(route('cart.add')); ?>" class="cart-ajax-form"><?php echo csrf_field(); ?><input type="hidden" name="product_id" value="<?php echo e($product->id); ?>"><input type="hidden" name="quantity" value="1"><button class="circle-btn border-0" type="submit" title="Add to cart" aria-label="Add <?php echo e($product->name); ?> to cart"><i class="bi bi-bag-plus"></i></button></form><form method="post" action="<?php echo e(route('favorites.toggle')); ?>"><?php echo csrf_field(); ?><input type="hidden" name="product_id" value="<?php echo e($product->id); ?>"><button class="circle-btn border-0" title="Favorite" type="submit"><i class="bi <?php echo e($favoriteProductIds->contains($product->id)?'bi-heart-fill text-danger':'bi-heart'); ?>"></i></button></form><?php endif; ?> <?php endif; ?></div></div></div></div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><div class="col-12"><div class="empty-state">No products match those filters.</div></div><?php endif; ?>
</div>
<div class="market-pagination-wrap mt-5" aria-label="Product pagination">
    <?php ($currentPage = $products->currentPage()); ?>
    <?php ($lastPage = $products->lastPage()); ?>
    <?php ($paginationQuery = request()->except('page')); ?>
    <?php if($lastPage > 1): ?>
        <nav class="market-pagination" aria-label="Products pages">
            <a class="market-page-arrow <?php echo e($products->onFirstPage() ? 'disabled' : ''); ?>"
               href="<?php echo e($products->onFirstPage() ? '#' : $products->appends($paginationQuery)->previousPageUrl()); ?>"
               aria-label="Previous page" <?php if($products->onFirstPage()): ?> aria-disabled="true" tabindex="-1" <?php endif; ?>>
                <i class="bi bi-chevron-left"></i><span>Previous</span>
            </a>

            <div class="market-page-numbers">
                <?php for($page = 1; $page <= $lastPage; $page++): ?>
                    <?php if($page === $currentPage): ?>
                        <span class="market-page-number active" aria-current="page"><?php echo e($page); ?></span>
                    <?php else: ?>
                        <a class="market-page-number" href="<?php echo e($products->appends($paginationQuery)->url($page)); ?>"><?php echo e($page); ?></a>
                    <?php endif; ?>
                <?php endfor; ?>
            </div>

            <a class="market-page-arrow <?php echo e($currentPage >= $lastPage ? 'disabled' : ''); ?>"
               href="<?php echo e($currentPage >= $lastPage ? '#' : $products->appends($paginationQuery)->nextPageUrl()); ?>"
               aria-label="Next page" <?php if($currentPage >= $lastPage): ?> aria-disabled="true" tabindex="-1" <?php endif; ?>>
                <span>Next</span><i class="bi bi-chevron-right"></i>
            </a>
        </nav>
        <div class="market-pagination-meta">Showing <?php echo e($products->firstItem()); ?>–<?php echo e($products->lastItem()); ?> of <?php echo e($products->total()); ?> products</div>
    <?php endif; ?>
</div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const grid = document.getElementById('productsGrid');
    const compareButton = document.getElementById('compareButton');
    const compareCount = document.getElementById('compareCount');

    function selectedInputs() {
        return Array.from(grid?.querySelectorAll('input[name="ids[]"]:checked') || []);
    }

    function selectedIds() {
        return selectedInputs().map(input => input.value);
    }

    function refreshCompareButton() {
        const ids = selectedIds();
        const count = ids.length;
        if (compareCount) compareCount.textContent = String(count);
        if (!compareButton) return;
        compareButton.disabled = count < 2;
        compareButton.setAttribute('aria-disabled', count < 2 ? 'true' : 'false');
        compareButton.innerHTML = '<i class="bi bi-columns-gap me-1"></i>' + (count < 2 ? 'Select 2 products' : 'Compare selected') + (count ? ' (' + count + ')' : '');

        grid?.querySelectorAll('[data-product-card]').forEach(card => {
            const input = card.querySelector('input[name="ids[]"]');
            card.classList.toggle('compare-picked', !!input?.checked);
        });
    }

    grid?.querySelectorAll('input[name="ids[]"]').forEach(input => {
        input.addEventListener('change', refreshCompareButton);
    });

    compareButton?.addEventListener('click', function () {
        const ids = selectedIds();
        if (ids.length < 2) return;
        const url = new URL(<?php echo json_encode(route('products.compare'), 15, 512) ?>, window.location.origin);
        ids.forEach(id => url.searchParams.append('ids[]', id));
        window.location.href = url.toString();
    });

    refreshCompareButton();
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Digital Dominators --- MarketLink\resources\views/products/index.blade.php ENDPATH**/ ?>