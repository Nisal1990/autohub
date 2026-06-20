<!-- Admin Login -->
<div class="auth-card" style="min-width:360px">
  <div class="text-center mb-4">
    <i class="bi bi-shield-fill-check display-4 text-warning mb-2"></i>
    <h2 class="fw-bold">Admin Panel</h2>
    <p class="text-muted small"><?= SITE_NAME ?></p>
  </div>
  <?php if (!empty($error)): ?><div class="alert alert-danger"><?= e($error) ?></div><?php endif; ?>
  <form method="POST" action="<?= url('admin/login') ?>">
    <?= csrfField() ?>
    <div class="mb-3"><label class="form-label fw-semibold">Email</label><input type="email" name="email" class="form-control form-control-lg" required autofocus></div>
    <div class="mb-4"><label class="form-label fw-semibold">Password</label><input type="password" name="password" class="form-control form-control-lg" required></div>
    <button type="submit" class="btn btn-warning btn-lg w-100 fw-bold">Sign In to Admin</button>
  </form>
  <p class="text-center mt-3 small"><a href="<?= url() ?>">← Back to site</a></p>
</div>
