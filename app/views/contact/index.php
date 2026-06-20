<section class="page-hero py-5">
  <div class="container text-center">
    <h1 class="display-5 fw-bold mb-3">Contact Us</h1>
    <p class="lead text-muted">We'd love to hear from you. Fill out the form below or reach us directly.</p>
  </div>
</section>

<section class="py-5">
  <div class="container">
    <div class="row g-5">
      <div class="col-lg-5">
        <h3 class="fw-bold mb-4">Get in Touch</h3>
        <div class="contact-info-list">
          <div class="contact-info-item"><div class="contact-info-icon"><i class="bi bi-geo-alt-fill"></i></div><div><strong>Address</strong><p class="text-muted mb-0">AutoHub LK, Colombo, Sri Lanka</p></div></div>
          <div class="contact-info-item"><div class="contact-info-icon"><i class="bi bi-telephone-fill"></i></div><div><strong>Phone</strong><p class="text-muted mb-0">+94 11 234 5678</p></div></div>
          <div class="contact-info-item"><div class="contact-info-icon"><i class="bi bi-envelope-fill"></i></div><div><strong>Email</strong><p class="text-muted mb-0"><a href="mailto:<?= ADMIN_EMAIL ?>"><?= ADMIN_EMAIL ?></a></p></div></div>
          <div class="contact-info-item"><div class="contact-info-icon"><i class="bi bi-clock-fill"></i></div><div><strong>Office Hours</strong><p class="text-muted mb-0">Mon – Fri: 8am – 6pm</p></div></div>
        </div>
      </div>

      <div class="col-lg-7">
        <div class="contact-form-card">
          <h3 class="fw-bold mb-4">Send a Message</h3>

          <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
              <?php foreach ($errors as $err): ?><div><?= e($err) ?></div><?php endforeach; ?>
            </div>
          <?php endif; ?>

          <form method="POST" action="<?= url('contact') ?>">
            <?= csrfField() ?>
            <div class="row g-3 mb-3">
              <div class="col-md-6"><label class="form-label fw-semibold">Your Name *</label><input type="text" name="name" class="form-control" value="<?= e($old['name']??'') ?>" required></div>
              <div class="col-md-6"><label class="form-label fw-semibold">Email *</label><input type="email" name="email" class="form-control" value="<?= e($old['email']??'') ?>" required></div>
            </div>
            <div class="row g-3 mb-3">
              <div class="col-md-6"><label class="form-label fw-semibold">Phone</label><input type="tel" name="phone" class="form-control" placeholder="0771234567" value="<?= e($old['phone']??'') ?>"></div>
              <div class="col-md-6"><label class="form-label fw-semibold">Subject</label><input type="text" name="subject" class="form-control" value="<?= e($old['subject']??'') ?>"></div>
            </div>
            <div class="mb-4"><label class="form-label fw-semibold">Message *</label><textarea name="message" class="form-control" rows="5" required><?= e($old['message']??'') ?></textarea></div>
            <button type="submit" class="btn btn-primary btn-lg px-5"><i class="bi bi-send me-2"></i>Send Message</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>
