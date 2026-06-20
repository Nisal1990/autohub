<section class="py-5 bg-light min-vh-100 d-flex align-items-center">
  <div class="container"><div class="row justify-content-center"><div class="col-md-5">
    <div class="auth-card text-center">
      <div class="mb-4"><i class="bi bi-lock-fill display-4 text-primary"></i></div>
      <h1 class="h3 fw-bold mb-2">Forgot Password?</h1>
      <p class="text-muted mb-4">Enter your registered email and we'll send reset instructions.</p>
      <form method="POST" action="<?= url('forgot-password') ?>">
        <?= csrfField() ?>
        <div class="mb-4 text-start">
          <label class="form-label fw-semibold">Email Address</label>
          <input type="email" name="email" class="form-control form-control-lg" required autofocus>
        </div>
        <button type="submit" class="btn btn-primary btn-lg w-100">Send Reset Link</button>
      </form>
      <p class="mt-4 text-muted small">Remembered it? <a href="<?= url('login') ?>">Back to Login</a></p>
      <div class="alert alert-info mt-3 small text-start"><i class="bi bi-info-circle me-1"></i>Email notifications are not active in v1. Please contact the admin directly at <a href="mailto:<?= ADMIN_EMAIL ?>"><?= ADMIN_EMAIL ?></a>.</div>
    </div>
  </div></div></div>
</section>
