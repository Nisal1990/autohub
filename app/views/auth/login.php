<section class="py-5 bg-light min-vh-100 d-flex align-items-center">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-5">
        <div class="auth-card">
          <div class="auth-brand text-center mb-4">
            <a href="<?= url() ?>" class="text-decoration-none">
              <span class="brand-auto fs-3">Auto</span><span class="brand-hub fs-3">Hub</span> <span class="brand-lk fs-3">LK</span>
            </a>
            <p class="text-muted mt-1">Sign in to your account</p>
          </div>

          <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
              <?php foreach ($errors as $e): ?><div><i class="bi bi-exclamation-circle me-1"></i><?= e($e) ?></div><?php endforeach; ?>
            </div>
          <?php endif; ?>

          <form method="POST" action="<?= url('login') ?>">
            <?= csrfField() ?>
            <div class="mb-3">
              <label for="email" class="form-label fw-semibold">Email Address</label>
              <input type="email" id="email" name="email" class="form-control form-control-lg"
                     value="<?= e($old['email'] ?? '') ?>" required autofocus autocomplete="email">
            </div>
            <div class="mb-3">
              <label for="password" class="form-label fw-semibold">Password</label>
              <div class="input-group">
                <input type="password" id="password" name="password" class="form-control form-control-lg" required autocomplete="current-password">
                <button type="button" class="btn btn-outline-secondary" onclick="togglePw('password')"><i class="bi bi-eye"></i></button>
              </div>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-4">
              <div class="form-check"><input class="form-check-input" type="checkbox" id="remember"><label class="form-check-label" for="remember">Remember me</label></div>
              <a href="<?= url('forgot-password') ?>" class="small text-primary">Forgot password?</a>
            </div>
            <button type="submit" class="btn btn-primary btn-lg w-100 fw-bold">Sign In</button>
          </form>

          <hr class="my-4">
          <p class="text-center text-muted mb-0">Don't have an account? <a href="<?= url('register') ?>" class="fw-semibold text-primary">Register Free</a></p>
        </div>
      </div>
    </div>
  </div>
</section>
<script>
function togglePw(id){const f=document.getElementById(id);f.type=f.type==='password'?'text':'password';}
</script>
