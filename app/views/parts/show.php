<div class="container py-5">
  <nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?= url() ?>">Home</a></li>
      <li class="breadcrumb-item"><a href="<?= url('parts') ?>">Spare Parts</a></li>
      <li class="breadcrumb-item active"><?= e($listing['part_name']) ?></li>
    </ol>
  </nav>
  <div class="row g-5">
    <div class="col-lg-7">
      <?php $primary = array_filter($images, fn($i)=>$i['is_primary']); $primary=reset($primary)?:($images[0]??null); ?>
      <img src="<?= e(imageUrl($primary['image_path']??null)) ?>" alt="<?= e($listing['part_name']) ?>" class="gallery-main mb-3" id="mainImg">
      <?php if (count($images)>1): ?>
        <div class="gallery-thumbs d-flex gap-2 flex-wrap">
          <?php foreach ($images as $img): ?>
            <img src="<?= e(imageUrl($img['image_path'])) ?>" alt="" class="gallery-thumb <?= $img['is_primary']?'active':'' ?>" onclick="document.getElementById('mainImg').src=this.src;document.querySelectorAll('.gallery-thumb').forEach(t=>t.classList.remove('active'));this.classList.add('active');">
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>
    <div class="col-lg-5">
      <div class="listing-detail-card">
        <span class="badge bg-secondary mb-2"><?= e($listing['category_name']) ?></span>
        <h1 class="listing-detail-title"><?= e($listing['part_name']) ?></h1>
        <div class="listing-detail-price mb-3"><?= formatPrice($listing['price']) ?></div>

        <table class="table table-sm mb-4">
          <tbody>
            <?php if ($listing['part_number']): ?><tr><th>Part Number</th><td><?= e($listing['part_number']) ?></td></tr><?php endif; ?>
            <tr><th>Condition</th><td><?= e($listing['condition_type']) ?></td></tr>
            <?php if ($listing['compatible_make']): ?><tr><th>Compatible Make</th><td><?= e($listing['compatible_make']) ?></td></tr><?php endif; ?>
            <?php if ($listing['compatible_model']): ?><tr><th>Compatible Model</th><td><?= e($listing['compatible_model']) ?></td></tr><?php endif; ?>
            <?php if ($listing['compatible_year_from']||$listing['compatible_year_to']): ?><tr><th>Year Range</th><td><?= e($listing['compatible_year_from']) ?> – <?= e($listing['compatible_year_to']) ?></td></tr><?php endif; ?>
            <?php if ($listing['stock_qty']): ?><tr><th>Stock Qty</th><td><?= e($listing['stock_qty']) ?></td></tr><?php endif; ?>
            <tr><th>Location</th><td><?= e($listing['district']) ?><?= $listing['city'] ? ', '.e($listing['city']) : '' ?></td></tr>
            <tr><th>Listed</th><td><?= timeAgo($listing['created_at']) ?></td></tr>
          </tbody>
        </table>

        <div class="seller-card">
          <h6><i class="bi bi-person me-2"></i><?= e($listing['seller_name']) ?></h6>
          <a href="tel:<?= e($listing['seller_phone']) ?>" class="btn btn-success w-100 mb-2">
            <i class="bi bi-telephone-fill me-2"></i><?= e($listing['seller_phone']) ?>
          </a>
          <button class="btn btn-outline-primary w-100" data-bs-toggle="modal" data-bs-target="#inquiryModal">
            <i class="bi bi-chat-dots me-2"></i>Send Inquiry
          </button>
        </div>
      </div>
    </div>
  </div>
  <?php if ($listing['description']): ?>
  <div class="row mt-5"><div class="col-lg-8"><h3 class="h5 fw-bold mb-3">Description</h3><div class="description-text"><?= nl2br(e($listing['description'])) ?></div></div></div>
  <?php endif; ?>
</div>

<!-- Inquiry Modal -->
<div class="modal fade" id="inquiryModal" tabindex="-1">
  <div class="modal-dialog"><div class="modal-content">
    <div class="modal-header"><h5 class="modal-title">Send Inquiry</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
    <form method="POST" action="<?= url('parts/'.$listing['id'].'/inquiry') ?>">
      <?= csrfField() ?>
      <div class="modal-body">
        <div class="mb-3"><label class="form-label">Your Name *</label><input type="text" name="sender_name" class="form-control" required></div>
        <div class="mb-3"><label class="form-label">Phone *</label><input type="tel" name="sender_phone" class="form-control" required></div>
        <div class="mb-3"><label class="form-label">Email</label><input type="email" name="sender_email" class="form-control"></div>
        <div class="mb-3"><label class="form-label">Message *</label><textarea name="message" class="form-control" rows="4" required placeholder="Is this part still available?"></textarea></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary"><i class="bi bi-send me-1"></i>Send</button>
      </div>
    </form>
  </div></div>
</div>
