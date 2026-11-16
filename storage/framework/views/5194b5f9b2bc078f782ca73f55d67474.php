<?php $__env->startSection('content'); ?>
<div class="container py-5"><div class="d-flex justify-content-between align-items-center flex-wrap gap-3"><div><span class="eyebrow">Inventory</span><h1>Weekly stock</h1><p class="text-muted mb-0">Add products, update price/quantity and mark items unavailable.</p></div><button class="btn btn-success rounded-pill" data-bs-toggle="modal" data-bs-target="#addProduct"><i class="bi bi-plus-lg"></i> Add product</button></div>
<div class="stock-tools mt-4">
    <div class="stock-search-wrap">
        <i class="bi bi-search"></i>
        <input type="search" id="stockSearch" class="form-control" placeholder="Search products..." autocomplete="off">
    </div>
    <select id="stockAvailability" class="form-select stock-filter">
        <option value="all">Availability: All</option>
        <option value="available">Available only</option>
        <option value="soldout">Sold out only</option>
    </select>
    <select id="stockCategory" class="form-select stock-filter">
        <option value="all">Category: All</option>
        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e(strtolower($c->name)); ?>"><?php echo e($c->name); ?></option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>
</div>
<div class="panel mt-3" id="stockPanel"><?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><div class="order-row flex-wrap stock-product-row"
     data-product-name="<?php echo e(strtolower($p->name)); ?>"
     data-product-category="<?php echo e(strtolower($p->category?->name ?? '')); ?>"
     data-product-status="<?php echo e($p->is_available && $p->stock_quantity>0 ? 'available' : 'soldout'); ?>">
<div class="flex-grow-1"><b><?php echo e($p->name); ?></b><small><?php echo e($p->category?->name); ?> · <?php echo e($p->market?->name ?? 'Market'); ?></small></div><span class="status <?php echo e($p->is_available && $p->stock_quantity>0?'status-active':'status-suspended'); ?>"><?php echo e($p->is_available && $p->stock_quantity>0?'Available':'Sold out'); ?></span><span><?php echo e($p->stock_quantity); ?> <?php echo e($p->unit); ?></span><strong>Rs <?php echo e(number_format($p->price)); ?></strong><button class="btn btn-sm btn-outline-dark rounded-pill" data-bs-toggle="modal" data-bs-target="#edit<?php echo e($p->id); ?>">Edit</button><form method="POST" action="<?php echo e(route('farmer.products.destroy',$p)); ?>" onsubmit="return confirm('Delete this product?')"><?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?><button class="btn btn-sm btn-outline-danger rounded-pill">Delete</button></form></div><div class="modal fade" id="edit<?php echo e($p->id); ?>" tabindex="-1"><div class="modal-dialog modal-lg"><div class="modal-content"><form method="POST" action="<?php echo e(route('farmer.products.update',$p)); ?>" enctype="multipart/form-data"><?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?><div class="modal-header"><h5 class="modal-title">Edit product</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div><div class="modal-body"><div class="row g-3"><div class="col-md-6"><label>Name</label><input class="form-control" name="name" value="<?php echo e($p->name); ?>" required></div><div class="col-md-6"><label>Category</label><select class="form-select" name="category_id" required><?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($c->id); ?>" <?php if($c->id==$p->category_id): echo 'selected'; endif; ?>><?php echo e($c->name); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></div><div class="col-md-6"><label>Market</label><select class="form-select" name="market_id"><option value="">Market</option><?php $__currentLoopData = $markets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($m->id); ?>" <?php if($m->id==$p->market_id): echo 'selected'; endif; ?>><?php echo e($m->name); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></div><div class="col-md-3"><label>Price</label><input class="form-control" name="price" type="number" step="0.01" min="0" value="<?php echo e($p->price); ?>" required></div><div class="col-md-3"><label>Unit</label><input class="form-control" name="unit" value="<?php echo e($p->unit); ?>" required></div><div class="col-md-6"><label>Stock quantity</label><input class="form-control" name="stock_quantity" type="number" min="0" value="<?php echo e($p->stock_quantity); ?>" required></div><div class="col-md-6"><label>Replace image</label><input class="form-control" name="image" type="file" accept="image/*"></div><div class="col-12"><label>Description</label><textarea class="form-control" name="description" rows="3"><?php echo e($p->description); ?></textarea></div><div class="col-12"><div class="form-check"><input class="form-check-input" type="checkbox" name="is_available" value="1" <?php if($p->is_available): echo 'checked'; endif; ?>><label class="form-check-label">Available for customers</label></div></div></div></div><div class="modal-footer"><button class="btn btn-success">Save changes</button></div></form></div></div></div><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><div class="empty-state">No products yet.</div><?php endif; ?></div></div>

<div class="stock-pagination-wrap" id="stockPagination" aria-label="Manage stock pagination">
    <div class="stock-pagination-top">
        <button type="button" class="stock-page-control" id="stockPrev">
            <i class="bi bi-chevron-left"></i> Previous
        </button>
        <span class="stock-page-summary" id="stockSummary"></span>
        <button type="button" class="stock-page-control" id="stockNext">
            Next <i class="bi bi-chevron-right"></i>
        </button>
    </div>
    <div class="stock-page-numbers" id="stockPageNumbers"></div>
</div>
<div class="modal fade" id="addProduct" tabindex="-1"><div class="modal-dialog modal-lg"><div class="modal-content"><form method="POST" action="<?php echo e(route('farmer.products.store')); ?>" enctype="multipart/form-data"><?php echo csrf_field(); ?><div class="modal-header"><h5 class="modal-title">Add weekly product</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div><div class="modal-body"><div class="row g-3"><div class="col-md-6"><label>Name</label><input class="form-control" name="name" required></div><div class="col-md-6"><label>Category</label><select class="form-select" name="category_id" required><option value="">Choose</option><?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($c->id); ?>"><?php echo e($c->name); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></div><div class="col-md-6"><label>Market</label><select class="form-select" name="market_id"><option value="">Market</option><?php $__currentLoopData = $markets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($m->id); ?>"><?php echo e($m->name); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></div><div class="col-md-3"><label>Price</label><input class="form-control" name="price" type="number" step="0.01" min="0" required></div><div class="col-md-3"><label>Unit</label><input class="form-control" name="unit" placeholder="kg, dozen..." required></div><div class="col-md-6"><label>Quantity</label><input class="form-control" name="stock_quantity" type="number" min="0" required></div><div class="col-md-6"><label>Image</label><input class="form-control" name="image" type="file" accept="image/*"></div><div class="col-12"><label>Description</label><textarea class="form-control" name="description" rows="3"></textarea></div></div></div><div class="modal-footer"><button class="btn btn-success">Add product</button></div></form></div></div></div>

<style>
/* Manage Stock: compact MarketLink filter + pagination, without changing existing forms. */
.stock-tools{
    display:grid;
    grid-template-columns:minmax(260px,1fr) 190px 190px;
    gap:10px;
    align-items:center;
}
.stock-search-wrap{
    position:relative;
}
.stock-search-wrap > i{
    position:absolute;
    left:14px;
    top:50%;
    transform:translateY(-50%);
    color:#6d817b;
    z-index:2;
}
.stock-search-wrap .form-control{
    padding-left:40px;
}
.stock-tools .form-control,
.stock-tools .form-select{
    height:42px;
    border:1px solid #d7e3df;
    border-radius:12px;
    background:#fff;
    color:#18302b;
    box-shadow:none;
    font-size:12px;
}
.stock-tools .form-control:focus,
.stock-tools .form-select:focus{
    border-color:#15947f;
    box-shadow:0 0 0 .18rem rgba(21,148,127,.10);
}
.stock-product-row.stock-hidden{
    display:none!important;
}
.stock-pagination-wrap{
    display:flex;
    flex-direction:column;
    align-items:center;
    gap:10px;
    padding:20px 0 4px;
}
.stock-pagination-top{
    display:flex;
    align-items:center;
    justify-content:center;
}
.stock-page-control{
    height:38px;
    min-width:86px;
    padding:0 13px;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap:6px;
    border:1px solid #d7e3df;
    background:#fff;
    color:#087e6e;
    font-size:11px;
    font-weight:700;
    cursor:pointer;
}
.stock-page-control:first-child{border-radius:10px 0 0 10px}
.stock-page-control:last-child{border-radius:0 10px 10px 0}
.stock-page-control:hover:not(:disabled){
    background:#f0f8f5;
    border-color:#b9d8d0;
}
.stock-page-control:disabled{
    opacity:.42;
    cursor:not-allowed;
}
.stock-page-summary{
    height:38px;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    padding:0 14px;
    border-top:1px solid #d7e3df;
    border-bottom:1px solid #d7e3df;
    background:#fff;
    color:#657873;
    font-size:10px;
    white-space:nowrap;
}
.stock-page-numbers{
    display:flex;
    align-items:center;
    justify-content:center;
}
.stock-page-number{
    width:42px;
    height:38px;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    border:1px solid #d7e3df;
    border-left:0;
    background:#fff;
    color:#087e6e;
    font-size:11px;
    font-weight:700;
    text-decoration:none;
    cursor:pointer;
}
.stock-page-number:first-child{border-left:1px solid #d7e3df;border-radius:9px 0 0 9px}
.stock-page-number:last-child{border-radius:0 9px 9px 0}
.stock-page-number:hover{background:#f0f8f5}
.stock-page-number.active{
    background:#087e6e;
    color:#fff;
    border-color:#087e6e;
    box-shadow:0 6px 14px rgba(8,126,110,.16);
}
.stock-empty-filter{
    padding:35px 20px;
    text-align:center;
    color:#6d817b;
    font-size:13px;
}
@media(max-width:767.98px){
    .stock-tools{grid-template-columns:1fr}
    .stock-pagination-top{
        width:100%;
        display:grid;
        grid-template-columns:auto 1fr auto;
    }
    .stock-page-control{min-width:70px;padding:0 8px}
    .stock-page-summary{
        min-width:0;
        overflow:hidden;
        text-overflow:ellipsis;
    }
    .stock-page-numbers{
        max-width:100%;
        overflow-x:auto;
        justify-content:flex-start;
        padding-bottom:2px;
    }
    .stock-page-number{flex:0 0 42px}
}

.stock-page-dots{
    cursor:default;
    color:#7a8b86;
}
.stock-page-dots:hover{
    background:#fff;
}

</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const panel = document.getElementById('stockPanel');
    const search = document.getElementById('stockSearch');
    const availability = document.getElementById('stockAvailability');
    const category = document.getElementById('stockCategory');
    const prev = document.getElementById('stockPrev');
    const next = document.getElementById('stockNext');
    const summary = document.getElementById('stockSummary');
    const pageNumbers = document.getElementById('stockPageNumbers');

    if (!panel || !search || !availability || !category || !prev || !next || !summary || !pageNumbers) return;

    const rows = Array.from(panel.querySelectorAll('.stock-product-row'));
    const perPage = 12;
    let page = 1;
    let filtered = rows.slice();

    function applyFilters() {
        const q = String(search.value || '').trim().toLowerCase();
        const status = String(availability.value || 'all').toLowerCase();
        const cat = String(category.value || 'all').trim().toLowerCase();

        filtered = rows.filter(function (row) {
            const name = String(row.dataset.productName || '').toLowerCase();
            const rowCategory = String(row.dataset.productCategory || '').trim().toLowerCase();
            const rowStatus = String(row.dataset.productStatus || '').toLowerCase();

            const matchesSearch = q === '' || name.includes(q);
            const matchesStatus = status === 'all' || rowStatus === status;
            const matchesCategory = cat === 'all' || rowCategory === cat;

            return matchesSearch && matchesStatus && matchesCategory;
        });

        page = 1;
        render();
    }

    function render() {
        const totalPages = Math.max(1, Math.ceil(filtered.length / perPage));
        if (page > totalPages) page = totalPages;

        rows.forEach(function (row) {
            row.classList.add('stock-hidden');
        });

        const start = (page - 1) * perPage;
        const visible = filtered.slice(start, start + perPage);

        visible.forEach(function (row) {
            row.classList.remove('stock-hidden');
        });

        if (filtered.length) {
            summary.textContent = 'Showing ' + (start + 1) + '–' +
                Math.min(start + perPage, filtered.length) + ' of ' + filtered.length + ' products';
        } else {
            summary.textContent = 'Showing 0 of 0 products';
        }

        prev.disabled = page <= 1 || !filtered.length;
        next.disabled = page >= totalPages || !filtered.length;

        pageNumbers.innerHTML = '';

        let pages = [];
        if (totalPages <= 7) {
            pages = Array.from({length: totalPages}, (_, i) => i + 1);
        } else {
            pages = [1];
            if (page > 4) pages.push('…');
            const startPage = Math.max(2, page - 1);
            const endPage = Math.min(totalPages - 1, page + 1);
            for (let i = startPage; i <= endPage; i++) pages.push(i);
            if (page < totalPages - 3) pages.push('…');
            pages.push(totalPages);
        }

        pages.forEach(function (value) {
            if (value === '…') {
                const dots = document.createElement('span');
                dots.className = 'stock-page-number stock-page-dots';
                dots.textContent = '…';
                pageNumbers.appendChild(dots);
                return;
            }

            const btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'stock-page-number' + (value === page ? ' active' : '');
            btn.textContent = value;
            btn.addEventListener('click', function () {
                page = value;
                render();
                window.scrollTo({top: panel.offsetTop - 90, behavior: 'smooth'});
            });
            pageNumbers.appendChild(btn);
        });

        const empty = panel.querySelector('.stock-empty-filter');
        if (empty) empty.remove();

        if (!filtered.length) {
            const msg = document.createElement('div');
            msg.className = 'stock-empty-filter';
            msg.textContent = 'No products match your filters.';
            panel.appendChild(msg);
        }
    }

    search.addEventListener('input', applyFilters);
    availability.addEventListener('change', applyFilters);
    category.addEventListener('change', applyFilters);

    prev.addEventListener('click', function () {
        if (page > 1) {
            page--;
            render();
        }
    });

    next.addEventListener('click', function () {
        const totalPages = Math.max(1, Math.ceil(filtered.length / perPage));
        if (page < totalPages) {
            page++;
            render();
        }
    });

    render();
});
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\MarketLink\resources\views\farmer\products.blade.php ENDPATH**/ ?>