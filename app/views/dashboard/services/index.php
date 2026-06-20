<div class="mb-4 d-flex justify-content-between align-items-start">
  <div>
    <h2 class="h4 fw-bold mb-0">My Services</h2>
    <p class="text-muted small">Manage your service provider profile and services.</p>
  </div>
  <a href="<?= url('dashboard/services/create') ?>" class="btn btn-primary"><i class="bi bi-plus-circle me-1"></i>Add Service</a>
</div>

<!-- Provider Profile Card -->
<?php if ($provider): ?>
  <div class="dash-card mb-4">
    <div class="d-flex justify-content-between align-items-start mb-3">
      <h5 class="dash-card-title mb-0"><i class="bi bi-building me-2"></i>Business Profile</h5>
      <span><?= statusBadge($provider['status']) ?></span>
    </div>
    <div class="row g-3">
      <div class="col-md-6"><strong><?= e($provider['business_name']) ?></strong><br><span class="text-muted small"><?= e($provider['address']) ?></span></div>
      <div class="col-md-3"><i class="bi bi-geo-alt text-primary me-1"></i><?= e($provider['district']) ?><?= $provider['city']?', '.e($provider['city']):'' ?></div>
      <div class="col-md-3"><i class="bi bi-telephone me-1"></i><?= e($provider['contact_phone']) ?></div>
      <?php if ($provider['working_hours']): ?><div class="col-12 text-muted small"><i class="bi bi-clock me-1"></i><?= e($provider['working_hours']) ?></div><?php endif; ?>
    </div>
    <div class="mt-3"><a href="<?= url('dashboard/services/provider/edit') ?>" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil me-1"></i>Edit Profile</a></div>
  </div>

  <!-- Services List -->
  <?php if (empty($serviceList)): ?>
    <div class="dash-card text-center py-4">
      <i class="bi bi-wrench-adjustable display-4 text-muted"></i>
      <p class="mt-3">No services added yet.</p>
      <a href="<?= url('dashboard/services/create') ?>" class="btn btn-primary">Add Your First Service</a>
    </div>
  <?php else: ?>
    <div class="row g-3">
      <?php foreach ($serviceList as $svc): ?>
        <div class="col-md-6">
          <div class="dash-card service-manage-card h-100">
            <div class="d-flex justify-content-between align-items-start mb-2">
              <div>
                <span class="badge bg-primary-subtle text-primary small mb-1"><?= e($svc['category_name']) ?></span>
                <h6 class="fw-bold mb-0"><?= e($svc['name']) ?></h6>
              </div>
              <div class="d-flex align-items-center gap-2">
                <?= statusBadge($svc['status']) ?>
                <strong class="text-primary"><?= formatPrice($svc['base_price']) ?></strong>
              </div>
            </div>
            <?php if ($svc['description']): ?><p class="text-muted small mb-2"><?= e(truncate($svc['description'],80)) ?></p><?php endif; ?>

            <!-- Add-ons -->
            <?php if (!empty($svc['addons'])): ?>
              <div class="addon-mini-list mb-2">
                <?php foreach ($svc['addons'] as $a): ?>
                  <div class="d-flex justify-content-between align-items-center addon-mini-item">
                    <span class="text-muted small"><i class="bi bi-plus me-1"></i><?= e($a['addon_name']) ?></span>
                    <div class="d-flex align-items-center gap-2">
                      <span class="text-muted small">+ <?= formatPrice($a['addon_price']) ?></span>
                      <form method="POST" action="<?= url('dashboard/addons/'.$a['id'].'/delete') ?>" class="d-inline" onsubmit="return confirm('Remove addon?')"><?= csrfField() ?><button class="btn btn-link btn-sm p-0 text-danger"><i class="bi bi-x"></i></button></form>
                    </div>
                  </div>
                <?php endforeach; ?>
              </div>
            <?php endif; ?>

            <!-- Add Addon Form -->
            <details class="mt-2">
              <summary class="text-primary small cursor-pointer"><i class="bi bi-plus-circle me-1"></i>Add Add-on</summary>
              <form method="POST" action="<?= url('dashboard/services/'.$svc['id'].'/addon') ?>" class="mt-2">
                <?= csrfField() ?>
                <div class="row g-2">
                  <div class="col-7"><input type="text" name="addon_name" class="form-control form-control-sm" placeholder="Add-on name" required></div>
                  <div class="col-3"><input type="number" name="addon_price" class="form-control form-control-sm" placeholder="Rs." min="0" required></div>
                  <div class="col-2"><button type="submit" class="btn btn-sm btn-primary w-100"><i class="bi bi-plus"></i></button></div>
                </div>
              </form>
            </details>

            <div class="d-flex gap-2 mt-3">
              <a href="<?= url('dashboard/services/'.$svc['id'].'/edit') ?>" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil me-1"></i>Edit</a>
              <form method="POST" action="<?= url('dashboard/services/'.$svc['id'].'/delete') ?>" class="d-inline" onsubmit="return confirm('Delete this service?')"><?= csrfField() ?><button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash me-1"></i>Delete</button></form>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>

<?php else: ?>
  <!-- No provider yet -->
  <div class="dash-card text-center py-5">
    <i class="bi bi-building-add display-1 text-muted"></i>
    <h3 class="mt-3">Set Up Your Business Profile</h3>
    <p class="text-muted">Create a service provider profile to start listing your services.</p>
    <a href="<?= url('dashboard/services/provider/edit') ?>" class="btn btn-primary mt-2"><i class="bi bi-plus-circle me-1"></i>Create Business Profile</a>
  </div>
<?php endif; ?>
