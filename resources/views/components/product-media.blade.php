@props(['product', 'class' => ''])

@php
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
@endphp

<img
    src="{{ $src }}"
    alt="{{ $product->name }}"
    class="product-media-image {{ $class }}"
    loading="lazy"
    decoding="async"
    onerror="this.onerror=null;this.src='{{ $fallback }}'"
>
