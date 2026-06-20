<!-- HERO -->
<section class="hero-section">
  <div class="hero-overlay"></div>
  <div class="container hero-content">
    <h1 class="hero-title">Find Your Perfect Ride in Sri Lanka</h1>
    <p class="hero-subtitle">Browse thousands of vehicles, spare parts & auto services across all 25 districts.</p>

    <!-- Search Bar -->
    <div class="hero-search-card">
      <form action="<?= url('vehicles') ?>" method="GET" class="row g-2 align-items-end">
        <div class="col-12 col-md-4">
          <input type="text" name="q" class="form-control form-control-lg" placeholder="Search vehicles, parts, services...">
        </div>
        <div class="col-6 col-md-3">
          <select name="district" class="form-select form-select-lg">
            <option value="">All Districts</option>
            <?php foreach ($districts as $d): ?>
              <option value="<?= e($d['name']) ?>"><?= e($d['name']) ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="col-6 col-md-3">
          <select name="category" class="form-select form-select-lg" id="heroCategory">
            <option value="vehicles">Vehicles</option>
            <option value="parts">Spare Parts</option>
            <option value="services">Services</option>
          </select>
        </div>
        <div class="col-12 col-md-2">
          <button type="submit" class="btn btn-warning btn-lg w-100 fw-bold" id="heroSearchBtn">
            <i class="bi bi-search"></i> Search
          </button>
        </div>
      </form>
    </div>

    <!-- Stats Strip -->
    <div class="hero-stats">
      <div class="stat-item"><span class="stat-num"><?= number_format($stats['total_vehicles']) ?>+</span><span class="stat-label">Vehicles</span></div>
      <div class="stat-item"><span class="stat-num"><?= number_format($stats['total_parts']) ?>+</span><span class="stat-label">Parts</span></div>
      <div class="stat-item"><span class="stat-num"><?= number_format($stats['total_services']) ?>+</span><span class="stat-label">Service Centers</span></div>
      <div class="stat-item"><span class="stat-num"><?= number_format($stats['total_users']) ?>+</span><span class="stat-label">Registered Users</span></div>
    </div>
  </div>
</section>

<!-- CATEGORY SHORTCUTS -->
<section class="category-shortcuts py-5">
  <div class="container">
    <div class="row g-4">
      <div class="col-md-4">
        <a href="<?= url('vehicles') ?>" class="category-card">
          <div class="category-icon"><i class="bi bi-car-front-fill"></i></div>
          <div class="category-info">
            <h3>Auto Deal</h3>
            <p>Buy & sell new and used vehicles across Sri Lanka</p>
          </div>
          <i class="bi bi-arrow-right category-arrow"></i>
        </a>
      </div>
      <div class="col-md-4">
        <a href="<?= url('parts') ?>" class="category-card">
          <div class="category-icon parts-icon"><i class="bi bi-tools"></i></div>
          <div class="category-info">
            <h3>Spare Parts</h3>
            <p>Find genuine & aftermarket parts from local sellers</p>
          </div>
          <i class="bi bi-arrow-right category-arrow"></i>
        </a>
      </div>
      <div class="col-md-4">
        <a href="<?= url('services') ?>" class="category-card">
          <div class="category-icon services-icon"><i class="bi bi-wrench-adjustable-circle-fill"></i></div>
          <div class="category-info">
            <h3>Services</h3>
            <p>Workshops, garages & auto service providers near you</p>
          </div>
          <i class="bi bi-arrow-right category-arrow"></i>
        </a>
      </div>
    </div>
  </div>
</section>

<!-- FEATURED VEHICLES CAROUSEL -->
<?php if (!empty($featured)): ?>
<section class="featured-section py-5 bg-light">
  <div class="container">
    <div class="section-header">
      <h2 class="section-title"><i class="bi bi-star-fill text-warning me-2"></i>Featured Vehicles</h2>
      <a href="<?= url('vehicles') ?>" class="section-link">View All <i class="bi bi-arrow-right"></i></a>
    </div>
    <div id="featuredCarousel" class="carousel slide" data-bs-ride="carousel">
      <div class="carousel-inner">
        <?php $chunks = array_chunk($featured, 3); ?>
        <?php foreach ($chunks as $i => $chunk): ?>
          <div class="carousel-item <?= $i === 0 ? 'active' : '' ?>">
            <div class="row g-4">
              <?php foreach ($chunk as $v): ?>
                <div class="col-md-4">
                  <div class="listing-card">
                    <?php if ($v['featured']): ?><div class="listing-badge"><i class="bi bi-star-fill"></i> Featured</div><?php endif; ?>
                    <a href="<?= url('vehicles/'.$v['id']) ?>">
                      <img src="<?= e(imageUrl($v['primary_image'])) ?>" alt="<?= e($v['manufacturer_name'].' '.$v['model_name']) ?>" class="listing-img">
                    </a>
                    <div class="listing-body">
                      <h4 class="listing-title"><a href="<?= url('vehicles/'.$v['id']) ?>"><?= e($v['manufacturer_name'].' '.$v['model_name']) ?></a></h4>
                      <p class="listing-meta"><i class="bi bi-calendar3"></i> <?= e($v['model_year']) ?> &bull; <i class="bi bi-speedometer2"></i> <?= number_format($v['mileage']) ?> km</p>
                      <p class="listing-meta"><i class="bi bi-geo-alt"></i> <?= e($v['district']) ?></p>
                      <div class="listing-price"><?= formatPrice($v['price']) ?></div>
                    </div>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
      <?php if (count($chunks) > 1): ?>
      <button class="carousel-control-prev" type="button" data-bs-target="#featuredCarousel" data-bs-slide="prev"><span class="carousel-control-prev-icon"></span></button>
      <button class="carousel-control-next" type="button" data-bs-target="#featuredCarousel" data-bs-slide="next"><span class="carousel-control-next-icon"></span></button>
      <?php endif; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- LATEST VEHICLES -->
<?php if (!empty($vehicles)): ?>
<section class="py-5">
  <div class="container">
    <div class="section-header">
      <h2 class="section-title">Latest Vehicles</h2>
      <a href="<?= url('vehicles') ?>" class="section-link">Browse All <i class="bi bi-arrow-right"></i></a>
    </div>
    <div class="row g-4">
      <?php foreach ($vehicles as $v): ?>
        <div class="col-6 col-md-4 col-lg-2">
          <div class="listing-card compact">
            <a href="<?= url('vehicles/'.$v['id']) ?>">
              <img src="<?= e(imageUrl($v['primary_image'])) ?>" alt="<?= e($v['manufacturer_name'].' '.$v['model_name']) ?>" class="listing-img-sm">
            </a>
            <div class="listing-body p-2">
              <h6 class="listing-title-sm"><a href="<?= url('vehicles/'.$v['id']) ?>"><?= e($v['manufacturer_name'].' '.$v['model_name']) ?></a></h6>
              <p class="listing-price-sm"><?= formatPrice($v['price']) ?></p>
              <p class="listing-meta-xs"><i class="bi bi-geo-alt"></i> <?= e($v['district']) ?></p>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- PARTS & SERVICES ROW -->
<section class="py-5 bg-light">
  <div class="container">
    <div class="row g-5">

      <!-- Latest Parts -->
      <div class="col-lg-6">
        <div class="section-header">
          <h2 class="section-title"><i class="bi bi-tools me-2"></i>Latest Spare Parts</h2>
          <a href="<?= url('parts') ?>" class="section-link">View All <i class="bi bi-arrow-right"></i></a>
        </div>
        <div class="list-group parts-list">
          <?php foreach ($parts as $p): ?>
            <a href="<?= url('parts/'.$p['id']) ?>" class="list-group-item list-group-item-action parts-list-item">
              <div class="d-flex gap-3 align-items-center">
                <img src="<?= e(imageUrl($p['primary_image'])) ?>" alt="" class="parts-thumb">
                <div class="flex-grow-1">
                  <div class="fw-semibold"><?= e($p['part_name']) ?></div>
                  <div class="text-muted small"><?= e($p['category_name']) ?> &bull; <?= e($p['condition_type']) ?></div>
                  <div class="text-muted small"><i class="bi bi-geo-alt"></i> <?= e($p['district']) ?></div>
                </div>
                <div class="fw-bold text-primary"><?= formatPrice($p['price']) ?></div>
              </div>
            </a>
          <?php endforeach; ?>
          <?php if (empty($parts)): ?>
            <div class="list-group-item text-muted">No parts listed yet.</div>
          <?php endif; ?>
        </div>
      </div>

      <!-- Latest Services -->
      <div class="col-lg-6">
        <div class="section-header">
          <h2 class="section-title"><i class="bi bi-wrench-adjustable me-2"></i>Service Providers</h2>
          <a href="<?= url('services') ?>" class="section-link">View All <i class="bi bi-arrow-right"></i></a>
        </div>
        <div class="list-group services-list">
          <?php foreach ($services as $s): ?>
            <a href="<?= url('services/'.$s['id']) ?>" class="list-group-item list-group-item-action services-list-item">
              <div class="d-flex gap-3 align-items-center">
                <div class="service-logo-thumb"><i class="bi bi-building"></i></div>
                <div class="flex-grow-1">
                  <div class="fw-semibold"><?= e($s['business_name']) ?></div>
                  <div class="text-muted small"><i class="bi bi-geo-alt"></i> <?= e($s['district']) ?>, <?= e($s['city']) ?></div>
                  <?php if ($s['working_hours']): ?><div class="text-muted small"><i class="bi bi-clock"></i> <?= e($s['working_hours']) ?></div><?php endif; ?>
                </div>
                <i class="bi bi-chevron-right text-muted"></i>
              </div>
            </a>
          <?php endforeach; ?>
          <?php if (empty($services)): ?>
            <div class="list-group-item text-muted">No service providers yet.</div>
          <?php endif; ?>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- CTA BANNER -->
<section class="cta-section py-5">
  <div class="container text-center">
    <h2 class="cta-title">Ready to Sell Your Vehicle or List Your Services?</h2>
    <p class="cta-sub">Join thousands of Sri Lankan sellers on AutoHub LK. Free registration, easy listing.</p>
    <div class="d-flex gap-3 justify-content-center flex-wrap">
      <a href="<?= url('register') ?>" class="btn btn-warning btn-lg fw-bold px-5">Register Free</a>
      <a href="<?= url('about') ?>" class="btn btn-outline-light btn-lg px-5">Learn More</a>
    </div>
  </div>
</section>

<script>
// Hero search category routing
document.getElementById('heroSearchBtn')?.addEventListener('click', function(e) {
  const form = this.closest('form');
  const cat  = document.getElementById('heroCategory')?.value;
  if (cat === 'parts')    form.action = '<?= url('parts') ?>';
  if (cat === 'services') form.action = '<?= url('services') ?>';
});
</script>
