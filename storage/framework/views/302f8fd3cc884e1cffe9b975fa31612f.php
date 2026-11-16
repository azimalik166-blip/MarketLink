<?php $__env->startSection('content'); ?>
<style>
html.theme-dark .dashboard-wrap .profile-email-input:disabled{
    background:#10251f !important;
    color:#e7f2ee !important;
    border-color:rgba(185,224,211,.16) !important;
    -webkit-text-fill-color:#e7f2ee !important;
    opacity:1 !important;
    box-shadow:none !important;
}
html.theme-dark .dashboard-wrap .profile-email-input:disabled::placeholder{
    color:#8fa9a0 !important;
}
</style>
<div class="dashboard-wrap"><div class="container"><div class="dashboard-hero mb-4"><div><span class="eyebrow">Account</span><h1>My profile</h1><p>Keep your contact and pickup details up to date.</p></div></div><div class="row g-4"><div class="col-lg-8"><div class="checkout-card"><form method="POST" action="<?php echo e(route('customer.profile.update')); ?>"><?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?><div class="row g-3"><div class="col-md-6"><label>Name</label><input name="name" class="form-control" value="<?php echo e(old('name',$user->name)); ?>" required></div><div class="col-md-6"><label>Email</label><input class="form-control profile-email-input" value="<?php echo e($user->email); ?>" disabled></div><div class="col-md-6"><label>Phone</label><input name="phone" class="form-control" value="<?php echo e(old('phone',$user->phone)); ?>"></div><div class="col-md-6"><label>Default address</label><input name="address" class="form-control" value="<?php echo e(old('address',$user->address)); ?>"></div><div class="col-12"><hr><span class="eyebrow">Security</span></div><div class="col-md-6"><label>New password</label><input name="password" type="password" class="form-control" minlength="8"></div><div class="col-md-6"><label>Confirm password</label><input name="password_confirmation" type="password" class="form-control" minlength="8"></div></div><button class="btn btn-success rounded-pill px-4 mt-4">Save changes</button></form></div></div><div class="col-lg-4"><div class="feature-card"><span class="eyebrow">MarketLink tip</span><h4 class="mt-2">Use your notes</h4><p>Tell farmers about preferred pickup timing or special collection instructions during checkout.</p></div></div></div></div></div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Digital Dominators --- MarketLink\resources\views/customer/profile.blade.php ENDPATH**/ ?>