<div class="d-flex justify-content-between align-items-center mb-4">
  <h2 class="h4 fw-bold mb-0">Manage Service Providers</h2>
</div>
<div class="dash-card mb-3">
  <form method="GET" class="d-flex gap-2">
    <select name="status" class="form-select" style="width:180px" onchange="this.form.submit()">
      <option value="">All Statuses</option>
      <?php foreach (['pending','approved','rejected'] as $s): ?><option value="<?= $s ?>" <?= $status===$s?'selected':'' ?>><?= ucfirst($s) ?></option><?php endforeach; ?>
    </select>
    <a href="<?= url('admin/services') ?>" class="btn btn-outline-secondary">Reset</a>
  </form>
</div>
<div class="dash-card p-0 overflow-hidden">
  <div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
      <thead class="table-light"><tr><th>Business</th><th>Owner</th><th>Location</th><th>Phone</th><th>Status</th><th>Date</th><th class="text-end">Actions</th></tr></thead>
      <tbody>
        <?php foreach ($list as $p): ?>
          <tr>
            <td class="fw-semibold"><?= e($p['business_name']) ?></td>
            <td><?= e($p['user_name']) ?><br><small class="text-muted"><?= e($p['user_email']) ?></small></td>
            <td><?= e($p['district']) ?><?= $p['city']?', '.e($p['city']):'' ?></td>
            <td><?= e($p['contact_phone']) ?></td>
            <td><?= statusBadge($p['status']) ?></td>
            <td class="text-muted small"><?= timeAgo($p['created_at']) ?></td>
            <td class="text-end">
              <div class="btn-group btn-group-sm">
                <?php if ($p['status']!=='approved'): ?><form method="POST" action="<?= url('admin/services/'.$p['id'].'/approve') ?>"><?= csrfField() ?><button class="btn btn-outline-success" title="Approve"><i class="bi bi-check-circle"></i></button></form><?php endif; ?>
                <form method="POST" action="<?= url('admin/services/'.$p['id'].'/delete') ?>" onsubmit="return confirm('Delete provider and all their services?')"><?= csrfField() ?><button class="btn btn-outline-danger" title="Delete"><i class="bi bi-trash"></i></button></form>
              </div>
            </td>
          </tr>
        <?php endforeach; ?>
        <?php if (empty($list)): ?><tr><td colspan="7" class="text-center py-4 text-muted">No providers found.</td></tr><?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
<?php require APP_ROOT . '/app/views/partials/pagination.php'; ?>
