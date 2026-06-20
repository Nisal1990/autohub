<section class="py-5 bg-light min-vh-100 d-flex align-items-center">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-6 col-lg-5">
        <div class="auth-card">
          <div class="auth-brand text-center mb-4">
            <a href="<?= url() ?>" class="text-decoration-none">
              <span class="brand-auto fs-3">Auto</span><span class="brand-hub fs-3">Hub</span> <span class="brand-lk fs-3">LK</span>
            </a>
            <p class="text-muted mt-1">Create your free account</p>
          </div>

          <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
              <?php foreach ($errors as $err): ?><div><i class="bi bi-exclamation-circle me-1"></i><?= e($err) ?></div><?php endforeach; ?>
            </div>
          <?php endif; ?>

          <form method="POST" action="<?= url('register') ?>">
            <?= csrfField() ?>
            <div class="mb-3">
              <label for="name" class="form-label fw-semibold">Full Name *</label>
              <input type="text" id="name" name="name" class="form-control" value="<?= e($old['name']??'') ?>" required>
            </div>
            <div class="mb-3">
              <label for="email" class="form-label fw-semibold">Email Address *</label>
              <input type="email" id="email" name="email" class="form-control" value="<?= e($old['email']??'') ?>" required>
            </div>
            <div class="mb-3">
              <label for="phone" class="form-label fw-semibold">Phone Number</label>
              <input type="tel" id="phone" name="phone" class="form-control" placeholder="0771234567" value="<?= e($old['phone']??'') ?>">
              <div class="form-text">Sri Lankan format: 07XXXXXXXX or +94XXXXXXXXX</div>
            </div>
            <div class="row g-3 mb-3">
              <div class="col-6">
                <label for="district" class="form-label fw-semibold">District</label>
                <select id="district" name="district" class="form-select" id="regDistrict">
                  <option value="">Select District</option>
                  <?php foreach ($districts as $d): ?>
                    <option value="<?= e($d['name']) ?>" <?= selectedIf($old['district']??'',$d['name']) ?>><?= e($d['name']) ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="col-6">
                <label for="city" class="form-label fw-semibold">City/Town</label>
                <input type="text" id="city" name="city" class="form-control" placeholder="City" value="<?= e($old['city']??'') ?>">
              </div>
            </div>
            <div class="mb-3">
              <label for="password" class="form-label fw-semibold">Password *</label>
              <div class="input-group">
                <input type="password" id="password" name="password" class="form-control" required minlength="8">
                <button type="button" class="btn btn-outline-secondary" onclick="togglePw('password')"><i class="bi bi-eye"></i></button>
              </div>
              <div class="form-text">Minimum 8 characters</div>
            </div>
            <div class="mb-4">
              <label for="password_confirm" class="form-label fw-semibold">Confirm Password *</label>
              <input type="password" id="password_confirm" name="password_confirm" class="form-control" required>
            </div>
            <div class="form-check mb-4">
              <input class="form-check-input" type="checkbox" id="terms" required>
              <label class="form-check-label" for="terms">I agree to the <a href="#">Terms of Use</a></label>
            </div>
            <button type="submit" class="btn btn-primary btn-lg w-100 fw-bold">Create Account</button>
          </form>

          <hr class="my-4">
          <p class="text-center text-muted mb-0">Already have an account? <a href="<?= url('login') ?>" class="fw-semibold text-primary">Sign In</a></p>
        </div>
      </div>
    </div>
  </div>
</section>
<script>
function togglePw(id){const f=document.getElementById(id);f.type=f.type==='password'?'text':'password';}
</script>
