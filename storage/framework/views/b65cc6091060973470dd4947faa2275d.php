<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['product', 'class' => '']));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['product', 'class' => '']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    use Illuminate\Support\Str;

    $name = strtolower(trim((string)($product->name ?? '')));
    $category = trim((string)($product->category?->name ?? ''));
    $categorySlug = Str::slug($category ?: 'market-picks');

    $realFallbacks = [
        'Fruits' => 'https://images.unsplash.com/photo-1772984613890-e3bfbca7f245?auto=format&fit=crop&w=1000&q=82',
        'Vegetables' => 'https://upload.wikimedia.org/wikipedia/commons/4/4a/Fresh_vegetables_in_Pakistan.jpg',
        'Dairy' => 'https://images.unsplash.com/photo-1643114453626-97ae781657b6?auto=format&fit=crop&w=1000&q=82',
        'Baked Goods' => 'https://images.unsplash.com/photo-1567995512752-015cd3edb4e8?auto=format&fit=crop&w=1000&q=82',
        'Herbs' => 'https://images.unsplash.com/photo-1744659747310-39564f92c25b?auto=format&fit=crop&w=1000&q=82',
        'Organic Pantry' => 'https://images.unsplash.com/photo-1633151057773-f3ef85aa6d6d?auto=format&fit=crop&w=1000&q=82',
    ];
    $fallback = $realFallbacks[$category] ?? asset('images/products/catalog/' . $categorySlug . '.svg');
    $storedImage = trim((string)($product->image ?? ''));

    if ($storedImage === '') {
        $src = $fallback;
    } elseif (Str::startsWith($storedImage, ['http://', 'https://'])) {
        $src = $storedImage;
    } elseif (Str::startsWith($storedImage, 'catalog/')) {
        $src = asset('images/products/' . $storedImage);
    } elseif (Str::startsWith($storedImage, 'images/')) {
        $src = asset($storedImage);
    } else {
        $src = route('product.media', ['path' => ltrim($storedImage, '/')]);
    }

    $icon = match (strtolower($category)) {
        'fruits' => 'bi-apple',
        'vegetables' => 'bi-leaf',
        'dairy' => 'bi-cup-hot',
        'baked goods' => 'bi-basket2',
        'herbs' => 'bi-flower1',
        'grains' => 'bi-grid-3x3-gap',
        'organic pantry' => 'bi-box-seam',
        default => 'bi-grid-3x3-gap',
    };
?>

<img
    src="<?php echo e($src); ?>"
    alt="<?php echo e($product->name); ?>"
    class="product-media-image <?php echo e($class); ?>"
    loading="lazy"
    decoding="async"
    onerror="this.onerror=null;this.src='<?php echo e($fallback); ?>'"
>
<?php /**PATH C:\xampp\htdocs\Digital Dominators --- MarketLink\resources\views/components/product-media.blade.php ENDPATH**/ ?>