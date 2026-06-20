<h2 class="h4 fw-bold mb-4">Inquiries & Messages</h2>
<div class="dash-card mb-3">
  <div class="d-flex gap-2">
    <?php foreach (['' => 'All', 'vehicle' => 'Vehicles', 'part' => 'Parts', 'service' => 'Services', 'contact' => 'Contact'] as $val => $label): ?>
      <a href="?type=<?= $val ?>" class="btn btn-sm <?= $type===$val?'btn-primary':'btn-outline-secondary' ?>"><?= $label ?></a>
    <?php endforeach; ?>
  </div>
</div>
<div class="dash-card p-0 overflow-hidden">
  <div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
      <thead class="table-light"><tr><th>From</th><th>Contact</th><th>About</th><th>Type</th><th>Message</th><th>Date</th><th class="text-end">Actions</th></tr></thead>
      <tbody>
        <?php foreach ($list as $inq): ?>
          <tr class="<?= !$inq['is_read']?'table-warning-subtle fw-semibold':'' ?>">
            <td><?= e($inq['sender_name']) ?></td>
            <td class="small"><div><?= e($inq['sender_phone']) ?></div><div><?= e($inq['sender_email']) ?></div></td>
            <td class="small"><?= e($inq['listing_title']??'General Contact') ?></td>
            <td><span class="badge bg-secondary"><?= ucfirst($inq['listing_type']) ?></span></td>
            <td style="max-width:200px"><span class="small"><?= e(truncate($inq['message'],100)) ?></span></td>
            <td class="text-muted small"><?= timeAgo($inq['created_at']) ?></td>
            <td class="text-end">
              <form method="POST" action="<?= url('admin/inquiries/'.$inq['id'].'/delete') ?>" onsubmit="return confirm('Delete inquiry?')"><?= csrfField() ?><button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button></form>
            </td>
          </tr>
        <?php endforeach; ?>
        <?php if (empty($list)): ?><tr><td colspan="7" class="text-center py-4 text-muted">No inquiries.</td></tr><?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
<?php require APP_ROOT . '/app/views/partials/pagination.php'; ?>
