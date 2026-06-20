<h2 class="h4 fw-bold mb-4">Manage Promotions</h2>

<div class="row g-4 mb-4">
  <div class="col-lg-5">
    <div class="dash-card">
      <h6 class="fw-bold mb-3">Add Promotion</h6>
      <form method="POST" action="<?= url('admin/promotions/add') ?>">
        <?= csrfField() ?>
        <div class="mb-3">
          <label class="form-label fw-semibold">Listing Type</label>
          <select name="listing_type" class="form-select" required>
            <option value="vehicle">Vehicle</option>
            <option value="part">Spare Part</option>
          </select>
        </div>
        <div class="mb-3"><label class="form-label fw-semibold">Listing ID *</label><input type="number" name="listing_id" class="form-control" placeholder="Enter the listing ID" required></div>
        <div class="row g-3 mb-3">
          <div class="col-6"><label class="form-label fw-semibold">Start Date</label><input type="date" name="start_date" class="form-control" value="<?= date('Y-m-d') ?>"></div>
          <div class="col-6"><label class="form-label fw-semibold">End Date</label><input type="date" name="end_date" class="form-control" value="<?= date('Y-m-d', strtotime('+30 days')) ?>"></div>
        </div>
        <button type="submit" class="btn btn-primary w-100"><i class="bi bi-star me-2"></i>Add to Featured</button>
      </form>
    </div>
  </div>
  <div class="col-lg-7">
    <div class="dash-card p-0 overflow-hidden">
      <div class="p-3 border-bottom fw-bold">Current Promotions</div>
      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
          <thead class="table-light"><tr><th>Type</th><th>Title</th><th>Start</th><th>End</th><th>Status</th><th class="text-end">Remove</th></tr></thead>
          <tbody>
            <?php foreach ($list as $promo): ?>
              <tr>
                <td><span class="badge bg-<?= $promo['listing_type']==='vehicle'?'primary':'secondary' ?>"><?= ucfirst($promo['listing_type']) ?></span></td>
                <td><?= e($promo['listing_title']??'ID:'.$promo['listing_id']) ?></td>
                <td class="small"><?= formatDate($promo['start_date']) ?></td>
                <td class="small"><?= formatDate($promo['end_date']) ?></td>
                <td><?= (strtotime($promo['end_date'])>=time())?'<span class="badge bg-success">Active</span>':'<span class="badge bg-secondary">Expired</span>' ?></td>
                <td class="text-end">
                  <form method="POST" action="<?= url('admin/promotions/'.$promo['id'].'/remove') ?>" onsubmit="return confirm('Remove promotion?')"><?= csrfField() ?><button class="btn btn-sm btn-outline-danger"><i class="bi bi-x"></i></button></form>
                </td>
              </tr>
            <?php endforeach; ?>
            <?php if (empty($list)): ?><tr><td colspan="6" class="text-center py-4 text-muted">No promotions yet.</td></tr><?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
