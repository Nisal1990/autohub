<?php $isEdit = isset($listing); ?>
<div class="mb-4">
  <h2 class="h4 fw-bold"><?= $isEdit ? 'Edit Part Listing' : 'Add Spare Part' ?></h2>
  <p class="text-muted">Listing will be reviewed before appearing on the site.</p>
</div>
<?php if (!empty($errors)): ?><div class="alert alert-danger"><?php foreach ($errors as $e): ?><div><?= e($e) ?></div><?php endforeach; ?></div><?php endif; ?>

<form method="POST" enctype="multipart/form-data"
      action="<?= $isEdit ? url('dashboard/parts/'.$listing['id'].'/edit') : url('dashboard/parts/create') ?>">
  <?= csrfField() ?>
  <div class="row g-4">
    <div class="col-lg-8">
      <div class="dash-card mb-4">
        <h5 class="dash-card-title"><i class="bi bi-tools me-2"></i>Part Details</h5>
        <div class="row g-3">
          <div class="col-12"><label class="form-label fw-semibold">Part Name *</label><input type="text" name="part_name" class="form-control" value="<?= e($isEdit?$listing['part_name']:($_POST['part_name']??'')) ?>" required></div>
          <div class="col-md-6"><label class="form-label fw-semibold">Part Number</label><input type="text" name="part_number" class="form-control" placeholder="OEM part#" value="<?= e($isEdit?$listing['part_number']:($_POST['part_number']??'')) ?>"></div>
          <div class="col-md-6">
            <label class="form-label fw-semibold">Category *</label>
            <select name="category_id" class="form-select" required>
              <option value="">Select Category</option>
              <?php foreach ($categories as $c): ?><option value="<?= $c['id'] ?>" <?= selectedIf($isEdit?$listing['category_id']:($_POST['category_id']??''),$c['id']) ?>><?= e($c['name']) ?></option><?php endforeach; ?>
            </select>
          </div>
          <div class="col-md-4">
            <label class="form-label fw-semibold">Compatible Make</label>
            <select name="compatible_make" class="form-select">
              <option value="">Any / All</option>
              <?php foreach ($manufacturers as $m): ?><option value="<?= e($m['name']) ?>" <?= selectedIf($isEdit?$listing['compatible_make']:($_POST['compatible_make']??''),$m['name']) ?>><?= e($m['name']) ?></option><?php endforeach; ?>
            </select>
          </div>
          <div class="col-md-4"><label class="form-label fw-semibold">Compatible Model</label><input type="text" name="compatible_model" class="form-control" placeholder="e.g. Corolla" value="<?= e($isEdit?$listing['compatible_model']:($_POST['compatible_model']??'')) ?>"></div>
          <div class="col-md-2"><label class="form-label fw-semibold">Year From</label><input type="number" name="compatible_year_from" class="form-control" placeholder="2005" value="<?= e($isEdit?$listing['compatible_year_from']:($_POST['compatible_year_from']??'')) ?>"></div>
          <div class="col-md-2"><label class="form-label fw-semibold">Year To</label><input type="number" name="compatible_year_to" class="form-control" placeholder="2020" value="<?= e($isEdit?$listing['compatible_year_to']:($_POST['compatible_year_to']??'')) ?>"></div>
          <div class="col-md-4"><label class="form-label fw-semibold">Price (Rs.) *</label><input type="number" name="price" class="form-control" min="0" value="<?= e($isEdit?$listing['price']:($_POST['price']??'')) ?>" required></div>
          <div class="col-md-4">
            <label class="form-label fw-semibold">Condition *</label>
            <select name="condition_type" class="form-select">
              <?php foreach (['New','Used','Reconditioned'] as $c): ?><option value="<?= $c ?>" <?= selectedIf($isEdit?$listing['condition_type']:($_POST['condition_type']??'New'),$c) ?>><?= $c ?></option><?php endforeach; ?>
            </select>
          </div>
          <div class="col-md-4"><label class="form-label fw-semibold">Stock Qty</label><input type="number" name="stock_qty" class="form-control" min="1" value="<?= e($isEdit?$listing['stock_qty']:($_POST['stock_qty']??'')) ?>"></div>
          <div class="col-12"><label class="form-label fw-semibold">Description</label><textarea name="description" class="form-control" rows="4"><?= e($isEdit?$listing['description']:($_POST['description']??'')) ?></textarea></div>
        </div>
      </div>
      <div class="dash-card">
        <h5 class="dash-card-title"><i class="bi bi-images me-2"></i>Photos</h5>
        <?php if ($isEdit && !empty($images)): ?>
          <div class="d-flex gap-2 flex-wrap mb-3"><?php foreach ($images as $img): ?><img src="<?= e(imageUrl($img['image_path'])) ?>" class="existing-thumb" alt=""><?php endforeach; ?></div>
        <?php endif; ?>
        <input type="file" name="images[]" class="form-control" accept="image/*" multiple id="imgInputParts">
        <div id="imgPreviewParts" class="d-flex gap-2 flex-wrap mt-2"></div>
      </div>
    </div>
    <div class="col-lg-4">
      <div class="dash-card mb-4">
        <h5 class="dash-card-title"><i class="bi bi-geo-alt me-2"></i>Location</h5>
        <div class="mb-3"><label class="form-label fw-semibold">District *</label>
          <select name="district" class="form-select" required>
            <option value="">Select District</option>
            <?php foreach ($districts as $d): ?><option value="<?= e($d['name']) ?>" <?= selectedIf($isEdit?$listing['district']:($_POST['district']??''),$d['name']) ?>><?= e($d['name']) ?></option><?php endforeach; ?>
          </select>
        </div>
        <div class="mb-3"><label class="form-label fw-semibold">City</label><input type="text" name="city" class="form-control" value="<?= e($isEdit?$listing['city']:($_POST['city']??'')) ?>"></div>
      </div>
      <div class="dash-card">
        <h5 class="dash-card-title"><i class="bi bi-person me-2"></i>Seller Info</h5>
        <div class="mb-3"><label class="form-label fw-semibold">Name *</label><input type="text" name="seller_name" class="form-control" value="<?= e($isEdit?$listing['seller_name']:($_SESSION['user_name']??'')) ?>" required></div>
        <div class="mb-4"><label class="form-label fw-semibold">Phone *</label><input type="tel" name="seller_phone" class="form-control" value="<?= e($isEdit?$listing['seller_phone']:($_POST['seller_phone']??'')) ?>" required></div>
        <div class="d-grid gap-2">
          <button type="submit" class="btn btn-primary btn-lg"><i class="bi bi-cloud-upload me-2"></i><?= $isEdit?'Update':'Submit' ?></button>
          <a href="<?= url('dashboard/parts') ?>" class="btn btn-outline-secondary">Cancel</a>
        </div>
      </div>
    </div>
  </div>
</form>
<script>
document.getElementById('imgInputParts')?.addEventListener('change',function(){
  const p=document.getElementById('imgPreviewParts');p.innerHTML='';
  [...this.files].forEach(f=>{const r=new FileReader();r.onload=e=>{const i=document.createElement('img');i.src=e.target.result;i.className='preview-thumb';p.appendChild(i);};r.readAsDataURL(f);});
});
</script>
