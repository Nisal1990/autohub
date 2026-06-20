<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= e($title ?? 'My Dashboard') ?> — <?= SITE_NAME ?></title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link href="<?= BASE_URL ?>/assets/css/style.css" rel="stylesheet">
</head>
<body class="dashboard-body">

<div class="d-flex" id="dashboard-wrapper">

  <!-- Sidebar -->
  <nav class="dashboard-sidebar" id="dashSidebar">
    <div class="sidebar-brand">
      <a href="<?= url() ?>"><img src="<?= BASE_URL ?>/assets/images/logo.png" alt="AutoHub LK" height="32" onerror="this.style.display='none'"> <span>AutoHub <strong>LK</strong></span></a>
    </div>
    <div class="sidebar-user">
      <div class="sidebar-avatar"><i class="bi bi-person-circle"></i></div>
      <div>
        <div class="sidebar-username"><?= e($_SESSION['user_name'] ?? '') ?></div>
        <div class="sidebar-role">My Account</div>
      </div>
    </div>
    <ul class="sidebar-nav">
      <li><a href="<?= url('dashboard/vehicles') ?>" class="<?= str_contains($_SERVER['REQUEST_URI']??'','dashboard/vehicle') ? 'active':'' ?>"><i class="bi bi-car-front-fill"></i> My Vehicles</a></li>
      <li><a href="<?= url('dashboard/parts') ?>"    class="<?= str_contains($_SERVER['REQUEST_URI']??'','dashboard/part') ? 'active':'' ?>"><i class="bi bi-tools"></i> My Parts</a></li>
      <li><a href="<?= url('dashboard/services') ?>" class="<?= str_contains($_SERVER['REQUEST_URI']??'','dashboard/service') ? 'active':'' ?>"><i class="bi bi-wrench-adjustable-circle"></i> My Services</a></li>
      <li><a href="<?= url('dashboard/inquiries') ?>" class="<?= str_contains($_SERVER['REQUEST_URI']??'','inquiries') ? 'active':'' ?>"><i class="bi bi-chat-dots"></i> Inquiries</a></li>
      <li><a href="<?= url('dashboard/profile') ?>"  class="<?= str_contains($_SERVER['REQUEST_URI']??'','profile') ? 'active':'' ?>"><i class="bi bi-person-gear"></i> Profile</a></li>
      <li class="sidebar-divider"></li>
      <li><a href="<?= url() ?>"><i class="bi bi-house"></i> Back to Site</a></li>
      <li><a href="<?= url('logout') ?>" class="text-danger"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
    </ul>
  </nav>

  <!-- Main content -->
  <div class="dashboard-main flex-grow-1">
    <div class="dashboard-topbar d-flex align-items-center justify-content-between px-4 py-2">
      <button class="btn btn-sm btn-outline-secondary d-lg-none" id="sidebarToggle"><i class="bi bi-list"></i></button>
      <div class="ms-auto">
        <a href="<?= url('dashboard/vehicles/create') ?>" class="btn btn-primary btn-sm"><i class="bi bi-plus-circle"></i> New Listing</a>
      </div>
    </div>
    <div class="dashboard-content p-4">
      <?php require APP_ROOT . '/app/views/partials/alerts.php'; ?>
      <?= $content ?>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= BASE_URL ?>/assets/js/app.js"></script>
<script>
document.getElementById('sidebarToggle')?.addEventListener('click',()=>{
  document.getElementById('dashSidebar')?.classList.toggle('show');
});
</script>
</body>
</html>
