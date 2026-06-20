<div class="container py-5">
  <nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?= url() ?>">Home</a></li>
      <li class="breadcrumb-item"><a href="<?= url('services') ?>">Services</a></li>
      <li class="breadcrumb-item active"><?= e($provider['business_name']) ?></li>
    </ol>
  </nav>

  <!-- Provider Header -->
  <div class="provider-detail-header mb-5">
    <div class="row align-items-center g-4">
      <div class="col-auto">
        <div class="provider-logo-lg">
          <?php if ($provider['logo_path']): ?>
            <img src="<?= e(imageUrl($provider['logo_path'])) ?>" alt="" class="provider-logo-img">
          <?php else: ?>
            <i class="bi bi-building-gear"></i>
          <?php endif; ?>
        </div>
      </div>
      <div class="col">
        <h1 class="h2 fw-bold mb-1"><?= e($provider['business_name']) ?></h1>
        <p class="text-muted mb-2"><i class="bi bi-geo-alt me-1"></i><?= e($provider['address'] ?: $provider['district']) ?><?= $provider['city'] ? ', '.e($provider['city']) : '' ?>, <?= e($provider['district']) ?></p>
        <?php if ($provider['working_hours']): ?><p class="text-muted mb-2"><i class="bi bi-clock me-1"></i><?= e($provider['working_hours']) ?></p><?php endif; ?>
        <?php if ($provider['contact_phone']): ?><a href="tel:<?= e($provider['contact_phone']) ?>" class="btn btn-success me-2"><i class="bi bi-telephone-fill me-2"></i><?= e($provider['contact_phone']) ?></a><?php endif; ?>
        <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#inquiryModal"><i class="bi bi-chat-dots me-2"></i>Request a Quote</button>
      </div>
    </div>
    <?php if ($provider['description']): ?><div class="mt-4 description-text"><?= nl2br(e($provider['description'])) ?></div><?php endif; ?>
  </div>

  <!-- Services List -->
  <h2 class="h4 fw-bold mb-4"><i class="bi bi-list-check me-2"></i>Services Offered</h2>
  <?php if (empty($services)): ?>
    <div class="alert alert-info">No services listed yet.</div>
  <?php else: ?>
    <div class="row g-4">
      <?php foreach ($services as $svc): ?>
        <div class="col-md-6">
          <div class="service-item-card">
            <div class="d-flex justify-content-between align-items-start">
              <div>
                <span class="badge bg-primary-subtle text-primary mb-1"><?= e($svc['category_name']) ?></span>
                <h3 class="service-item-name"><?= e($svc['name']) ?></h3>
                <?php if ($svc['description']): ?><p class="text-muted small mb-2"><?= e($svc['description']) ?></p><?php endif; ?>
              </div>
              <div class="service-item-price"><?= formatPrice($svc['base_price']) ?></div>
            </div>
            <!-- Add-ons -->
            <?php if (!empty($svc['addons'])): ?>
              <div class="addons-list mt-2">
                <small class="text-muted fw-semibold d-block mb-1">Add-ons:</small>
                <?php foreach ($svc['addons'] as $addon): ?>
                  <div class="addon-item d-flex justify-content-between">
                    <span class="text-muted small"><i class="bi bi-plus-circle me-1"></i><?= e($addon['addon_name']) ?></span>
                    <span class="text-muted small">+ <?= formatPrice($addon['addon_price']) ?></span>
                  </div>
                <?php endforeach; ?>
              </div>
            <?php endif; ?>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</div>

<!-- Inquiry Modal -->
<div class="modal fade" id="inquiryModal" tabindex="-1">
  <div class="modal-dialog"><div class="modal-content">
    <div class="modal-header"><h5 class="modal-title">Request a Quote</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
    <form method="POST" action="<?= url('services/'.$provider['id'].'/inquiry') ?>">
      <?= csrfField() ?>
      <div class="modal-body">
        <div class="mb-3"><label class="form-label">Your Name *</label><input type="text" name="sender_name" class="form-control" required></div>
        <div class="mb-3"><label class="form-label">Phone *</label><input type="tel" name="sender_phone" class="form-control" required></div>
        <div class="mb-3"><label class="form-label">Email</label><input type="email" name="sender_email" class="form-control"></div>
        <div class="mb-3"><label class="form-label">Message *</label><textarea name="message" class="form-control" rows="4" required placeholder="Describe what service you need..."></textarea></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary"><i class="bi bi-send me-1"></i>Send Request</button>
      </div>
    </form>
  </div></div>
</div>
