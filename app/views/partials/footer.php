<footer class="site-footer mt-5">
  <div class="container">
    <div class="row gy-4">
      <div class="col-lg-4">
        <div class="footer-brand mb-3">
          <span class="brand-auto">Auto</span><span class="brand-hub">Hub</span> <span class="brand-lk">LK</span>
        </div>
        <p class="text-muted small">Sri Lanka's trusted marketplace for vehicles, spare parts, and auto services. Connecting buyers and sellers across all 25 districts.</p>
        <div class="d-flex gap-3 mt-3">
          <a href="#" class="footer-social"><i class="bi bi-facebook"></i></a>
          <a href="#" class="footer-social"><i class="bi bi-instagram"></i></a>
          <a href="#" class="footer-social"><i class="bi bi-youtube"></i></a>
        </div>
      </div>
      <div class="col-6 col-lg-2">
        <h6 class="footer-heading">Browse</h6>
        <ul class="footer-links">
          <li><a href="<?= url('vehicles') ?>">Auto Deal</a></li>
          <li><a href="<?= url('parts') ?>">Spare Parts</a></li>
          <li><a href="<?= url('services') ?>">Services</a></li>
          <li><a href="<?= url('promotions') ?>">Promotions</a></li>
        </ul>
      </div>
      <div class="col-6 col-lg-2">
        <h6 class="footer-heading">Account</h6>
        <ul class="footer-links">
          <li><a href="<?= url('register') ?>">Register Free</a></li>
          <li><a href="<?= url('login') ?>">Login</a></li>
          <li><a href="<?= url('dashboard/vehicles/create') ?>">Post an Ad</a></li>
          <li><a href="<?= url('dashboard') ?>">My Dashboard</a></li>
        </ul>
      </div>
      <div class="col-lg-4">
        <h6 class="footer-heading">Contact</h6>
        <ul class="footer-links">
          <li><i class="bi bi-envelope me-2"></i><a href="mailto:<?= ADMIN_EMAIL ?>"><?= ADMIN_EMAIL ?></a></li>
          <li><i class="bi bi-telephone me-2"></i>+94 11 234 5678</li>
          <li><i class="bi bi-geo-alt me-2"></i>Colombo, Sri Lanka</li>
          <li><a href="<?= url('contact') ?>">Contact Form</a></li>
          <li><a href="<?= url('about') ?>">About Us</a></li>
        </ul>
      </div>
    </div>
    <hr class="footer-divider my-4">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center text-muted small">
      <p class="mb-0">&copy; <?= date('Y') ?> <?= SITE_NAME ?>. All rights reserved.</p>
      <p class="mb-0">Built for Sri Lanka 🇱🇰</p>
    </div>
  </div>
</footer>
