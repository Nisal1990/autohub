<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
  <div>
    <h2 class="h4 fw-bold mb-0">My Parts Listings</h2>
    <p class="text-muted small mb-0">Manage your spare part ads</p>
  </div>
  <a href="<?= url('dashboard/parts/create') ?>" class="btn btn-primary"><i class="bi bi-plus-circle me-1"></i>Add Part</a>
</div>

<?php if (empty($listings)): ?>
  <div class="empty-state text-center py-5 dash-card">
    <i class="bi bi-tools display-1 text-muted"></i>
    <h3 class="mt-3">No parts listed yet</h3>
    <a href="<?= url('dashboard/parts/create') ?>" class="btn btn-primary mt-2">Add Your First Part</a>
  </div>
<?php else: ?>
  <div class="dash-card p-0 overflow-hidden">
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
          <tr><th>Part</th><th>Category</th><th>Price</th><th>Location</th><th>Status</th><th>Listed</th><th class="text-end">Actions</th></tr>
        </thead>
        <tbody>
          <?php foreach ($listings as $p): ?>
            <tr>
              <td>
                <div class="d-flex align-items-center gap-2">
                  <img src="<?= e(imageUrl($p['primary_image'])) ?>" alt="" class="listing-table-img">
                  <div>
                    <div class="fw-semibold"><?= e($p['part_name']) ?></div>
                    <?php if ($p['part_number']): ?><div class="text-muted small">Part#: <?= e($p['part_number']) ?></div><?php endif; ?>
                  </div>
                </div>
              </td>
              <td><?= e($p['category_name']) ?></td>
              <td class="fw-semibold text-primary"><?= formatPrice($p['price']) ?></td>
              <td><?= e($p['district']) ?></td>
              <td><?= statusBadge($p['status']) ?></td>
              <td class="text-muted small"><?= timeAgo($p['created_at']) ?></td>
              <td class="text-end">
                <div class="btn-group btn-group-sm">
                  <a href="<?= url('dashboard/parts/'.$p['id'].'/edit') ?>" class="btn btn-outline-primary" title="Edit"><i class="bi bi-pencil"></i></a>
                  <form method="POST" action="<?= url('dashboard/parts/'.$p['id'].'/delete') ?>" class="d-inline" onsubmit="return confirm('Delete?')">
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
