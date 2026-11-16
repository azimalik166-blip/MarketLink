<?php $__env->startSection('content'); ?>
<div class="auth-wrap auth-surface">
    <div class="auth-card auth-card-modern">
        <div class="auth-brand">
            <span class="auth-icon"><i class="bi bi-basket2-fill"></i></span>
            <span class="eyebrow">Welcome back</span>
            <h1>Sign in to MarketLink</h1>
            <p>Manage your orders, favorites and local-market pickups.</p>
        </div>

        <?php if(session('success')): ?><div class="alert alert-success rounded-4"><i class="bi bi-check-circle me-1"></i><?php echo e(session('success')); ?></div><?php endif; ?>
        <?php if($errors->any()): ?><div class="alert alert-danger rounded-4"><?php echo e($errors->first()); ?></div><?php endif; ?>

        <form method="POST" action="<?php echo e(route('login')); ?>" class="auth-form">
            <?php echo csrf_field(); ?>
            <div class="mb-3">
                <label for="email">Email address</label>
                <div class="auth-input"><i class="bi bi-envelope"></i><input id="email" class="form-control" type="email" name="email" value="<?php echo e(old('email')); ?>" placeholder="you@example.com" autocomplete="email" required autofocus></div>
            </div>
            <div class="mb-2">
                <label for="password">Password</label>
                <div class="auth-input"><i class="bi bi-lock"></i><input id="password" class="form-control" type="password" name="password" placeholder="Enter your password" autocomplete="current-password" required></div>
            </div>
            <a href="<?php echo e(route('password.request')); ?>" class="auth-forgot">Forgot your password?</a>
            <button class="btn btn-success w-100 rounded-pill py-3 mt-3" type="submit"><i class="bi bi-box-arrow-in-right me-1"></i>Sign in</button>
        </form>

        <div class="auth-divider"><span>New to MarketLink?</span></div>
        <a href="<?php echo e(route('register')); ?>" class="btn btn-outline-dark w-100 rounded-pill py-2">Create an account</a>
        <p class="auth-note">Farmers can create a stall account and wait for admin approval.</p>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Digital Dominators --- MarketLink\resources\views/auth/login.blade.php ENDPATH**/ ?>