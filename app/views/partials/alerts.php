<?php $flash = flashGet(); ?>
<?php if (!empty($flash)): ?>
  <div class="container mt-3">
    <?php foreach ($flash as $type => $msg): ?>
      <?php $cls = match($type) { 'success'=>'success','error'=>'danger','info'=>'info', default=>'secondary' }; ?>
      <div class="alert alert-<?= $cls ?> alert-dismissible fade show" role="alert">
        <i class="bi bi-<?= $type==='success'?'check-circle':'info-circle' ?>-fill me-2"></i>
        <?= e($msg) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    <?php endforeach; ?>
  </div>
<?php endif; ?>
