<div class="container py-5">
  <div class="row g-4">
    <!-- Filters -->
    <div class="col-lg-3">
      <div class="filter-card">
        <h5 class="filter-title"><i class="bi bi-funnel-fill me-2"></i>Filter Parts</h5>
        <form method="GET">
          <div class="mb-3">
            <label class="form-label fw-semibold">Search</label>
            <input type="text" name="q" class="form-control" placeholder="Part name or number..." value="<?= e($filters['q']) ?>">
          </div>
          <div class="mb-3">
            <label class="form-label fw-semibold">Part Category</label>
            <select name="category_id" class="form-select">
              <option value="">All Categories</option>
              <?php foreach ($categories as $c): ?>
                <option value="<?= $c['id'] ?>" <?= selectedIf($filters['category_id'],$c['id']) ?>><?= e($c['name']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label fw-semibold">Compatible Make</label>
            <select name="compatible_make" class="form-select">
              <option value="">Any Make</option>
              <?php foreach ($makes as $m): ?>
                <option value="<?= e($m['name']) ?>" <?= selectedIf($filters['compatible_make'],$m['name']) ?>><?= e($m['name']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label fw-semibold">Condition</label>
            <select name="condition_type" class="form-select">
              <option value="">Any</option>
              <?php foreach (['New','Used','Reconditioned'] as $c): ?>
                <option value="<?= $c ?>" <?= selectedIf($filters['condition_type'],$c) ?>><?= $c ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="row g-2 mb-3">
            <div class="col-6"><label class="form-label fw-semibold">Min Price</label><input type="number" name="price_min" class="form-control" placeholder="Rs. 0" value="<?= e($filters['price_min']?:'') ?>"></div>
            <div class="col-6"><label class="form-label fw-semibold">Max Price</label><input type="number" name="price_max" class="form-control" placeholder="Any" value="<?= e($filters['price_max']?:'') ?>"></div>
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
            <a href="<?= url('parts') ?>" class="btn btn-outline-secondary btn-sm">Clear All</a>
          </div>
        </form>
      </div>
    </div>

    <!-- Results -->
    <div class="col-lg-9">
      <h1 class="h4 mb-4">Spare Parts <span class="text-muted fw-normal">(<?= number_format($pagination['total']) ?> found)</span></h1>
      <?php if (empty($listings)): ?>
        <div class="empty-state text-center py-5">
          <i class="bi bi-tools display-1 text-muted"></i>
          <h3 class="mt-3">No parts found</h3>
          <p class="text-muted"><a href="<?= url('parts') ?>">Clear filters</a> and try again.</p>
        </div>
      <?php else: ?>
        <div class="row g-4">
          <?php foreach ($listings as $p): ?>
            <div class="col-sm-6 col-xl-4">
              <div class="listing-card h-100">
                <?php if ($p['featured']): ?><div class="listing-badge"><i class="bi bi-star-fill"></i> Featured</div><?php endif; ?>
                <a href="<?= url('parts/'.$p['id']) ?>">
                  <img src="<?= e(imageUrl($p['primary_image'])) ?>" alt="<?= e($p['part_name']) ?>" class="listing-img">
                </a>
                <div class="listing-body">
                  <span class="badge bg-secondary mb-1"><?= e($p['category_name']) ?></span>
                  <h2 class="listing-title"><a href="<?= url('parts/'.$p['id']) ?>"><?= e($p['part_name']) ?></a></h2>
                  <?php if ($p['part_number']): ?><p class="text-muted small mb-1">Part#: <?= e($p['part_number']) ?></p><?php endif; ?>
                  <?php if ($p['compatible_make']): ?><p class="listing-meta"><i class="bi bi-car-front"></i> <?= e($p['compatible_make']) ?><?= $p['compatible_model'] ? ' '.$p['compatible_model'] : '' ?></p><?php endif; ?>
                  <p class="listing-meta"><i class="bi bi-geo-alt"></i> <?= e($p['district']) ?> &bull; <?= e($p['condition_type']) ?></p>
                  <div class="d-flex justify-content-between align-items-center mt-auto">
                    <div class="listing-price"><?= formatPrice($p['price']) ?></div>
                    <a href="<?= url('parts/'.$p['id']) ?>" class="btn btn-sm btn-outline-primary">View</a>
                  </div>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
        <?php require APP_ROOT . '/app/views/partials/pagination.php'; ?>
      <?php endif; ?>
    </div>
  </div>
</div>
