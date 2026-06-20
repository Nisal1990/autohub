<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
  <div>
    <h2 class="h4 fw-bold mb-0">My Vehicle Listings</h2>
    <p class="text-muted small mb-0">Manage all your vehicle ads</p>
  </div>
  <a href="<?= url('dashboard/vehicles/create') ?>" class="btn btn-primary"><i class="bi bi-plus-circle me-1"></i>Add Vehicle</a>
</div>

<?php if (empty($listings)): ?>
  <div class="empty-state text-center py-5 dash-card">
    <i class="bi bi-car-front display-1 text-muted"></i>
    <h3 class="mt-3">No listings yet</h3>
    <p class="text-muted">Post your first vehicle ad today.</p>
    <a href="<?= url('dashboard/vehicles/create') ?>" class="btn btn-primary mt-2"><i class="bi bi-plus-circle me-1"></i>Add Vehicle</a>
  </div>
<?php else: ?>
  <div class="dash-card p-0 overflow-hidden">
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
          <tr>
            <th>Vehicle</th>
            <th>Price</th>
            <th>Year</th>
            <th>Location</th>
            <th>Status</th>
            <th>Listed</th>
            <th class="text-end">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($listings as $v): ?>
            <tr>
              <td>
                <div class="d-flex align-items-center gap-3">
                  <img src="<?= e(imageUrl($v['primary_image'])) ?>" alt="" class="listing-table-img">
                  <div>
                    <div class="fw-semibold"><?= e($v['manufacturer_name'].' '.$v['model_name']) ?></div>
                    <div class="text-muted small"><?= e($v['fuel_type']) ?> &bull; <?= e($v['transmission']) ?></div>
                  </div>
                </div>
              </td>
              <td class="fw-semibold text-primary"><?= formatPrice($v['price']) ?></td>
              <td><?= e($v['model_year']) ?></td>
              <td><?= e($v['district']) ?></td>
              <td>
                <?= statusBadge($v['status']) ?>
                <?php if ($v['status']==='rejected' && $v['rejection_reason']): ?>
                  <br><small class="text-danger"><?= e(truncate($v['rejection_reason'],50)) ?></small>
                <?php endif; ?>
              </td>
              <td class="text-muted small"><?= timeAgo($v['created_at']) ?></td>
              <td class="text-end">
                <div class="btn-group btn-group-sm">
                  <?php if ($v['status']==='approved'): ?><a href="<?= url('vehicles/'.$v['id']) ?>" class="btn btn-outline-secondary" title="View"><i class="bi bi-eye"></i></a><?php endif; ?>
                  <a href="<?= url('dashboard/vehicles/'.$v['id'].'/edit') ?>" class="btn btn-outline-primary" title="Edit"><i class="bi bi-pencil"></i></a>
                  <?php if ($v['status']==='approved'): ?>
                    <form method="POST" action="<?= url('dashboard/vehicles/'.$v['id'].'/sold') ?>" class="d-inline" onsubmit="return confirm('Mark as sold?')">
                      <?= csrfField() ?><button class="btn btn-outline-success" title="Mark Sold"><i class="bi bi-check2-circle"></i></button>
                    </form>
                  <?php endif; ?>
                  <form method="POST" action="<?= url('dashboard/vehicles/'.$v['id'].'/delete') ?>" class="d-inline" onsubmit="return confirm('Delete this listing?')">
                    <?= csrfField() ?><button class="btn btn-outline-danger" title="Delete"><i class="bi bi-trash"></i></button>
                  </form>
                </div>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
  <?php require APP_ROOT . '/app/views/partials/pagination.php'; ?>
<?php endif; ?>
