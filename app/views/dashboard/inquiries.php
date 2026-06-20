<div class="mb-4">
  <h2 class="h4 fw-bold">Inquiries Received</h2>
  <p class="text-muted">Messages from potential buyers about your listings.</p>
</div>

<?php if (empty($inquiries)): ?>
  <div class="dash-card text-center py-5">
    <i class="bi bi-chat-square-dots display-1 text-muted"></i>
    <h3 class="mt-3">No inquiries yet</h3>
    <p class="text-muted">When buyers contact you about your listings, they'll appear here.</p>
  </div>
<?php else: ?>
  <div class="dash-card p-0 overflow-hidden">
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
          <tr><th>From</th><th>Listing</th><th>Type</th><th>Message</th><th>Contact</th><th>Date</th></tr>
        </thead>
        <tbody>
          <?php foreach ($inquiries as $inq): ?>
            <tr>
              <td>
                <div class="fw-semibold"><?= e($inq['sender_name']) ?></div>
              </td>
              <td class="small"><?= e($inq['listing_title'] ?? '—') ?></td>
              <td><span class="badge bg-<?= $inq['listing_type']==='vehicle'?'primary':($inq['listing_type']==='part'?'secondary':'success') ?>"><?= ucfirst($inq['listing_type']) ?></span></td>
              <td class="small" style="max-width:250px"><?= e(truncate($inq['message'],100)) ?></td>
              <td class="small">
                <?php if ($inq['sender_phone']): ?><a href="tel:<?= e($inq['sender_phone']) ?>"><?= e($inq['sender_phone']) ?></a><br><?php endif; ?>
                <?php if ($inq['sender_email']): ?><a href="mailto:<?= e($inq['sender_email']) ?>"><?= e($inq['sender_email']) ?></a><?php endif; ?>
              </td>
              <td class="text-muted small"><?= timeAgo($inq['created_at']) ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
<?php endif; ?>
