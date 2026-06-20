<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= e($title ?? 'Admin Panel') ?> — <?= SITE_NAME ?></title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link href="<?= BASE_URL ?>/assets/css/style.css" rel="stylesheet">
</head>
<body class="admin-body">

<div class="d-flex" id="admin-wrapper">

  <!-- Admin Sidebar -->
  <nav class="admin-sidebar" id="adminSidebar">
    <div class="sidebar-brand admin-brand">
      <span><i class="bi bi-shield-fill-check text-warning me-2"></i>Admin Panel</span>
    </div>
    <ul class="sidebar-nav">
      <li><a href="<?= url('admin/dashboard') ?>"   class="<?= str_contains($_SERVER['REQUEST_URI']??'','admin/dashboard')||$_SERVER['REQUEST_URI']=='/autohub/public/admin' ? 'active':'' ?>"><i class="bi bi-speedometer2"></i> Dashboard</a></li>
      <li class="sidebar-section">Listings</li>
      <li><a href="<?= url('admin/vehicles') ?>"    class="<?= str_contains($_SERVER['REQUEST_URI']??'','admin/vehicle') ? 'active':'' ?>"><i class="bi bi-car-front"></i> Vehicles</a></li>
      <li><a href="<?= url('admin/parts') ?>"       class="<?= str_contains($_SERVER['REQUEST_URI']??'','admin/parts') ? 'active':'' ?>"><i class="bi bi-tools"></i> Spare Parts</a></li>
      <li><a href="<?= url('admin/services') ?>"    class="<?= str_contains($_SERVER['REQUEST_URI']??'','admin/services') ? 'active':'' ?>"><i class="bi bi-wrench-adjustable"></i> Services</a></li>
      <li class="sidebar-section">Manage</li>
      <li><a href="<?= url('admin/users') ?>"       class="<?= str_contains($_SERVER['REQUEST_URI']??'','admin/users') ? 'active':'' ?>"><i class="bi bi-people"></i> Users</a></li>
      <li><a href="<?= url('admin/inquiries') ?>"   class="<?= str_contains($_SERVER['REQUEST_URI']??'','admin/inquiries') ? 'active':'' ?>"><i class="bi bi-chat-dots"></i> Inquiries</a></li>
      <li><a href="<?= url('admin/promotions') ?>"  class="<?= str_contains($_SERVER['REQUEST_URI']??'','admin/promotions') ? 'active':'' ?>"><i class="bi bi-megaphone"></i> Promotions</a></li>
      <li><a href="<?= url('admin/lookup') ?>"      class="<?= str_contains($_SERVER['REQUEST_URI']??'','admin/lookup') ? 'active':'' ?>"><i class="bi bi-database-gear"></i> Lookup Data</a></li>
      <li><a href="<?= url('admin/reports') ?>"     class="<?= str_contains($_SERVER['REQUEST_URI']??'','admin/reports') ? 'active':'' ?>"><i class="bi bi-bar-chart-line"></i> Reports</a></li>
      <li class="sidebar-divider"></li>
      <li><a href="<?= url() ?>"><i class="bi bi-globe2"></i> View Site</a></li>
      <li><a href="<?= url('admin/logout') ?>" class="text-danger"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
    </ul>
  </nav>

  <!-- Admin Main -->
  <div class="dashboard-main flex-grow-1">
    <div class="admin-topbar d-flex align-items-center px-4 py-2">
      <button class="btn btn-sm btn-outline-secondary d-lg-none me-2" id="adminSidebarToggle"><i class="bi bi-list"></i></button>
      <span class="fw-semibold text-muted"><?= SITE_NAME ?> — Admin</span>
    </div>
    <div class="dashboard-content p-4">
      <?php require APP_ROOT . '/app/views/partials/alerts.php'; ?>
      <?= $content ?>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script src="<?= BASE_URL ?>/assets/js/admin.js"></script>
<script>
document.getElementById('adminSidebarToggle')?.addEventListener('click',()=>{
  document.getElementById('adminSidebar')?.classList.toggle('show');
});
</script>
</body>
</html>
