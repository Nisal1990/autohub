<div class="d-flex justify-content-between align-items-center mb-4">
  <h2 class="h4 fw-bold mb-0">Manage Spare Parts</h2>
</div>
<div class="dash-card mb-3">
  <form method="GET" class="d-flex gap-2 flex-wrap">
    <select name="status" class="form-select" style="width:180px" onchange="this.form.submit()">
      <option value="">All Statuses</option>
      <?php foreach (['pending','approved','rejected'] as $s): ?><option value="<?= $s ?>" <?= $status===$s?'selected':'' ?>><?= ucfirst($s) ?></option><?php endforeach; ?>
    </select>
    <input type="text" name="q" class="form-control" style="max-width:260px" placeholder="Part name / number..." value="<?= e($search) ?>">
    <button class="btn btn-primary">Search</button>
    <a href="<?= url('admin/parts') ?>" class="btn btn-outline-secondary">Reset</a>
  </form>
</div>
<div class="dash-card p-0 overflow-hidden">
  <div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
      <thead class="table-light"><tr><th>Part</th><th>Category</th><th>Price</th><th>Location</th><th>Seller</th><th>Status</th><th>Date</th><th class="text-end">Actions</th></tr></thead>
      <tbody>
        <?php foreach ($list as $p): ?>
          <tr>
            <td><div class="fw-semibold"><?= e($p['part_name']) ?></div><div class="text-muted small"><?= e($p['user_name']) ?></div></td>
            <td><?= e($p['category_name']) ?></td>
            <td><?= formatPrice($p['price']) ?></td>
            <td><?= e($p['district']) ?></td>
            <td><?= e($p['seller_phone']??'—') ?></td>
            <td><?= statusBadge($p['status']) ?></td>
            <td class="text-muted small"><?= timeAgo($p['created_at']) ?></td>
            <td class="text-end">
              <div class="dropdown">
                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">Actions</button>
                <ul class="dropdown-menu dropdown-menu-end">
                  <?php if ($p['status']!=='approved'): ?><li><form method="POST" action="<?= url('admin/parts/'.$p['id'].'/approve') ?>"><?= csrfField() ?><button class="dropdown-item text-success"><i class="bi bi-check-circle me-2"></i>Approve</button></form></li><?php endif; ?>
                  <?php if ($p['status']!=='rejected'): ?><li><button class="dropdown-item text-warning" onclick="rejectListing('<?= url('admin/parts/'.$p['id'].'/reject') ?>')"><i class="bi bi-x-circle me-2"></i>Reject</button></li><?php endif; ?>
                  <li><form method="POST" action="<?= url('admin/parts/'.$p['id'].'/feature') ?>"><?= csrfField() ?><input type="hidden" name="featured" value="<?= $p['featured']?0:1 ?>"><button class="dropdown-item"><i class="bi bi-star me-2"></i><?= $p['featured']?'Remove Featured':'Mark Featured' ?></button></form></li>
                  <li><hr class="dropdown-divider"></li>
                  <li><form method="POST" action="<?= url('admin/parts/'.$p['id'].'/delete') ?>" onsubmit="return confirm('Delete?')"><?= csrfField() ?><button class="dropdown-item text-danger"><i class="bi bi-trash me-2"></i>Delete</button></form></li>
                </ul>
              </div>
            </td>
          </tr>
        <?php endforeach; ?>
        <?php if (empty($list)): ?><tr><td colspan="8" class="text-center py-4 text-muted">No parts found.</td></tr><?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
<?php require APP_ROOT . '/app/views/partials/pagination.php'; ?>
<div class="modal fade" id="rejectModal" tabindex="-1"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><h5 class="modal-title">Reject Part</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div><form method="POST" id="rejectForm"><?= csrfField() ?><div class="modal-body"><textarea name="reason" class="form-control" rows="3" required placeholder="Reason for rejection..."></textarea></div><div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button><button type="submit" class="btn btn-danger">Reject</button></div></form></div></div></div>
<script>function rejectListing(action){document.getElementById('rejectForm').action=action;new bootstrap.Modal(document.getElementById('rejectModal')).show();}</script>
