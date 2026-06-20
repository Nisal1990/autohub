<section class="page-hero py-5">
  <div class="container text-center">
    <h1 class="display-5 fw-bold mb-3"><i class="bi bi-megaphone-fill me-2 text-warning"></i>Promotions & Featured</h1>
    <p class="lead text-muted">Highlighted listings from our trusted sellers.</p>
  </div>
</section>

<section class="py-5">
  <div class="container">
    <?php if (!empty($featuredVehicles)): ?>
    <div class="section-header mb-4">
      <h2 class="section-title"><i class="bi bi-car-front me-2 text-primary"></i>Featured Vehicles</h2>
    </div>
    <div class="row g-4 mb-5">
      <?php foreach ($featuredVehicles as $v): ?>
        <div class="col-sm-6 col-md-4 col-lg-3">
          <div class="listing-card h-100">
            <div class="listing-badge"><i class="bi bi-star-fill"></i> Featured</div>
            <a href="<?= url('vehicles/'.$v['id']) ?>">
              <img src="<?= e(imageUrl($v['primary_image'])) ?>" alt="<?= e($v['manufacturer_name'].' '.$v['model_name']) ?>" class="listing-img">
            </a>
            <div class="listing-body">
              <h3 class="listing-title"><a href="<?= url('vehicles/'.$v['id']) ?>"><?= e($v['manufacturer_name'].' '.$v['model_name']) ?></a></h3>
              <p class="listing-meta"><i class="bi bi-calendar3"></i> <?= e($v['model_year']) ?> &bull; <i class="bi bi-geo-alt"></i> <?= e($v['district']) ?></p>
              <div class="listing-price"><?= formatPrice($v['price']) ?></div>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <?php if (!empty($featuredParts)): ?>
    <div class="section-header mb-4">
      <h2 class="section-title"><i class="bi bi-tools me-2 text-primary"></i>Featured Spare Parts</h2>
    </div>
    <div class="row g-4">
      <?php foreach ($featuredParts as $p): ?>
        <div class="col-sm-6 col-md-4 col-lg-3">
          <div class="listing-card h-100">
            <div class="listing-badge"><i class="bi bi-star-fill"></i> Featured</div>
            <a href="<?= url('parts/'.$p['id']) ?>">
              <img src="<?= e(imageUrl($p['primary_image'])) ?>" alt="<?= e($p['part_name']) ?>" class="listing-img">
            </a>
            <div class="listing-body">
              <span class="badge bg-secondary mb-1"><?= e($p['category_name']) ?></span>
              <h3 class="listing-title"><a href="<?= url('parts/'.$p['id']) ?>"><?= e($p['part_name']) ?></a></h3>
              <p class="listing-meta"><i class="bi bi-geo-alt"></i> <?= e($p['district']) ?></p>
              <div class="listing-price"><?= formatPrice($p['price']) ?></div>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <?php if (empty($featuredVehicles) && empty($featuredParts)): ?>
      <div class="empty-state text-center py-5">
        <i class="bi bi-megaphone display-1 text-muted"></i>
        <h3 class="mt-3">No promoted listings yet</h3>
        <p class="text-muted">Check back soon for featured deals!</p>
      </div>
    <?php endif; ?>
  </div>
</section>
