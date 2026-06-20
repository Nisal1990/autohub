<div class="container py-5">
  <div class="row g-4">
    <!-- Filters -->
    <div class="col-lg-3">
      <div class="filter-card">
        <h5 class="filter-title"><i class="bi bi-funnel-fill me-2"></i>Filter Services</h5>
        <form method="GET">
          <div class="mb-3">
            <label class="form-label fw-semibold">Search</label>
            <input type="text" name="q" class="form-control" placeholder="Business name..." value="<?= e($filters['q']) ?>">
          </div>
          <div class="mb-3">
            <label class="form-label fw-semibold">Service Category</label>
            <select name="category_id" class="form-select">
              <option value="">All Categories</option>
              <?php foreach ($categories as $c): ?>
                <option value="<?= $c['id'] ?>" <?= selectedIf($filters['category_id'],$c['id']) ?>><?= e($c['name']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label fw-semibold">District</label>
            <select name="district" class="form-select">
              <option value="">All Districts</option>
              <?php foreach ($districts as $d): ?>
                <option value="<?= e($d['name']) ?>" <?= selectedIf($filters['district'],$d['name']) ?>><?= e($d['name']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary"><i class="bi bi-search me-1"></i>Apply Filters</button>
            <a href="<?= url('services') ?>" class="btn btn-outline-secondary btn-sm">Clear All</a>
          </div>
        </form>
      </div>
    </div>

    <!-- Results -->
    <div class="col-lg-9">
      <h1 class="h4 mb-4">Auto Service Providers <span class="text-muted fw-normal">(<?= number_format($pagination['total']) ?> found)</span></h1>
      <?php if (empty($providers)): ?>
        <div class="empty-state text-center py-5">
          <i class="bi bi-wrench-adjustable display-1 text-muted"></i>
          <h3 class="mt-3">No service providers found</h3>
          <p class="text-muted"><a href="<?= url('services') ?>">Clear filters</a> and try again.</p>
        </div>
      <?php else: ?>
        <div class="row g-4">
          <?php foreach ($providers as $p): ?>
            <div class="col-md-6">
              <div class="provider-card h-100">
                <div class="provider-header">
                  <div class="provider-logo"><i class="bi bi-building"></i></div>
                  <div class="flex-grow-1">
                    <h2 class="provider-name"><a href="<?= url('services/'.$p['id']) ?>"><?= e($p['business_name']) ?></a></h2>
                    <p class="provider-location"><i class="bi bi-geo-alt text-primary me-1"></i><?= e($p['district']) ?><?= $p['city'] ? ', '.e($p['city']) : '' ?></p>
                  </div>
                </div>
                <?php if ($p['working_hours']): ?><p class="provider-hours"><i class="bi bi-clock me-1"></i><?= e($p['working_hours']) ?></p><?php endif; ?>
                <?php if ($p['description']): ?><p class="provider-desc text-muted small"><?= e(truncate($p['description'],120)) ?></p><?php endif; ?>
                <?php if ($p['min_price']): ?><p class="provider-price">Services from <strong><?= formatPrice($p['min_price']) ?></strong></p><?php endif; ?>
                <a href="<?= url('services/'.$p['id']) ?>" class="btn btn-outline-primary btn-sm mt-2">View Services <i class="bi bi-arrow-right"></i></a>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
        <?php require APP_ROOT . '/app/views/partials/pagination.php'; ?>
      <?php endif; ?>
    </div>
  </div>
</div>
