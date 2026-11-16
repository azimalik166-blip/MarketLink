<?php $__env->startSection('content'); ?>

<?php
$products = collect($products ?? []);
$markets = collect($markets ?? []);
$farmers = collect($farmers ?? []);
$announcements = collect($announcements ?? []);
$q = $q ?? '';

$heroProduct = $products->first();

$categoryMeta = [
    'Fruits' => [
        'tag' => 'Fresh & seasonal',
        'image' => 'https://images.unsplash.com/photo-1619566636858-adf3ef46400b?auto=format&fit=crop&w=900&q=85',
        'alt' => 'Fresh assorted fruits',
    ],
    'Vegetables' => [
        'tag' => 'Farm fresh',
        'image' => 'https://images.unsplash.com/photo-1540420773420-3366772f4999?auto=format&fit=crop&w=900&q=85',
        'alt' => 'Fresh market vegetables',
    ],
    'Dairy' => [
        'tag' => 'Pure & natural',
        'image' => 'https://images.unsplash.com/photo-1550583724-b2692b85b150?auto=format&fit=crop&w=900&q=85',
        'alt' => 'Fresh milk and dairy products',
    ],
    'Baked Goods' => [
        'tag' => 'Freshly baked',
        'image' => 'https://images.unsplash.com/photo-1509440159596-0249088772ff?auto=format&fit=crop&w=900&q=85',
        'alt' => 'Freshly baked bread and bakery products',
    ],
    'Herbs' => [
        'tag' => 'Natural goodness',
        'image' => 'https://images.unsplash.com/photo-1515586000433-45406d8e6662?auto=format&fit=crop&w=900&q=85',
        'alt' => 'Fresh herbs and greens',
    ],
    'Organic Pantry' => [
        'tag' => 'Everyday staples',
        'image' => 'https://images.unsplash.com/photo-1596040033229-a9821ebd058d?auto=format&fit=crop&w=900&q=85',
        'alt' => 'Organic pantry spices and staples',
    ],
];

$categories = \App\Models\Category::query()
    ->whereIn('name', array_keys($categoryMeta))
    ->orderByRaw("FIELD(name, 'Fruits', 'Vegetables', 'Dairy', 'Baked Goods', 'Herbs', 'Organic Pantry')")
    ->get();

$productImage = static function ($product) {
    if (!empty($product->image)) {
        $stored = ltrim((string)$product->image, '/');
        if (preg_match('/^https?:\\/\\//i', $stored)) {
            return $stored;
        }
        if (str_starts_with($stored, 'images/')) {
            return asset($stored);
        }
        return asset('storage/' . $stored);
    }

    $name = strtolower(trim((string)($product->name ?? '')));
    $category = strtolower(trim((string)($product->category?->name ?? '')));
    $map = [
        'fresh tomatoes' => 'https://images.unsplash.com/photo-1546094096-0df4bcaaa337?auto=format&fit=crop&w=960&q=85',
        'crisp cucumbers' => 'https://images.unsplash.com/photo-1604977042946-1eecc30f269e?auto=format&fit=crop&w=960&q=85',
        'seasonal mangoes' => 'https://images.unsplash.com/photo-1553279768-865429fa0078?auto=format&fit=crop&w=960&q=85',
        'farm eggs' => 'https://images.unsplash.com/photo-1582722872445-44dc5f7e3c8f?auto=format&fit=crop&w=960&q=85',
        'sourdough loaf' => 'https://images.unsplash.com/photo-1509440159596-0249088772ff?auto=format&fit=crop&w=960&q=85',
        'fresh coriander' => 'https://images.unsplash.com/photo-1515586000433-45406d8e6662?auto=format&fit=crop&w=960&q=85',
        'fresh spinach' => 'https://images.unsplash.com/photo-1576045057995-568f588f82fb?auto=format&fit=crop&w=960&q=85',
        'brown rice' => 'https://images.unsplash.com/photo-1586201375761-83865001e31c?auto=format&fit=crop&w=960&q=85',
        'carrots' => 'https://images.unsplash.com/photo-1445282768818-728615cc910a?auto=format&fit=crop&w=960&q=85',
    ];
    $fallbacks = [
        'fruits' => $map['seasonal mangoes'],
        'vegetables' => $map['fresh tomatoes'],
        'dairy' => $map['farm eggs'],
        'baked goods' => $map['sourdough loaf'],
        'herbs' => $map['fresh coriander'],
        'organic pantry' => $map['brown rice'],
        'grains' => $map['brown rice'],
    ];
    return $map[$name] ?? ($fallbacks[$category] ?? asset('images/marketlink-hero.jpg'));
};
?>

<style>
.marketlink-home .category-photo-strip{display:grid;grid-template-columns:repeat(6,minmax(0,1fr));gap:16px;overflow:visible}
.marketlink-home .category-photo-card{display:flex;flex-direction:column;align-items:center;text-align:center;padding:14px 12px 16px;min-width:0}
.marketlink-home .category-photo-wrap{display:block;width:100%;height:118px;border-radius:18px;overflow:hidden;background:#edf5f1;margin-bottom:12px}
.marketlink-home .category-photo-wrap img{display:block;width:100%;height:100%;object-fit:cover}
.marketlink-home .category-photo-card strong{font-size:15px;line-height:1.25}
.marketlink-home .category-photo-card small{margin-top:5px}
.marketlink-home .premium-announcement{margin-top:8px;padding:34px 0 10px}
.marketlink-home .announcement-shell{border:1px solid rgba(11,103,88,.15);border-radius:24px;background:linear-gradient(135deg,#f4fbf7 0%,#ffffff 72%);padding:24px;box-shadow:0 16px 40px rgba(10,67,55,.08)}
.marketlink-home .announcement-head{display:flex;justify-content:space-between;gap:18px;align-items:center;margin-bottom:18px}
.marketlink-home .announcement-kicker{display:flex;align-items:center;gap:10px;text-transform:uppercase;letter-spacing:.12em;font-size:11px;font-weight:800;color:#087e6e}
.marketlink-home .announcement-kicker i{width:36px;height:36px;display:grid;place-items:center;border-radius:12px;background:#075748;color:#fff;font-size:17px}
.marketlink-home .announcement-head h3{margin:8px 0 0;font-size:22px}
.marketlink-home .announcement-live{display:inline-flex;align-items:center;gap:7px;border-radius:999px;padding:8px 12px;background:#e8f7f0;color:#087e6e;font-size:11px;font-weight:800;white-space:nowrap}
.marketlink-home .announcement-live:before{content:'';width:7px;height:7px;border-radius:50%;background:#12a67f}
.marketlink-home .announcement-list{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:14px}
.marketlink-home .announcement-item{display:flex;align-items:center;justify-content:space-between;gap:16px;padding:18px 18px;border:1px solid rgba(11,103,88,.12);border-radius:18px;background:#fff}
.marketlink-home .announcement-item-main{min-width:0}
.marketlink-home .announcement-item-title{font-weight:800;font-size:15px;margin-bottom:5px}
.marketlink-home .announcement-item-body{font-size:13px;line-height:1.55;color:#5c6f6b}
.marketlink-home .announcement-item-icon{flex:0 0 38px;width:38px;height:38px;border-radius:12px;background:#eff9f5;color:#087e6e;display:grid;place-items:center;font-size:16px}
.marketlink-home .announcement-cta{display:flex;justify-content:flex-end;margin-top:16px}
.marketlink-home .announcement-cta a{display:inline-flex;align-items:center;gap:8px;border-radius:999px;padding:10px 16px;background:#064f43;color:#fff;text-decoration:none;font-size:12px;font-weight:800}
@media (max-width:991.98px){.marketlink-home .category-photo-strip{grid-template-columns:repeat(3,minmax(0,1fr))}.marketlink-home .announcement-list{grid-template-columns:1fr}}
@media (max-width:575.98px){.marketlink-home .category-photo-strip{grid-template-columns:repeat(2,minmax(0,1fr));gap:10px}.marketlink-home .category-photo-wrap{height:105px}.marketlink-home .announcement-shell{padding:18px}.marketlink-home .announcement-head{align-items:flex-start;flex-direction:column}.marketlink-home .announcement-item{align-items:flex-start}}

/* MarketLink community section polish — visual-only change */
.marketlink-home .section:has(.market-card){
    padding-top:42px;
    padding-bottom:34px;
}
.marketlink-home .section:has(.market-card) > .container{
    position:relative;
}
.marketlink-home .section:has(.market-card) .section-head{
    margin-bottom:22px;
}
.marketlink-home .section:has(.market-card) .section-head h2{
    margin-top:6px;
    font-size:clamp(28px,3vw,38px);
    letter-spacing:-.035em;
}
.marketlink-home .market-card{
    position:relative;
    overflow:hidden;
    min-height:168px;
    padding:24px 25px 22px;
    border:1px solid rgba(6,79,67,.13);
    border-radius:22px;
    background:linear-gradient(145deg,#ffffff 0%,#f8fcfa 100%);
    box-shadow:0 12px 32px rgba(7,75,63,.055);
    transition:transform .22s ease,box-shadow .22s ease,border-color .22s ease;
}
.marketlink-home .market-card:before{
    content:"";
    position:absolute;
    top:0;
    left:0;
    width:58px;
    height:4px;
    border-radius:0 0 8px 0;
    background:#087e6e;
}
.marketlink-home .market-card:after{
    content:"";
    position:absolute;
    width:110px;
    height:110px;
    right:-48px;
    bottom:-55px;
    border-radius:50%;
    background:rgba(8,126,110,.045);
    pointer-events:none;
}
.marketlink-home .market-card:hover{
    transform:translateY(-3px);
    border-color:rgba(8,126,110,.25);
    box-shadow:0 18px 38px rgba(7,75,63,.09);
}
.marketlink-home .market-icon{
    width:46px;
    height:46px;
    display:grid;
    place-items:center;
    border-radius:15px;
    background:#e9f7f1;
    color:#075748;
    font-size:20px;
    box-shadow:inset 0 0 0 1px rgba(8,126,110,.07);
}
.marketlink-home .market-tag{
    padding:7px 11px;
    border:1px solid rgba(8,126,110,.13);
    border-radius:999px;
    background:#f2faf6;
    color:#087e6e;
    font-size:10px;
    font-weight:800;
    letter-spacing:.04em;
}
.marketlink-home .market-card h3{
    margin:19px 0 6px;
    font-size:18px;
    letter-spacing:-.015em;
}
.marketlink-home .market-card p{
    margin:0 0 14px;
    color:#61736f;
    font-size:12px;
    line-height:1.5;
}
.marketlink-home .market-card small{
    display:inline-flex;
    align-items:center;
    padding:7px 10px;
    border-radius:10px;
    background:#f1f7f4;
    color:#56716a;
    font-size:10px;
    font-weight:700;
}
.marketlink-home .farmers-head{
    margin-top:50px;
    margin-bottom:18px;
}
.marketlink-home .farmer-card{
    position:relative;
    min-height:74px;
    display:flex;
    align-items:center;
    gap:14px;
    padding:13px 16px;
    border:1px solid rgba(6,79,67,.12);
    border-radius:18px;
    background:#fff;
    color:inherit;
    text-decoration:none;
    box-shadow:0 8px 24px rgba(7,75,63,.045);
    transition:transform .2s ease,box-shadow .2s ease,border-color .2s ease;
}
.marketlink-home .farmer-card:hover{
    transform:translateY(-2px);
    border-color:rgba(8,126,110,.24);
    box-shadow:0 13px 28px rgba(7,75,63,.08);
}
.marketlink-home .farmer-avatar{
    width:44px;
    height:44px;
    flex:0 0 44px;
    display:grid;
    place-items:center;
    border-radius:13px;
    background:#fff6d9;
    color:#087e6e;
    font-size:18px;
}
.marketlink-home .farmer-card strong{
    display:block;
    font-size:13px;
    line-height:1.3;
}
.marketlink-home .farmer-card small{
    display:block;
    margin-top:4px;
    color:#778783;
    font-size:10px;
}
.marketlink-home .farmer-card > i{
    color:#58756e;
    font-size:15px;
}
.marketlink-home .feature-row-section{
    padding-top:28px;
    padding-bottom:46px;
}
.marketlink-home .feature-row{
    display:grid;
    grid-template-columns:1.25fr repeat(3,1fr);
    gap:12px;
}
.marketlink-home .feature-row > div{
    min-height:104px;
    border:1px solid rgba(6,79,67,.11);
    border-radius:18px;
    background:#fff;
    box-shadow:0 8px 24px rgba(7,75,63,.035);
}
.marketlink-home .feature-row > div:first-child{
    padding:21px 20px;
    background:linear-gradient(145deg,#f4fbf7,#ffffff);
}
.marketlink-home .feature-row > div:first-child h3{
    margin:7px 0 0;
    max-width:220px;
    font-size:18px;
    line-height:1.2;
    letter-spacing:-.02em;
}
.marketlink-home .feature-item{
    display:flex;
    align-items:flex-start;
    gap:11px;
    padding:19px 16px;
}
.marketlink-home .feature-item > i{
    width:34px;
    height:34px;
    flex:0 0 34px;
    display:grid;
    place-items:center;
    border-radius:11px;
    background:#e9f7f1;
    color:#087e6e;
    font-size:15px;
}
.marketlink-home .feature-item strong{
    display:block;
    font-size:11px;
    line-height:1.35;
}
.marketlink-home .feature-item small{
    display:block;
    margin-top:5px;
    color:#71817e;
    font-size:9px;
    line-height:1.45;
}
.marketlink-home .premium-announcement{
    padding-top:10px;
}
.marketlink-home .announcement-shell{
    border-radius:24px;
    box-shadow:0 14px 34px rgba(7,75,63,.065);
}
@media (max-width:991.98px){
    .marketlink-home .feature-row{grid-template-columns:repeat(2,minmax(0,1fr))}
    .marketlink-home .feature-row > div:first-child{grid-column:1/-1}
}
@media (max-width:575.98px){
    .marketlink-home .section:has(.market-card){padding-top:30px}
    .marketlink-home .market-card{min-height:150px;padding:20px}
    .marketlink-home .farmers-head{margin-top:36px}
    .marketlink-home .feature-row{grid-template-columns:1fr}
    .marketlink-home .feature-row > div:first-child{grid-column:auto}
    .marketlink-home .feature-row > div{min-height:88px}
}


/* Dark-mode fix: Home page only. No HTML/logic/functionality changes. */
html.theme-dark .marketlink-home {
    color: #e7f2ee;
}

html.theme-dark .marketlink-home .home-hero,
html.theme-dark .marketlink-home .section {
    color: #e7f2ee;
}

html.theme-dark .marketlink-home .section-soft {
    background: #071a16;
}

html.theme-dark .marketlink-home .home-categories,
html.theme-dark .marketlink-home .feature-row-section,
html.theme-dark .marketlink-home .premium-announcement {
    background: transparent;
}

html.theme-dark .marketlink-home .category-card,
html.theme-dark .marketlink-home .product-card,
html.theme-dark .marketlink-home .market-card,
html.theme-dark .marketlink-home .farmer-card,
html.theme-dark .marketlink-home .feature-row > div,
html.theme-dark .marketlink-home .announcement-item {
    background: #10251f;
    border-color: rgba(185, 224, 211, .14);
    color: #e7f2ee;
    box-shadow: 0 12px 30px rgba(0,0,0,.18);
}

html.theme-dark .marketlink-home .category-photo-wrap {
    background: #17322b;
}

html.theme-dark .marketlink-home .category-photo-card strong,
html.theme-dark .marketlink-home .product-content h3 a,
html.theme-dark .marketlink-home .market-card h3,
html.theme-dark .marketlink-home .farmer-card strong,
html.theme-dark .marketlink-home .feature-row h3,
html.theme-dark .marketlink-home .feature-item strong,
html.theme-dark .marketlink-home .announcement-item-title,
html.theme-dark .marketlink-home .announcement-head h3 {
    color: #f1f8f5;
}

html.theme-dark .marketlink-home .category-photo-card small,
html.theme-dark .marketlink-home .product-meta,
html.theme-dark .marketlink-home .market-card p,
html.theme-dark .marketlink-home .market-card small,
html.theme-dark .marketlink-home .farmer-card small,
html.theme-dark .marketlink-home .feature-item small,
html.theme-dark .marketlink-home .announcement-item-body,
html.theme-dark .marketlink-home .section-copy {
    color: #9eb8af;
}

html.theme-dark .marketlink-home .text-link {
    color: #72d5bb;
}

html.theme-dark .marketlink-home .icon-button {
    background: #17352d;
    border-color: rgba(185, 224, 211, .16);
    color: #9be3ce;
}

html.theme-dark .marketlink-home .market-icon,
html.theme-dark .marketlink-home .feature-item > i,
html.theme-dark .marketlink-home .announcement-item-icon {
    background: #16362e;
    color: #78d6be;
}

html.theme-dark .marketlink-home .market-tag {
    background: #13342c;
    border-color: rgba(115, 211, 186, .2);
    color: #7edbc2;
}

html.theme-dark .marketlink-home .announcement-shell {
    background: linear-gradient(135deg, #102b24 0%, #0c1f1a 100%);
    border-color: rgba(157, 219, 202, .16);
    box-shadow: 0 16px 38px rgba(0,0,0,.2);
}

html.theme-dark .marketlink-home .announcement-item {
    background: #0f241f;
}

html.theme-dark .marketlink-home .announcement-live {
    background: #15382f;
    color: #7edbc2;
}

html.theme-dark .marketlink-home .announcement-kicker {
    color: #76d6bd;
}

html.theme-dark .marketlink-home .announcement-kicker i {
    background: #0d5b4d;
}

html.theme-dark .marketlink-home .feature-row > div:first-child {
    background: linear-gradient(145deg, #123027 0%, #10251f 100%);
}

html.theme-dark .marketlink-home .feature-item {
    background: #10251f;
}

html.theme-dark .marketlink-home .market-card small {
    background: #173029;
}

html.theme-dark .marketlink-home .hero-mini-item {
    background: #10251f;
    border-color: rgba(185, 224, 211, .12);
    color: #e7f2ee;
}

html.theme-dark .marketlink-home .hero-mini-item b,
html.theme-dark .marketlink-home .hero-mini-item small {
    color: #e7f2ee;
}

html.theme-dark .marketlink-home .hero-mini-item small {
    color: #96b1a8;
}

html.theme-dark .marketlink-home .hero-showcase,
html.theme-dark .marketlink-home .hero-search {
    border-color: rgba(185, 224, 211, .15);
}

html.theme-dark .marketlink-home .hero-search {
    background: #10251f;
}

html.theme-dark .marketlink-home .hero-search input,
html.theme-dark .marketlink-home .hero-search input::placeholder {
    color: #d7e8e2;
}

html.theme-dark .marketlink-home .hero-search input::placeholder {
    opacity: .72;
}

html.theme-dark .marketlink-home .marketplace-band {
    background: #063f35;
}

html.theme-dark .marketlink-home .marketplace-band .eyebrow,
html.theme-dark .marketlink-home .marketplace-band h2,
html.theme-dark .marketlink-home .marketplace-band p {
    color: #f1f8f5;
}

html.theme-dark .marketlink-home .marketplace-band .btn-light {
    background: #f0f7f4;
    color: #073d34;
    border-color: #f0f7f4;
}

html.theme-dark .marketlink-home .product-bottom strong {
    color: #f3fbf7;
}

html.theme-dark .marketlink-home .product-bottom span,
html.theme-dark .marketlink-home .hero-showcase-content small,
html.theme-dark .marketlink-home .hero-showcase-content p {
    color: #9eb8af;
}

html.theme-dark .marketlink-home .hero-showcase-content h3 {
    color: #f1f8f5;
}

html.theme-dark .marketlink-home .hero-points span,
html.theme-dark .marketlink-home .hero-badge {
    color: #c6ddd6;
}

html.theme-dark .marketlink-home .status-active {
    background: #14382f;
    color: #79d8bf;
}

html.theme-dark .marketlink-home .hero-showcase {
    background: #0d201b;
    box-shadow: 0 18px 42px rgba(0,0,0,.22);
}

html.theme-dark .marketlink-home .hero-showcase-top,
html.theme-dark .marketlink-home .hero-showcase-content,
html.theme-dark .marketlink-home .hero-mini-item {
    border-color: rgba(185, 224, 211, .12);
}

html.theme-dark .marketlink-home .premium-announcement,
html.theme-dark .marketlink-home .section-soft,
html.theme-dark .marketlink-home .section {
    border-color: rgba(185, 224, 211, .06);
}

html.theme-dark .marketlink-home .empty-state {
    background: #10251f;
    color: #a9c1b8;
    border-color: rgba(185,224,211,.14);
}

html.theme-dark .marketlink-home .announcement-cta a {
    background: #0b6a59;
    color: #fff;
}

html.theme-dark .marketlink-home .category-photo-card:hover,
html.theme-dark .marketlink-home .market-card:hover,
html.theme-dark .marketlink-home .farmer-card:hover,
html.theme-dark .marketlink-home .product-card:hover {
    border-color: rgba(126, 219, 194, .28);
}

.marketlink-home .home-hero-photo{isolation:isolate}
.marketlink-home .home-hero-slide{position:absolute;inset:0;opacity:0;visibility:hidden;transition:opacity .6s ease,visibility .6s ease}
.marketlink-home .home-hero-slide.is-active{opacity:1;visibility:visible}
.marketlink-home .home-hero-slide img{display:block;width:100%;height:100%;object-fit:cover}
.marketlink-home .hero-photo-caption{z-index:2;max-width:calc(100% - 36px);white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
.marketlink-home .home-hero-slider-dots{position:absolute;z-index:3;top:12px;right:12px;display:flex;gap:5px;padding:7px 9px;border-radius:999px;background:rgba(5,45,39,.58);backdrop-filter:blur(8px)}
.marketlink-home .home-hero-slider-dot{width:7px;height:7px;padding:0;border:0;border-radius:999px;background:rgba(255,255,255,.55);transition:width .2s ease,background-color .2s ease}
.marketlink-home .home-hero-slider-dot[aria-pressed="true"]{width:18px;background:#fff}
@media(prefers-reduced-motion:reduce){.marketlink-home .home-hero-slide,.marketlink-home .home-hero-slider-dot{transition:none}}

</style>

<div class="marketlink-home">
<section class="home-hero">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-xl-7">
                <div class="hero-badge"><i class="bi bi-stars"></i> Fresh local food · smarter pickup</div>
                <h1>Fresh products <span>directly from local farmers.</span></h1>
                <p class="hero-copy">Browse what is available this week, compare prices, save your favorites, and reserve a convenient market pickup slot.</p>
                <form class="hero-search" action="<?= e(route('products.index')) ?>" method="GET">
                    <i class="bi bi-search"></i>
                    <input name="q" value="<?= e($q) ?>" placeholder="Search tomatoes, eggs, mangoes..." aria-label="Search products">
                    <button type="submit">Explore</button>
                </form>
                <div class="hero-points">
                    <span><i class="bi bi-check2-circle"></i> Live stock</span>
                    <span><i class="bi bi-check2-circle"></i> Pickup slots</span>
                    <span><i class="bi bi-check2-circle"></i> Pay at market</span>
                </div>
            </div>

            <div class="col-xl-5">
                <div class="hero-showcase">
                    <div class="hero-showcase-top">
                        <span>THIS WEEK</span>
                        <span class="status status-active">Pickup ready</span>
                    </div>
                    <div class="hero-showcase-image home-hero-photo" <?= $products->count() ? 'data-home-hero-slider role="region" aria-roledescription="carousel" aria-label="Featured products"' : '' ?>>
                        <?php if ($products->count()): ?>
                            <div class="home-hero-slides">
                                <?php foreach ($products as $slideIndex => $slide): ?>
                                    <div class="home-hero-slide<?= $slideIndex === 0 ? ' is-active' : '' ?>" data-home-hero-slide data-category="<?= e($slide->category?->name ?? 'Market basket') ?>" data-name="<?= e($slide->name) ?>" data-farmer="<?= e($slide->farmer?->name ?? 'Local farmers') ?>" data-price="<?= e('Rs '.number_format($slide->price,2)) ?>" aria-hidden="<?= $slideIndex === 0 ? 'false' : 'true' ?>">
                                        <img src="<?= e($productImage($slide)) ?>" alt="<?= e($slide->name) ?>">
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <span class="hero-photo-caption"><i class="bi bi-patch-check-fill"></i><span data-home-hero-caption><?= e($heroProduct->name) ?></span></span>
                            <?php if ($products->count() > 1): ?>
                                <div class="home-hero-slider-dots" role="group" aria-label="Choose featured product">
                                    <?php foreach ($products as $slideIndex => $slide): ?>
                                        <button class="home-hero-slider-dot" type="button" data-home-hero-dot="<?= $slideIndex ?>" aria-label="Show <?= e($slide->name) ?>" aria-pressed="<?= $slideIndex === 0 ? 'true' : 'false' ?>"></button>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        <?php else: ?>
                            <img src="<?= e(asset('images/marketlink-hero.jpg')) ?>" alt="Fresh local produce from MarketLink farms">
                        <?php endif; ?>
                    </div>
                    <div class="hero-showcase-content">
                        <div>
                            <small data-home-hero-category><?= e($heroProduct?->category?->name ?? 'Market basket') ?></small>
                            <h3 data-home-hero-name><?= e($heroProduct?->name ?? 'Fresh local picks') ?></h3>
                            <p data-home-hero-farmer><?= e($heroProduct?->farmer?->name ?? 'Local farmers') ?></p>
                        </div>
                        <strong data-home-hero-price><?= $heroProduct ? 'Rs '.number_format($heroProduct->price,2) : 'Pay at pickup' ?></strong>
                    </div>
                    <div class="hero-mini-list">
                        <?php foreach ($products->take(3) as $p): ?>
                            <a href="<?= e(route('products.show',$p)) ?>" class="hero-mini-item">
                                <span class="hero-mini-icon"><img src="<?= e($productImage($p)) ?>" alt="<?= e($p->name) ?>" loading="lazy"></span>
                                <span><b><?= e($p->name) ?></b><small><?= e($p->stock_quantity) ?> <?= e($p->unit) ?> available</small></span>
                                <i class="bi bi-arrow-up-right"></i>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section home-categories">
    <div class="container">
        <div class="section-head">
            <div><span class="eyebrow">Shop by</span><h2>Popular categories</h2></div>
            <a href="<?= e(route('products.index')) ?>" class="text-link">View all <i class="bi bi-arrow-right"></i></a>
        </div>

        <div class="category-strip category-photo-strip">
            <?php if ($categories->count()): ?>
                <?php foreach ($categories as $category): $meta = $categoryMeta[$category->name] ?? null; if (!$meta) continue; ?>
                    <a class="category-card category-photo-card" href="<?= e(route('products.index',['category'=>$category->id])) ?>">
                        <span class="category-photo-wrap"><img src="<?= e($meta['image']) ?>" alt="<?= e($meta['alt']) ?>" loading="lazy"></span>
                        <strong><?= e($category->name) ?></strong>
                        <small><?= e($meta['tag']) ?></small>
                    </a>
                <?php endforeach; ?>
            <?php else: ?>
                <a class="category-card category-photo-card" href="<?= e(route('products.index')) ?>">
                    <span class="category-photo-wrap category-photo-fallback"><i class="bi bi-grid"></i></span>
                    <strong>All products</strong><small>Browse local stock</small>
                </a>
            <?php endif; ?>
        </div>
    </div>
</section>

<section class="section section-tight-top">
    <div class="container">
        <div class="section-head">
            <div><span class="eyebrow">Fresh this week</span><h2>Popular products</h2></div>
            <a href="<?= e(route('products.index')) ?>" class="text-link">Explore all <i class="bi bi-arrow-right"></i></a>
        </div>

        <div class="row g-4">
            <?php if ($products->count()): ?>
                <?php foreach ($products as $p): ?>
                    <div class="col-6 col-md-4 col-xl-3">
                        <article class="product-card h-100">
                            <a href="<?= e(route('products.show',$p)) ?>" class="product-visual">
                                <img src="<?= e($productImage($p)) ?>" alt="<?= e($p->name) ?>" class="product-media-image" loading="lazy" decoding="async">
                                <span class="product-badge"><i class="bi bi-box-seam me-1"></i><?= e($p->stock_quantity) ?> <?= e($p->unit) ?> left</span>
                            </a>
                            <div class="product-content">
                                <span class="product-meta"><?= e($p->category?->name) ?> · <?= e($p->market?->name ?? 'Local market') ?></span>
                                <h3><a href="<?= e(route('products.show',$p)) ?>"><?= e($p->name) ?></a></h3>
                                <div class="product-bottom">
                                    <div><strong>Rs <?= number_format($p->price,2) ?></strong><span>/ <?= e($p->unit) ?></span></div>
                                    <a class="icon-button" href="<?= e(route('products.show',$p)) ?>" aria-label="View <?= e($p->name) ?>"><i class="bi bi-arrow-up-right"></i></a>
                                </div>
                            </div>
                        </article>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12"><div class="empty-state">No products found yet.</div></div>
            <?php endif; ?>
        </div>
    </div>
</section>

<section class="section marketplace-band">
    <div class="container">
        <div class="band-grid">
            <div>
                <span class="eyebrow"><i class="bi bi-heart-pulse-fill me-1"></i> Healthy food · stronger communities</span>
                <h2>Buy local. Plan your pickup. Support the farmers around you.</h2>
                <p>MarketLink keeps weekly availability, market locations and pickup reservations together in one place.</p>
            </div>
            <a href="<?= e(route('products.index')) ?>" class="btn btn-light rounded-pill px-4">Support local farmers <i class="bi bi-arrow-up-right ms-1"></i></a>
        </div>
    </div>
</section>

<section class="section section-soft">
    <div class="container">
        <div class="row g-5 align-items-center">
            <div class="col-lg-5">
                <span class="eyebrow">Find your market</span>
                <h2>See pickup points on the map.</h2>
                <p class="section-copy">Explore active markets, compare pickup hours and choose a route that works for you.</p>
                <div class="d-flex flex-wrap gap-2 mt-4">
                    <a href="<?= e(route('markets.index')) ?>" class="btn btn-dark rounded-pill px-4">Explore markets</a>
                    <?php if (auth()->check() && auth()->user()->role === 'customer' && \Route::has('customer.markets')): ?>
                        <a href="<?= e(route('customer.markets')) ?>" class="btn btn-outline-dark rounded-pill px-4">Save a market</a>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-lg-7"><div id="homeMap" class="map-box"></div></div>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="section-head">
            <div><span class="eyebrow">Community</span><h2>Markets & farmers</h2></div>
            <a href="<?= e(route('markets.index')) ?>" class="text-link">See all markets <i class="bi bi-arrow-right"></i></a>
        </div>
        <div class="row g-4">
            <?php foreach ($markets as $m): ?>
                <div class="col-md-6 col-xl-6">
                    <article class="market-card h-100">
                        <div class="d-flex justify-content-between align-items-start">
                            <span class="market-icon"><i class="bi bi-shop"></i></span>
                            <span class="market-tag"><?= e($m->days ?: 'Weekly') ?></span>
                        </div>
                        <h3><?= e($m->name) ?></h3>
                        <p><?= e($m->address) ?></p>
                        <small><i class="bi bi-clock me-1"></i><?= e($m->hours ?: 'Hours not listed') ?></small>
                    </article>
                </div>
            <?php endforeach; ?>
        </div>

        <?php if ($farmers->count()): ?>
            <div class="section-head farmers-head">
                <div><span class="eyebrow">Local growers</span><h2>Meet the farmers</h2></div>
            </div>
            <div class="row g-4">
                <?php foreach ($farmers->take(4) as $farmer): ?>
                    <div class="col-md-6 col-xl-6">
                        <a href="<?= e(route('farmers.show',$farmer)) ?>" class="farmer-card">
                            <span class="farmer-avatar"><i class="bi bi-person-badge"></i></span>
                            <div><strong><?= e($farmer->farmerProfile?->stall_name ?? $farmer->name) ?></strong><small><?= e($farmer->farmerProfile?->operating_days ?? 'Market days') ?></small></div>
                            <i class="bi bi-arrow-up-right ms-auto"></i>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<section class="section feature-row-section">
    <div class="container">
        <div class="feature-row">
            <div><span class="eyebrow">Built around pickup</span><h3>Simple for customers. Useful for farmers.</h3></div>
            <div class="feature-item"><i class="bi bi-shield-check"></i><div><strong>100% pickup focused</strong><small>No delivery logistics, just clear pickup details.</small></div></div>
            <div class="feature-item"><i class="bi bi-cash-coin"></i><div><strong>Fair price discovery</strong><small>See stock and pricing before market day.</small></div></div>
            <div class="feature-item"><i class="bi bi-people"></i><div><strong>Support local</strong><small>Connect shoppers with community farmers.</small></div></div>
        </div>
    </div>
</section>

<?php if ($announcements->count()): ?>
<section class="premium-announcement">
    <div class="container">
        <div class="announcement-shell">
            <div class="announcement-head">
                <div>
                    <div class="announcement-kicker"><i class="bi bi-megaphone-fill"></i> MarketLink updates</div>
                    <h3>Fresh news from your local market</h3>
                </div>
                <span class="announcement-live">LIVE UPDATES</span>
            </div>
            <div class="announcement-list">
                <?php foreach ($announcements as $a): ?>
                    <article class="announcement-item">
                        <div class="announcement-item-main">
                            <div class="announcement-item-title"><?= e($a->title) ?></div>
                            <div class="announcement-item-body"><?= e($a->body) ?></div>
                        </div>
                        <span class="announcement-item-icon"><i class="bi bi-arrow-up-right"></i></span>
                    </article>
                <?php endforeach; ?>
            </div>
            <div class="announcement-cta">
                <a href="<?= e(route('products.index')) ?>">Browse fresh stock <i class="bi bi-arrow-right"></i></a>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

</div>
<script>
document.addEventListener('DOMContentLoaded', function(){
    if (window.ML && typeof ML.homeMap === 'function') {
        ML.homeMap(<?= json_encode($markets->values()) ?>);
    }

    const slider = document.querySelector('[data-home-hero-slider]');
    if (!slider) return;

    const slides = Array.from(slider.querySelectorAll('[data-home-hero-slide]'));
    if (slides.length < 2) return;

    const showcase = slider.closest('.hero-showcase');
    const dots = Array.from(slider.querySelectorAll('[data-home-hero-dot]'));
    const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    let activeIndex = 0;
    let timer = null;

    const showSlide = function(index) {
        activeIndex = (index + slides.length) % slides.length;
        const activeSlide = slides[activeIndex];

        slides.forEach((slide, slideIndex) => {
            const isActive = slideIndex === activeIndex;
            slide.classList.toggle('is-active', isActive);
            slide.setAttribute('aria-hidden', isActive ? 'false' : 'true');
        });
        dots.forEach((dot, dotIndex) => dot.setAttribute('aria-pressed', dotIndex === activeIndex ? 'true' : 'false'));

        showcase.querySelector('[data-home-hero-caption]').textContent = activeSlide.dataset.name;
        showcase.querySelector('[data-home-hero-category]').textContent = activeSlide.dataset.category;
        showcase.querySelector('[data-home-hero-name]').textContent = activeSlide.dataset.name;
        showcase.querySelector('[data-home-hero-farmer]').textContent = activeSlide.dataset.farmer;
        showcase.querySelector('[data-home-hero-price]').textContent = activeSlide.dataset.price;
    };

    const stopAutoplay = function() {
        window.clearInterval(timer);
        timer = null;
    };
    const startAutoplay = function() {
        if (!reducedMotion && !timer) timer = window.setInterval(() => showSlide(activeIndex + 1), 2000);
    };

    dots.forEach((dot) => dot.addEventListener('click', () => showSlide(Number(dot.dataset.homeHeroDot))));
    slider.addEventListener('mouseenter', stopAutoplay);
    slider.addEventListener('mouseleave', startAutoplay);
    slider.addEventListener('focusin', stopAutoplay);
    slider.addEventListener('focusout', (event) => {
        if (!slider.contains(event.relatedTarget)) startAutoplay();
    });
    document.addEventListener('visibilitychange', () => document.hidden ? stopAutoplay() : startAutoplay());
    startAutoplay();
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Digital Dominators --- MarketLink\resources\views/home.blade.php ENDPATH**/ ?>