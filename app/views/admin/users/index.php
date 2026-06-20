<!-- Admin Users -->
<div class="d-flex justify-content-between align-items-center mb-4">
  <h2 class="h4 fw-bold mb-0">Manage Users</h2>
</div>
<div class="dash-card mb-4">
  <form method="GET" class="d-flex gap-2"><input type="text" name="q" class="form-control" placeholder="Search by name or email..." value="<?= e($search) ?>"><button class="btn btn-primary px-4">Search</button><a href="<?= url('admin/users') ?>" class="btn btn-outline-secondary">Reset</a></form>
</div>
<div class="dash-card p-0 overflow-hidden">
  <div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
      <thead class="table-light"><tr><th>#</th><th>Name</th><th>Email</th><th>Phone</th><th>District</th><th>Status</th><th>Joined</th><th class="text-end">Actions</th></tr></thead>
      <tbody>
        <?php foreach ($list as $u): ?>
          <tr>
            <td class="text-muted small"><?= $u['id'] ?></td>
            <td class="fw-semibold"><?= e($u['name']) ?></td>
            <td><?= e($u['email']) ?></td>
            <td><?= e($u['phone']) ?></td>
            <td><?= e($u['district']) ?></td>
            <td><?= statusBadge($u['status']) ?></td>
            <td class="text-muted small"><?= formatDate($u['created_at']) ?></td>
            <td class="text-end">
              <div class="btn-group btn-group-sm">
                <?php if ($u['status']==='active'): ?>
                  <form method="POST" action="<?= url('admin/users/'.$u['id'].'/suspend') ?>" class="d-inline" onsubmit="return confirm('Suspend this user?')"><?= csrfField() ?><button class="btn btn-outline-warning" title="Suspend"><i class="bi bi-pause-circle"></i></button></form>
                <?php else: ?>
                  <form method="POST" action="<?= url('admin/users/'.$u['id'].'/activate') ?>" class="d-inline"><?= csrfField() ?><button class="btn btn-outline-success" title="Activate"><i class="bi bi-play-circle"></i></button></form>
                <?php endif; ?>
                <form method="POST" action="<?= url('admin/users/'.$u['id'].'/delete') ?>" class="d-inline" onsubmit="return confirm('Permanently delete this user and all their listings?')"><?= csrfField() ?><button class="btn btn-outline-danger" title="Delete"><i class="bi bi-trash"></i></button></form>
              </div>
            </td>
          </tr>
        <?php endforeach; ?>
        <?php if (empty($list)): ?><tr><td colspan="8" class="text-center text-muted py-4">No users found.</td></tr><?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
<?php require APP_ROOT . '/app/views/partials/pagination.php'; ?>
