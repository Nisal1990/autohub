<nav class="navbar navbar-expand-lg navbar-dark sticky-top" id="mainNav">
  <div class="container">
    <a class="navbar-brand" href="<?= url() ?>">
      <span class="brand-auto">Auto</span><span class="brand-hub">Hub</span> <span class="brand-lk">LK</span>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navMenu">
      <ul class="navbar-nav me-auto">
        <li class="nav-item"><a class="nav-link" href="<?= url('vehicles') ?>"><i class="bi bi-car-front"></i> Auto Deal</a></li>
        <li class="nav-item"><a class="nav-link" href="<?= url('parts') ?>"><i class="bi bi-tools"></i> Parts</a></li>
        <li class="nav-item"><a class="nav-link" href="<?= url('services') ?>"><i class="bi bi-wrench-adjustable"></i> Services</a></li>
        <li class="nav-item"><a class="nav-link" href="<?= url('promotions') ?>"><i class="bi bi-megaphone"></i> Promotions</a></li>
        <li class="nav-item"><a class="nav-link" href="<?= url('about') ?>">About</a></li>
        <li class="nav-item"><a class="nav-link" href="<?= url('contact') ?>">Contact</a></li>
      </ul>
      <div class="d-flex align-items-center gap-2">
        <?php if (isLoggedIn()): ?>
          <a href="<?= url('dashboard/vehicles/create') ?>" class="btn btn-warning btn-sm fw-semibold">
            <i class="bi bi-plus-circle"></i> Post Ad
          </a>
          <div class="dropdown">
            <button class="btn btn-outline-light btn-sm dropdown-toggle" data-bs-toggle="dropdown">
              <i class="bi bi-person-circle"></i> <?= e($_SESSION['user_name'] ?? 'Account') ?>
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
              <li><a class="dropdown-item" href="<?= url('dashboard/vehicles') ?>"><i class="bi bi-car-front me-2"></i>My Vehicles</a></li>
              <li><a class="dropdown-item" href="<?= url('dashboard/parts') ?>"><i class="bi bi-tools me-2"></i>My Parts</a></li>
              <li><a class="dropdown-item" href="<?= url('dashboard/services') ?>"><i class="bi bi-wrench-adjustable me-2"></i>My Services</a></li>
              <li><a class="dropdown-item" href="<?= url('dashboard/inquiries') ?>"><i class="bi bi-chat-dots me-2"></i>Inquiries</a></li>
              <li><a class="dropdown-item" href="<?= url('dashboard/profile') ?>"><i class="bi bi-person-gear me-2"></i>Profile</a></li>
              <?php if (isAdmin()): ?>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item text-warning" href="<?= url('admin/dashboard') ?>"><i class="bi bi-shield-check me-2"></i>Admin Panel</a></li>
              <?php endif; ?>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item text-danger" href="<?= url('logout') ?>"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
            </ul>
          </div>
        <?php else: ?>
          <a href="<?= url('login') ?>" class="btn btn-outline-light btn-sm">Login</a>
          <a href="<?= url('register') ?>" class="btn btn-warning btn-sm fw-semibold">Register Free</a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</nav>
