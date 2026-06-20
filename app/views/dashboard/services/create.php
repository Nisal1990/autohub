<?php $editing = isset($provider) && $provider; ?>
<div class="mb-4">
  <h2 class="h4 fw-bold"><?= $editing ? 'Edit Business Profile' : 'Create Service Provider Profile' ?></h2>
  <p class="text-muted">Your profile will be reviewed before appearing publicly.</p>
</div>

<form method="POST" enctype="multipart/form-data"
      action="<?= url('dashboard/services/provider/edit') ?>">
  <?= csrfField() ?>
  <div class="row g-4">
    <div class="col-lg-8">
      <div class="dash-card">
        <h5 class="dash-card-title"><i class="bi bi-building me-2"></i>Business Details</h5>
        <div class="row g-3">
          <div class="col-12"><label class="form-label fw-semibold">Business Name *</label><input type="text" name="business_name" class="form-control" value="<?= e($editing?$provider['business_name']:($_POST['business_name']??'')) ?>" required></div>
          <div class="col-12"><label class="form-label fw-semibold">Address</label><input type="text" name="address" class="form-control" placeholder="Street address" value="<?= e($editing?$provider['address']:($_POST['address']??'')) ?>"></div>
          <div class="col-md-6">
            <label class="form-label fw-semibold">District *</label>
            <select name="district" class="form-select" required>
              <option value="">Select District</option>
              <?php foreach ($districts??[] as $d): ?><option value="<?= e($d['name']) ?>" <?= selectedIf($editing?$provider['district']:($_POST['district']??''),$d['name']) ?>><?= e($d['name']) ?></option><?php endforeach; ?>
            </select>
          </div>
          <div class="col-md-6"><label class="form-label fw-semibold">City</label><input type="text" name="city" class="form-control" value="<?= e($editing?$provider['city']:($_POST['city']??'')) ?>"></div>
          <div class="col-md-6"><label class="form-label fw-semibold">Contact Phone *</label><input type="tel" name="contact_phone" class="form-control" placeholder="0771234567" value="<?= e($editing?$provider['contact_phone']:($_POST['contact_phone']??'')) ?>" required></div>
          <div class="col-md-6"><label class="form-label fw-semibold">Working Hours</label><input type="text" name="working_hours" class="form-control" placeholder="e.g. Mon–Sat 8am–6pm" value="<?= e($editing?$provider['working_hours']:($_POST['working_hours']??'')) ?>"></div>
          <div class="col-12"><label class="form-label fw-semibold">Description</label><textarea name="description" class="form-control" rows="4" placeholder="Describe your business, specialties..."><?= e($editing?$provider['description']:($_POST['description']??'')) ?></textarea></div>
          <div class="col-12">
            <label class="form-label fw-semibold">Business Logo</label>
            <?php if ($editing && $provider['logo_path']): ?><div class="mb-2"><img src="<?= e(imageUrl($provider['logo_path'])) ?>" alt="" height="60" class="rounded border"></div><?php endif; ?>
            <input type="file" name="logo" class="form-control" accept="image/*">
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-4">
      <div class="dash-card">
        <h5 class="dash-card-title"><i class="bi bi-info-circle me-2"></i>Notes</h5>
        <ul class="small text-muted ps-3">
          <li>Your profile will appear in the Services directory once approved.</li>
          <li>You can add individual services after profile setup.</li>
          <li>Each service can have optional add-ons with prices.</li>
        </ul>
        <div class="d-grid gap-2 mt-4">
          <button type="submit" class="btn btn-primary btn-lg"><?= $editing?'Save Changes':'Create Profile' ?></button>
          <a href="<?= url('dashboard/services') ?>" class="btn btn-outline-secondary">Cancel</a>
        </div>
      </div>
    </div>
  </div>
</form>
