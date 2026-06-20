<?php $isEdit = isset($service); ?>
<div class="mb-4">
  <h2 class="h4 fw-bold"><?= $isEdit?'Edit Service':'Add New Service' ?></h2>
</div>
<form method="POST" action="<?= $isEdit?url('dashboard/services/'.$service['id'].'/edit'):url('dashboard/services/create') ?>">
  <?= csrfField() ?>
  <div class="dash-card" style="max-width:700px">
    <div class="mb-3">
      <label class="form-label fw-semibold">Service Category *</label>
      <select name="category_id" class="form-select" required>
        <option value="">Select Category</option>
        <?php foreach ($categories as $c): ?><option value="<?= $c['id'] ?>" <?= selectedIf($isEdit?$service['category_id']:($_POST['category_id']??''),$c['id']) ?>><?= e($c['name']) ?></option><?php endforeach; ?>
      </select>
    </div>
    <div class="mb-3"><label class="form-label fw-semibold">Service Name *</label><input type="text" name="name" class="form-control" value="<?= e($isEdit?$service['name']:($_POST['name']??'')) ?>" required></div>
    <div class="mb-3"><label class="form-label fw-semibold">Base Price (Rs.) *</label><input type="number" name="base_price" class="form-control" min="0" step="100" value="<?= e($isEdit?$service['base_price']:($_POST['base_price']??'')) ?>" required></div>
    <div class="mb-4"><label class="form-label fw-semibold">Description</label><textarea name="description" class="form-control" rows="3"><?= e($isEdit?$service['description']:($_POST['description']??'')) ?></textarea></div>

    <?php if ($isEdit && !empty($addons)): ?>
      <div class="mb-4">
        <label class="form-label fw-semibold">Current Add-ons</label>
        <?php foreach ($addons as $a): ?>
          <div class="d-flex justify-content-between align-items-center p-2 border rounded mb-2">
            <span><?= e($a['addon_name']) ?> — <?= formatPrice($a['addon_price']) ?></span>
            <form method="POST" action="<?= url('dashboard/addons/'.$a['id'].'/delete') ?>" class="d-inline" onsubmit="return confirm('Remove?')"><?= csrfField() ?><button class="btn btn-sm btn-danger"><i class="bi bi-x"></i></button></form>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <div class="d-flex gap-2">
      <button type="submit" class="btn btn-primary px-4"><?= $isEdit?'Update Service':'Add Service' ?></button>
      <a href="<?= url('dashboard/services') ?>" class="btn btn-outline-secondary">Cancel</a>
    </div>
  </div>
</form>
