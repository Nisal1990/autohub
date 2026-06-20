<?php
// Shared admin listing management template for vehicles/parts/services
// Used by: admin/vehicles/index.php, admin/parts/index.php, admin/services/index.php
?>
<div class="d-flex justify-content-between align-items-center mb-4">
  <h2 class="h4 fw-bold mb-0">Manage Vehicle Listings</h2>
</div>

<div class="dash-card mb-3">
  <form method="GET" class="d-flex gap-2 flex-wrap">
    <select name="status" class="form-select" style="width:180px" onchange="this.form.submit()">
      <option value="" <?= !$status?'selected':'' ?>>All Statuses</option>
      <?php foreach (['pending','approved','rejected','sold'] as $s): ?>
        <option value="<?= $s ?>" <?= $status===$s?'selected':'' ?>><?= ucfirst($s) ?></option>
      <?php endforeach; ?>
    </select>
    <input type="text" name="q" class="form-control" style="max-width:260px" placeholder="Search make/model..." value="<?= e($search) ?>">
    <button class="btn btn-primary">Search</button>
    <a href="<?= url('admin/vehicles') ?>" class="btn btn-outline-secondary">Reset</a>
  </form>
</div>

<div class="dash-card p-0 overflow-hidden">
  <div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
      <thead class="table-light">
        <tr><th>Vehicle</th><th>Price</th><th>Year</th><th>District</th><th>Seller</th><th>Status</th><th>Featured</th><th>Date</th><th class="text-end">Actions</th></tr>
      </thead>
      <tbody>
        <?php foreach ($list as $v): ?>
          <tr>
            <td>
              <div class="fw-semibold"><?= e($v['manufacturer_name'].' '.$v['model_name']) ?></div>
              <div class="text-muted small"><?= e($v['user_name']) ?></div>
            </td>
            <td><?= formatPrice($v['price']) ?></td>
            <td><?= e($v['model_year']) ?></td>
            <td><?= e($v['district']) ?></td>
            <td><?= e($v['seller_phone'] ?? '—') ?></td>
            <td>
              <?= statusBadge($v['status']) ?>
              <?php if ($v['rejection_reason']): ?><br><small class="text-danger"><?= e(truncate($v['rejection_reason'],40)) ?></small><?php endif; ?>
            </td>
            <td><?= $v['featured'] ? '<span class="badge bg-warning text-dark"><i class="bi bi-star-fill"></i></span>' : '<span class="text-muted">—</span>' ?></td>
            <td class="text-muted small"><?= timeAgo($v['created_at']) ?></td>
            <td class="text-end">
              <div class="dropdown">
                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">Actions</button>
                <ul class="dropdown-menu dropdown-menu-end">
                  <?php if ($v['status']!=='approved'): ?>
                    <li><form method="POST" action="<?= url('admin/vehicles/'.$v['id'].'/approve') ?>"><?= csrfField() ?><button class="dropdown-item text-success"><i class="bi bi-check-circle me-2"></i>Approve</button></form></li>
                  <?php endif; ?>
                  <?php if ($v['status']!=='rejected'): ?>
                    <li>
                      <button class="dropdown-item text-warning" onclick="rejectListing('<?= url('admin/vehicles/'.$v['id'].'/reject') ?>')">
                        <i class="bi bi-x-circle me-2"></i>Reject
                      </button>
                    </li>
                  <?php endif; ?>
                  <li><form method="POST" action="<?= url('admin/vehicles/'.$v['id'].'/feature') ?>"><?= csrfField() ?><input type="hidden" name="featured" value="<?= $v['featured']?0:1 ?>"><button class="dropdown-item"><i class="bi bi-star me-2"></i><?= $v['featured']?'Remove Featured':'Mark Featured' ?></button></form></li>
                  <li><hr class="dropdown-divider"></li>
                  <li><form method="POST" action="<?= url('admin/vehicles/'.$v['id'].'/delete') ?>" onsubmit="return confirm('Delete this listing permanently?')"><?= csrfField() ?><button class="dropdown-item text-danger"><i class="bi bi-trash me-2"></i>Delete</button></form></li>
                </ul>
              </div>
            </td>
          </tr>
        <?php endforeach; ?>
        <?php if (empty($list)): ?><tr><td colspan="9" class="text-center text-muted py-4">No listings found.</td></tr><?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
<?php require APP_ROOT . '/app/views/partials/pagination.php'; ?>

<!-- Reject Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1">
  <div class="modal-dialog"><div class="modal-content">
    <div class="modal-header"><h5 class="modal-title">Reject Listing</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
    <form method="POST" id="rejectForm">
      <?= csrfField() ?>
      <div class="modal-body"><label class="form-label fw-semibold">Reason for rejection *</label><textarea name="reason" class="form-control" rows="3" required placeholder="Explain why this listing is being rejected..."></textarea></div>
      <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button><button type="submit" class="btn btn-danger">Reject Listing</button></div>
    </form>
  </div></div>
</div>
<script>
function rejectListing(action) {
  document.getElementById('rejectForm').action = action;
  new bootstrap.Modal(document.getElementById('rejectModal')).show();
}
</script>
