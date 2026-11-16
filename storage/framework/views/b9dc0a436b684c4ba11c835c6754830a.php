<?php $__env->startSection('content'); ?>
<section class="page-head"><div class="container"><span class="eyebrow">About MarketLink</span><h1>Local markets, connected.</h1><p>MarketLink brings weekly farm stock, market discovery and pickup pre-orders into one responsive experience for customers and farmers.</p></div></section>
<section class="section"><div class="container"><div class="row g-4"><div class="col-md-4"><article class="feature-card h-100"><span class="feature-icon"><i class="bi bi-basket2"></i></span><h3>For customers</h3><p>Browse, filter, save favorites, compare products and reserve items before market day.</p></article></div><div class="col-md-4"><article class="feature-card h-100"><span class="feature-icon"><i class="bi bi-shop"></i></span><h3>For farmers</h3><p>Publish weekly stock, manage pickup orders, set slots and share accurate market details.</p></article></div><div class="col-md-4"><article class="feature-card h-100"><span class="feature-icon"><i class="bi bi-shield-check"></i></span><h3>For admins</h3><p>Approve farmers, manage markets, moderate content and review platform activity.</p></article></div></div></div></section>
<style>
.about-mission-premium{position:relative;overflow:hidden;border:1px solid rgba(11,109,95,.12);border-radius:30px;background:linear-gradient(135deg,#f4fbf8 0%,#ffffff 52%,#fffaf0 100%);box-shadow:0 24px 70px rgba(9,73,64,.10)}
.about-mission-premium:before,.about-mission-premium:after{content:"";position:absolute;border-radius:999px;pointer-events:none}
.about-mission-premium:before{width:240px;height:240px;right:-80px;top:-95px;background:rgba(245,183,42,.13)}
.about-mission-premium:after{width:190px;height:190px;left:-85px;bottom:-95px;background:rgba(7,143,123,.09)}
.about-mission-inner{position:relative;z-index:1;padding:48px}
.about-mission-kicker{display:inline-flex;align-items:center;gap:8px;padding:8px 12px;border-radius:999px;background:#e4f5ee;color:#087f6d;font-size:.76rem;font-weight:800;letter-spacing:.12em;text-transform:uppercase}
.about-mission-copy h2{font-size:clamp(2rem,4vw,3.15rem);line-height:1.02;max-width:640px;margin:18px 0 14px;color:#0a2f2a;letter-spacing:-.03em}
.about-mission-copy .section-copy{max-width:680px;font-size:1rem;line-height:1.75;color:#647a76}
.about-mission-points{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:14px;margin-top:28px}
.about-mission-point{display:flex;gap:12px;align-items:flex-start;padding:16px 18px;border-radius:18px;background:rgba(255,255,255,.78);border:1px solid rgba(11,109,95,.10)}
.about-mission-point>span{width:34px;height:34px;flex:0 0 34px;display:grid;place-items:center;border-radius:12px;background:#0a6f60;color:#fff;box-shadow:0 8px 18px rgba(10,111,96,.17)}
.about-mission-point strong{display:block;color:#113d36;font-size:.95rem;margin-bottom:4px}
.about-mission-point small{display:block;color:#71827f;line-height:1.45}
.about-mission-stats{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:14px;margin-top:34px}
.about-mission-stat{min-height:118px;padding:18px;border-radius:20px;background:rgba(255,255,255,.86);border:1px solid rgba(11,109,95,.10);display:flex;align-items:center;gap:13px;transition:transform .2s ease,box-shadow .2s ease}
.about-mission-stat:hover{transform:translateY(-3px);box-shadow:0 14px 28px rgba(9,73,64,.08)}
.about-mission-stat-icon{width:44px;height:44px;flex:0 0 44px;display:grid;place-items:center;border-radius:14px;background:linear-gradient(135deg,#0a7665,#0b8f7a);color:#fff;box-shadow:0 10px 20px rgba(11,116,101,.16)}
.about-mission-stat:nth-child(2) .about-mission-stat-icon{background:linear-gradient(135deg,#dfa61d,#f2bd36)}
.about-mission-stat strong{display:block;color:#0d3a34;font-size:1.05rem}
.about-mission-stat small{display:block;color:#72827f;margin-top:3px}
@media (max-width:991px){.about-mission-inner{padding:32px}.about-mission-stats{grid-template-columns:repeat(2,minmax(0,1fr))}}
@media (max-width:767px){.about-mission-inner{padding:24px}.about-mission-points{grid-template-columns:1fr}.about-mission-stats{grid-template-columns:1fr}.about-mission-copy h2{font-size:2rem}}

/* Dark mode fix: About/Mission section only. Existing content and functionality unchanged. */
html.theme-dark .about-mission-section{
    background:#071a16 !important;
}
html.theme-dark .about-mission-premium{
    background:linear-gradient(135deg,#102b24 0%,#0d211c 54%,#26261b 100%);
    border-color:rgba(157,219,202,.15);
    box-shadow:0 24px 70px rgba(0,0,0,.22);
}
html.theme-dark .about-mission-kicker{
    background:#153a31;
    color:#78d8bf;
}
html.theme-dark .about-mission-copy h2{
    color:#eef8f4;
}
html.theme-dark .about-mission-copy .section-copy{
    color:#a2bbb3;
}
html.theme-dark .about-mission-point{
    background:rgba(14,37,31,.92);
    border-color:rgba(157,219,202,.13);
}
html.theme-dark .about-mission-point>span{
    background:#0b7663;
    box-shadow:0 8px 18px rgba(0,0,0,.18);
}
html.theme-dark .about-mission-point strong{
    color:#e7f3ef;
}
html.theme-dark .about-mission-point small{
    color:#94aea5;
}
html.theme-dark .about-mission-stat{
    background:rgba(14,37,31,.94);
    border-color:rgba(157,219,202,.13);
}
html.theme-dark .about-mission-stat:hover{
    box-shadow:0 14px 28px rgba(0,0,0,.2);
}
html.theme-dark .about-mission-stat strong{
    color:#edf8f4;
}
html.theme-dark .about-mission-stat small{
    color:#94aea5;
}
html.theme-dark .about-mission-stat-icon{
    background:linear-gradient(135deg,#0a6f60,#0b8f7a);
}
html.theme-dark .about-mission-stat:nth-child(2) .about-mission-stat-icon{
    background:linear-gradient(135deg,#c28d12,#e2a928);
}

</style>

<section class="section section-soft about-mission-section">
    <div class="container">
        <div class="about-mission-premium">
            <div class="about-mission-inner">
                <div class="about-mission-copy">
                    <span class="about-mission-kicker"><i class="bi bi-compass"></i> Our mission</span>
                    <h2>Make local shopping easier to plan.</h2>
                    <p class="section-copy">Customers get clearer stock and pickup information. Farmers get a simple place to publish inventory and manage pre-orders.</p>
                    <div class="about-mission-points">
                        <div class="about-mission-point"><span><i class="bi bi-check2"></i></span><div><strong>Clear weekly stock</strong><small>Know what is available before market day.</small></div></div>
                        <div class="about-mission-point"><span><i class="bi bi-check2"></i></span><div><strong>Pickup-first workflow</strong><small>Plan your collection time with less guesswork.</small></div></div>
                    </div>
                </div>

                <div class="about-mission-stats">
                    <div class="about-mission-stat"><span class="about-mission-stat-icon"><i class="bi bi-box-seam"></i></span><div><strong>Weekly</strong><small>stock visibility</small></div></div>
                    <div class="about-mission-stat"><span class="about-mission-stat-icon"><i class="bi bi-calendar-check"></i></span><div><strong>Pickup</strong><small>first workflow</small></div></div>
                    <div class="about-mission-stat"><span class="about-mission-stat-icon"><i class="bi bi-shop"></i></span><div><strong>Local</strong><small>farmer discovery</small></div></div>
                    <div class="about-mission-stat"><span class="about-mission-stat-icon"><i class="bi bi-shield-check"></i></span><div><strong>Secure</strong><small>role-based access</small></div></div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\MarketLink\resources\views\about.blade.php ENDPATH**/ ?>