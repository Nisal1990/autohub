<div class="mb-4">
  <h2 class="h4 fw-bold">Dashboard Overview</h2>
  <p class="text-muted">Welcome back, <?= e($_SESSION['user_name']??'Admin') ?>.</p>
</div>

<!-- Stats Grid -->
<div class="row g-4 mb-5">
  <?php $cards = [
    ['label'=>'Total Users',     'value'=>$data['total_users'],       'icon'=>'people-fill',        'color'=>'primary'],
    ['label'=>'Approved Vehicles','value'=>$data['approved_vehicles'],'icon'=>'car-front-fill',      'color'=>'success'],
    ['label'=>'Pending Approval','value'=>$data['pending_vehicles']+$data['pending_parts']+$data['pending_providers'],'icon'=>'hourglass-split','color'=>'warning'],
    ['label'=>'Parts Listed',    'value'=>$data['total_parts'],       'icon'=>'tools',              'color'=>'info'],
    ['label'=>'Service Providers','value'=>$data['total_providers'],  'icon'=>'wrench-adjustable',  'color'=>'secondary'],
    ['label'=>'Total Inquiries', 'value'=>$data['total_inquiries'],   'icon'=>'chat-dots-fill',     'color'=>'danger'],
    ['label'=>'Unread Messages', 'value'=>$data['unread_inquiries'],  'icon'=>'envelope-fill',      'color'=>'warning'],
    ['label'=>'Active Promos',   'value'=>$data['active_promotions'], 'icon'=>'megaphone-fill',     'color'=>'success'],
  ]; ?>
  <?php foreach ($cards as $c): ?>
    <div class="col-6 col-md-4 col-xl-3">
      <div class="admin-stat-card">
        <div class="admin-stat-icon text-<?= $c['color'] ?>"><i class="bi bi-<?= $c['icon'] ?>"></i></div>
        <div class="admin-stat-num"><?= number_format($c['value']) ?></div>
        <div class="admin-stat-label"><?= e($c['label']) ?></div>
      </div>
    </div>
  <?php endforeach; ?>
</div>

<!-- Quick Actions -->
<div class="row g-4 mb-5">
  <div class="col-md-3"><a href="<?= url('admin/vehicles?status=pending') ?>" class="btn btn-warning w-100"><i class="bi bi-car-front me-2"></i>Pending Vehicles (<?= $data['pending_vehicles'] ?>)</a></div>
  <div class="col-md-3"><a href="<?= url('admin/parts?status=pending') ?>" class="btn btn-warning w-100"><i class="bi bi-tools me-2"></i>Pending Parts (<?= $data['pending_parts'] ?>)</a></div>
  <div class="col-md-3"><a href="<?= url('admin/services?status=pending') ?>" class="btn btn-warning w-100"><i class="bi bi-wrench-adjustable me-2"></i>Pending Services (<?= $data['pending_providers'] ?>)</a></div>
  <div class="col-md-3"><a href="<?= url('admin/inquiries') ?>" class="btn btn-outline-primary w-100"><i class="bi bi-chat-dots me-2"></i>View Inquiries</a></div>
</div>

<!-- Recent Activity -->
<div class="dash-card">
  <h5 class="dash-card-title"><i class="bi bi-activity me-2"></i>Recent Activity</h5>
  <div class="table-responsive">
    <table class="table table-sm align-middle mb-0">
      <thead class="table-light"><tr><th>Type</th><th>Title</th><th>Status</th><th>Date</th></tr></thead>
      <tbody>
        <?php foreach ($recent as $r): ?>
          <tr>
            <td><span class="badge bg-<?= $r['type']==='vehicle'?'primary':($r['type']==='part'?'secondary':'success') ?>"><?= ucfirst($r['type']) ?></span></td>
            <td><?= e($r['title']) ?></td>
            <td><?= statusBadge($r['status']) ?></td>
            <td class="text-muted small"><?= timeAgo($r['created_at']) ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
