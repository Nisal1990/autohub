<div class="mb-4">
  <h2 class="h4 fw-bold">My Profile</h2>
  <p class="text-muted">Update your personal information and password.</p>
</div>

<?php if (!empty($errors)): ?>
  <div class="alert alert-danger"><?php foreach ($errors as $e): ?><div><?= e($e) ?></div><?php endforeach; ?></div>
<?php endif; ?>

<div class="row g-4">
  <div class="col-lg-7">
    <div class="dash-card">
      <h5 class="dash-card-title"><i class="bi bi-person-circle me-2"></i>Personal Information</h5>
      <form method="POST" action="<?= url('dashboard/profile') ?>">
        <?= csrfField() ?>
        <div class="mb-3">
          <label class="form-label fw-semibold">Full Name *</label>
          <input type="text" name="name" class="form-control" value="<?= e($user['name']) ?>" required>
        </div>
        <div class="mb-3">
          <label class="form-label fw-semibold">Email</label>
          <input type="email" class="form-control" value="<?= e($user['email']) ?>" disabled>
          <div class="form-text">Email cannot be changed.</div>
        </div>
        <div class="mb-3">
          <label class="form-label fw-semibold">Phone</label>
          <input type="tel" name="phone" class="form-control" placeholder="0771234567" value="<?= e($user['phone']) ?>">
        </div>
        <div class="row g-3 mb-3">
          <div class="col-6">
            <label class="form-label fw-semibold">District</label>
            <select name="district" class="form-select">
              <option value="">Select District</option>
              <?php foreach ($districts as $d): ?>
                <option value="<?= e($d['name']) ?>" <?= selectedIf($user['district'],$d['name']) ?>><?= e($d['name']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="col-6">
            <label class="form-label fw-semibold">City/Town</label>
            <input type="text" name="city" class="form-control" value="<?= e($user['city']) ?>">
          </div>
        </div>
        <hr>
        <h6 class="fw-bold mb-3">Change Password <span class="text-muted fw-normal small">(leave blank to keep current)</span></h6>
        <div class="mb-3">
          <label class="form-label">New Password</label>
          <input type="password" name="new_password" class="form-control" minlength="8" autocomplete="new-password">
        </div>
        <div class="mb-4">
          <label class="form-label">Confirm New Password</label>
          <input type="password" name="confirm_password" class="form-control" autocomplete="new-password">
        </div>
        <button type="submit" class="btn btn-primary px-4"><i class="bi bi-check-lg me-1"></i>Save Changes</button>
      </form>
    </div>
  </div>
  <div class="col-lg-5">
    <div class="dash-card text-center">
      <div class="profile-avatar mb-3"><i class="bi bi-person-circle display-1 text-primary"></i></div>
      <h5 class="fw-bold"><?= e($user['name']) ?></h5>
      <p class="text-muted"><?= e($user['email']) ?></p>
      <p class="badge bg-success-subtle text-success">Active Account</p>
      <hr>
      <p class="text-muted small">Member since <?= formatDate($user['created_at']) ?></p>
      <a href="<?= url('dashboard/vehicles/create') ?>" class="btn btn-warning w-100 mt-2"><i class="bi bi-plus-circle me-1"></i>Post New Listing</a>
    </div>
  </div>
</div>
