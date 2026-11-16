<?php $__env->startSection('content'); ?>
<div class="auth-wrap auth-surface">
    <div class="auth-card auth-card-modern">
        <div class="auth-brand">
            <span class="auth-icon"><i class="bi bi-shield-check"></i></span>
            <span class="eyebrow">Reset password</span>
            <h1>Set a new password</h1>
            <p>Your email is verified. Choose a new password with at least 8 characters.</p>
        </div>
        <?php if(session('success')): ?><div class="alert alert-success rounded-4"><i class="bi bi-check-circle me-1"></i><?php echo e(session('success')); ?></div><?php endif; ?>
        <?php if($errors->any()): ?><div class="alert alert-danger rounded-4"><?php echo e($errors->first()); ?></div><?php endif; ?>
        <div class="reset-email-note"><i class="bi bi-envelope-check"></i><span>Resetting password for <strong><?php echo e($email); ?></strong></span></div>
        <form method="POST" action="<?php echo e(route('password.update')); ?>" class="auth-form mt-3">
            <?php echo csrf_field(); ?>
            <label for="password">New password</label>
            <div class="auth-input mb-3"><i class="bi bi-lock"></i><input id="password" class="form-control" type="password" name="password" autocomplete="new-password" minlength="8" placeholder="At least 8 characters" required autofocus></div>
            <label for="password_confirmation">Confirm new password</label>
            <div class="auth-input mb-4"><i class="bi bi-lock-fill"></i><input id="password_confirmation" class="form-control" type="password" name="password_confirmation" autocomplete="new-password" minlength="8" placeholder="Repeat your password" required></div>
            <button class="btn btn-success w-100 rounded-pill py-3" type="submit"><i class="bi bi-check2-circle me-1"></i>Reset password</button>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\MarketLink\resources\views\auth\reset-password.blade.php ENDPATH**/ ?>