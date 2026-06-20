<div class="container py-5">
  <div class="row g-4">

    <!-- Filters Sidebar -->
    <div class="col-lg-3">
      <div class="filter-card">
        <h5 class="filter-title"><i class="bi bi-funnel-fill me-2"></i>Filter Vehicles</h5>
        <form method="GET" id="filterForm">
          <div class="mb-3">
            <label class="form-label fw-semibold">Manufacturer</label>
            <select name="manufacturer_id" class="form-select" id="makeFilter">
              <option value="">All Makes</option>
              <?php foreach ($manufacturers as $m): ?>
                <option value="<?= $m['id'] ?>" <?= selectedIf($filters['manufacturer_id'],$m['id']) ?>><?= e($m['name']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label fw-semibold">Model</label>
            <select name="model_id" class="form-select" id="modelFilter">
              <option value="">All Models</option>
              <?php foreach ($models as $m): ?>
                <option value="<?= $m['id'] ?>" <?= selectedIf($filters['model_id'],$m['id']) ?>><?= e($m['name']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="row g-2 mb-3">
            <div class="col-6"><label class="form-label fw-semibold">Year From</label><input type="number" name="year_from" class="form-control" placeholder="2000" value="<?= e($filters['year_from']?:'')?>" min="1980" max="<?= date('Y') ?>"></div>
            <div class="col-6"><label class="form-label fw-semibold">Year To</label><input type="number" name="year_to" class="form-control" placeholder="<?= date('Y') ?>" value="<?= e($filters['year_to']?:'')?>" min="1980" max="<?= date('Y') ?>"></div>
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
          <div class="mb-3">
            <label class="form-label fw-semibold">Fuel Type</label>
            <select name="fuel_type" class="form-select">
              <option value="">Any</option>
              <?php foreach (['Petrol','Diesel','Hybrid','Electric','Other'] as $f): ?>
                <option value="<?= $f ?>" <?= selectedIf($filters['fuel_type'],$f) ?>><?= $f ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label fw-semibold">Transmission</label>
            <select name="transmission" class="form-select">
              <option value="">Any</option>
              <?php foreach (['Manual','Automatic','CVT'] as $t): ?>
                <option value="<?= $t ?>" <?= selectedIf($filters['transmission'],$t) ?>><?= $t ?></option>
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
          <div class="mb-3">
            <label class="form-label fw-semibold">Body Type</label>
            <select name="body_type" class="form-select">
              <option value="">Any</option>
              <?php foreach (['Car','Van','SUV','Pickup','Motorcycle','Three-wheeler','Lorry','Bus','Other'] as $b): ?>
                <option value="<?= $b ?>" <?= selectedIf($filters['body_type'],$b) ?>><?= $b ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary"><i class="bi bi-search me-1"></i>Apply Filters</button>
            <a href="<?= url('vehicles') ?>" class="btn btn-outline-secondary btn-sm">Clear All</a>
          </div>
        </form>
      </div>
    </div>

    <!-- Results -->
    <div class="col-lg-9">
      <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
        <h1 class="h4 mb-0">Vehicles <span class="text-muted fw-normal">(<?= number_format($pagination['total']) ?> found)</span></h1>
        <div class="d-flex gap-2 align-items-center">
          <?php if (!empty($filters['q'])): ?>
            <span class="badge bg-primary">Search: <?= e($filters['q']) ?></span>
          <?php endif; ?>
          <form method="GET" class="d-flex gap-1">
            <?php foreach ($filters as $k => $v): if($k==='sort'||empty($v)) continue; ?>
              <input type="hidden" name="<?= e($k) ?>" value="<?= e($v) ?>">
            <?php endforeach; ?>
            <select name="sort" class="form-select form-select-sm" onchange="this.form.submit()">
              <option value="" <?= selectedIf($filters['sort'],'') ?>>Newest First</option>
              <option value="price_asc" <?= selectedIf($filters['sort'],'price_asc') ?>>Price: Low to High</option>
              <option value="price_desc" <?= selectedIf($filters['sort'],'price_desc') ?>>Price: High to Low</option>
              <option value="year_desc" <?= selectedIf($filters['sort'],'year_desc') ?>>Newest Year</option>
            </select>
          </form>
        </div>
      </div>

      <?php if (empty($listings)): ?>
        <div class="empty-state text-center py-5">
          <i class="bi bi-search display-1 text-muted"></i>
          <h3 class="mt-3">No vehicles found</h3>
          <p class="text-muted">Try adjusting your filters or <a href="<?= url('vehicles') ?>">clear all filters</a>.</p>
        </div>
      <?php else: ?>
        <div class="row g-4">
          <?php foreach ($listings as $v): ?>
            <div class="col-sm-6 col-xl-4">
              <div class="listing-card h-100">
                <?php if ($v['featured']): ?><div class="listing-badge"><i class="bi bi-star-fill"></i> Featured</div><?php endif; ?>
                <a href="<?= url('vehicles/'.$v['id']) ?>">
                  <img src="<?= e(imageUrl($v['primary_image'])) ?>" alt="<?= e($v['manufacturer_name'].' '.$v['model_name']) ?>" class="listing-img">
                </a>
                <div class="listing-body">
                  <h2 class="listing-title"><a href="<?= url('vehicles/'.$v['id']) ?>"><?= e($v['manufacturer_name'].' '.$v['model_name']) ?></a></h2>
                  <div class="listing-tags mb-2">
                    <span class="tag"><?= e($v['model_year']) ?></span>
                    <span class="tag"><?= e($v['fuel_type']) ?></span>
                    <span class="tag"><?= e($v['transmission']) ?></span>
                    <span class="tag"><?= e($v['condition_type']) ?></span>
                  </div>
                  <p class="listing-meta"><i class="bi bi-speedometer2"></i> <?= number_format($v['mileage']) ?> km &bull; <i class="bi bi-geo-alt"></i> <?= e($v['district']) ?></p>
                  <div class="d-flex justify-content-between align-items-center mt-auto">
                    <div class="listing-price"><?= formatPrice($v['price']) ?></div>
                    <a href="<?= url('vehicles/'.$v['id']) ?>" class="btn btn-sm btn-outline-primary">View</a>
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

<script>
// Dependent model dropdown
const makeFilter  = document.getElementById('makeFilter');
const modelFilter = document.getElementById('modelFilter');
if (makeFilter && modelFilter) {
  makeFilter.addEventListener('change', function() {
    const makeId = this.value;
    modelFilter.innerHTML = '<option value="">All Models</option>';
    if (!makeId) return;
    fetch('<?= url('ajax/models') ?>?manufacturer_id=' + makeId)
      .then(r => r.json())
      .then(models => {
        models.forEach(m => {
          const opt = document.createElement('option');
          opt.value = m.id; opt.textContent = m.name;
          modelFilter.appendChild(opt);
        });
      });
  });
}
</script>
