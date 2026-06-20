<div class="container py-5">
  <nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?= url() ?>">Home</a></li>
      <li class="breadcrumb-item"><a href="<?= url('vehicles') ?>">Vehicles</a></li>
      <li class="breadcrumb-item active"><?= e($listing['manufacturer_name'].' '.$listing['model_name']) ?></li>
    </ol>
  </nav>

  <div class="row g-5">
    <!-- Images -->
    <div class="col-lg-7">
      <?php $primary = array_filter($images, fn($i) => $i['is_primary']); $primary = reset($primary) ?: ($images[0] ?? null); ?>
      <div class="listing-gallery">
        <img src="<?= e(imageUrl($primary['image_path'] ?? null)) ?>" alt="Main image" class="gallery-main mb-3" id="mainImg">
        <?php if (count($images) > 1): ?>
        <div class="gallery-thumbs d-flex gap-2 flex-wrap">
          <?php foreach ($images as $img): ?>
            <img src="<?= e(imageUrl($img['image_path'])) ?>" alt="" class="gallery-thumb <?= $img['is_primary'] ? 'active':'' ?>" onclick="document.getElementById('mainImg').src=this.src; document.querySelectorAll('.gallery-thumb').forEach(t=>t.classList.remove('active')); this.classList.add('active');">
          <?php endforeach; ?>
        </div>
        <?php endif; ?>
      </div>
    </div>

    <!-- Details -->
    <div class="col-lg-5">
      <div class="listing-detail-card">
        <div class="d-flex align-items-start justify-content-between mb-1">
          <h1 class="listing-detail-title"><?= e($listing['manufacturer_name'].' '.$listing['model_name']) ?></h1>
          <?php if ($listing['featured']): ?><span class="badge bg-warning text-dark"><i class="bi bi-star-fill"></i> Featured</span><?php endif; ?>
        </div>
        <div class="listing-detail-price mb-3"><?= formatPrice($listing['price']) ?></div>

        <div class="specs-grid mb-4">
          <div class="spec-item"><i class="bi bi-calendar3"></i><span><?= e($listing['model_year']) ?></span><label>Year</label></div>
          <div class="spec-item"><i class="bi bi-speedometer2"></i><span><?= number_format($listing['mileage']) ?> km</span><label>Mileage</label></div>
          <div class="spec-item"><i class="bi bi-fuel-pump"></i><span><?= e($listing['fuel_type']) ?></span><label>Fuel</label></div>
          <div class="spec-item"><i class="bi bi-gear"></i><span><?= e($listing['transmission']) ?></span><label>Gearbox</label></div>
          <div class="spec-item"><i class="bi bi-card-checklist"></i><span><?= e($listing['condition_type']) ?></span><label>Condition</label></div>
          <div class="spec-item"><i class="bi bi-car-front"></i><span><?= e($listing['body_type']) ?></span><label>Body Type</label></div>
        </div>

        <div class="mb-3">
          <p class="mb-1"><i class="bi bi-geo-alt text-primary me-2"></i><strong><?= e($listing['district']) ?></strong><?= $listing['city'] ? ', '.e($listing['city']) : '' ?></p>
          <p class="text-muted small"><i class="bi bi-clock me-1"></i>Listed <?= timeAgo($listing['created_at']) ?></p>
        </div>

        <!-- Contact Seller -->
        <div class="seller-card">
          <h6 class="mb-2"><i class="bi bi-person me-2"></i><?= e($listing['seller_name']) ?></h6>
          <a href="tel:<?= e($listing['seller_phone']) ?>" class="btn btn-success w-100 mb-2">
            <i class="bi bi-telephone-fill me-2"></i><?= e($listing['seller_phone']) ?>
          </a>
          <?php if ($listing['show_email']): ?>
            <a href="mailto:<?= e($listing['owner_email']) ?>" class="btn btn-outline-secondary w-100 mb-2">
              <i class="bi bi-envelope me-2"></i>Email Seller
            </a>
          <?php endif; ?>
          <button class="btn btn-outline-primary w-100" data-bs-toggle="modal" data-bs-target="#inquiryModal">
            <i class="bi bi-chat-dots me-2"></i>Send Inquiry
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- Description -->
  <?php if ($listing['description']): ?>
  <div class="row mt-5">
    <div class="col-lg-8">
      <h3 class="h5 fw-bold mb-3">Description</h3>
      <div class="description-text"><?= nl2br(e($listing['description'])) ?></div>
    </div>
  </div>
  <?php endif; ?>
</div>

<!-- Inquiry Modal -->
<div class="modal fade" id="inquiryModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><i class="bi bi-chat-dots me-2"></i>Send Inquiry</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form method="POST" action="<?= url('vehicles/'.$listing['id'].'/inquiry') ?>">
        <?= csrfField() ?>
        <div class="modal-body">
          <div class="mb-3"><label class="form-label">Your Name *</label><input type="text" name="sender_name" class="form-control" required></div>
          <div class="mb-3"><label class="form-label">Phone *</label><input type="tel" name="sender_phone" class="form-control" placeholder="0771234567" required></div>
          <div class="mb-3"><label class="form-label">Email</label><input type="email" name="sender_email" class="form-control"></div>
          <div class="mb-3"><label class="form-label">Message *</label><textarea name="message" class="form-control" rows="4" required placeholder="I am interested in this vehicle. Is it still available?"></textarea></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary"><i class="bi bi-send me-1"></i>Send Inquiry</button>
        </div>
      </form>
    </div>
  </div>
</div>
