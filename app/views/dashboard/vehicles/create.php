<?php $isEdit = isset($listing); ?>
<div class="mb-4">
  <h2 class="h4 fw-bold"><?= $isEdit ? 'Edit Vehicle Listing' : 'Add New Vehicle' ?></h2>
  <p class="text-muted">Fill in all required fields. Your listing will be reviewed before going live.</p>
</div>

<?php if (!empty($errors)): ?>
  <div class="alert alert-danger mb-4"><?php foreach ($errors as $e): ?><div><i class="bi bi-exclamation-circle me-1"></i><?= e($e) ?></div><?php endforeach; ?></div>
<?php endif; ?>

<form method="POST" enctype="multipart/form-data"
      action="<?= $isEdit ? url('dashboard/vehicles/'.$listing['id'].'/edit') : url('dashboard/vehicles/create') ?>">
  <?= csrfField() ?>
  <div class="row g-4">

    <!-- Left: Core Details -->
    <div class="col-lg-8">
      <div class="dash-card mb-4">
        <h5 class="dash-card-title"><i class="bi bi-car-front me-2"></i>Vehicle Details</h5>
        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label fw-semibold">Manufacturer *</label>
            <select name="manufacturer_id" class="form-select" id="formMake" required>
              <option value="">Select Make</option>
              <?php foreach ($manufacturers as $m): ?>
                <option value="<?= $m['id'] ?>" <?= selectedIf($isEdit?$listing['manufacturer_id']:$_POST['manufacturer_id']??'',$m['id']) ?>><?= e($m['name']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="col-md-6">
            <label class="form-label fw-semibold">Model *</label>
            <select name="model_id" class="form-select" id="formModel" required>
              <option value="">Select Model</option>
              <?php foreach ($models??[] as $m): ?>
                <option value="<?= $m['id'] ?>" <?= selectedIf($isEdit?$listing['model_id']:$_POST['model_id']??'',$m['id']) ?>><?= e($m['name']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="col-md-4">
            <label class="form-label fw-semibold">Year *</label>
            <input type="number" name="model_year" class="form-control" min="1960" max="<?= date('Y') ?>" value="<?= e($isEdit?$listing['model_year']:($_POST['model_year']??'')) ?>" required>
          </div>
          <div class="col-md-4">
            <label class="form-label fw-semibold">Mileage (km)</label>
            <input type="number" name="mileage" class="form-control" min="0" value="<?= e($isEdit?$listing['mileage']:($_POST['mileage']??'')) ?>">
          </div>
          <div class="col-md-4">
            <label class="form-label fw-semibold">Price (Rs.) *</label>
            <input type="number" name="price" class="form-control" min="0" step="1000" value="<?= e($isEdit?$listing['price']:($_POST['price']??'')) ?>" required>
          </div>
          <div class="col-md-4">
            <label class="form-label fw-semibold">Fuel Type *</label>
            <select name="fuel_type" class="form-select" required>
              <?php foreach (['Petrol','Diesel','Hybrid','Electric','Other'] as $f): ?>
                <option value="<?= $f ?>" <?= selectedIf($isEdit?$listing['fuel_type']:($_POST['fuel_type']??'Petrol'),$f) ?>><?= $f ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="col-md-4">
            <label class="form-label fw-semibold">Transmission *</label>
            <select name="transmission" class="form-select" required>
              <?php foreach (['Manual','Automatic','CVT'] as $t): ?>
                <option value="<?= $t ?>" <?= selectedIf($isEdit?$listing['transmission']:($_POST['transmission']??'Manual'),$t) ?>><?= $t ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="col-md-4">
            <label class="form-label fw-semibold">Condition *</label>
            <select name="condition_type" class="form-select" required>
              <?php foreach (['Used','New','Reconditioned'] as $c): ?>
                <option value="<?= $c ?>" <?= selectedIf($isEdit?$listing['condition_type']:($_POST['condition_type']??'Used'),$c) ?>><?= $c ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="col-md-6">
            <label class="form-label fw-semibold">Body Type</label>
            <select name="body_type" class="form-select">
              <?php foreach (['Car','Van','SUV','Pickup','Motorcycle','Three-wheeler','Lorry','Bus','Other'] as $b): ?>
                <option value="<?= $b ?>" <?= selectedIf($isEdit?$listing['body_type']:($_POST['body_type']??'Car'),$b) ?>><?= $b ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="col-12">
            <label class="form-label fw-semibold">Description</label>
            <textarea name="description" class="form-control" rows="5" placeholder="Describe the vehicle condition, features, reason for selling..."><?= e($isEdit?$listing['description']:($_POST['description']??'')) ?></textarea>
          </div>
        </div>
      </div>

      <!-- Images -->
      <div class="dash-card mb-4">
        <h5 class="dash-card-title"><i class="bi bi-images me-2"></i>Photos <?= $isEdit?'(Add more)':'' ?></h5>
        <?php if ($isEdit && !empty($images)): ?>
          <div class="d-flex gap-2 flex-wrap mb-3">
            <?php foreach ($images as $img): ?>
              <div class="position-relative">
                <img src="<?= e(imageUrl($img['image_path'])) ?>" class="existing-thumb" alt="">
                <?php if ($img['is_primary']): ?><span class="badge bg-warning position-absolute top-0 start-0" style="font-size:10px">Primary</span><?php endif; ?>
              </div>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
        <input type="file" name="images[]" class="form-control" accept="image/jpeg,image/png,image/webp" multiple id="imgInput">
        <div class="form-text">Up to <?= MAX_IMAGES_PER_LISTING ?> images. Max 5MB each. JPG, PNG, WebP.</div>
        <div id="imgPreview" class="d-flex gap-2 flex-wrap mt-3"></div>
      </div>
    </div>

    <!-- Right: Location & Seller -->
    <div class="col-lg-4">
      <div class="dash-card mb-4">
        <h5 class="dash-card-title"><i class="bi bi-geo-alt me-2"></i>Location</h5>
        <div class="mb-3">
          <label class="form-label fw-semibold">District *</label>
          <select name="district" class="form-select" required>
            <option value="">Select District</option>
            <?php foreach ($districts as $d): ?>
              <option value="<?= e($d['name']) ?>" <?= selectedIf($isEdit?$listing['district']:($_POST['district']??''),$d['name']) ?>><?= e($d['name']) ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="mb-3">
          <label class="form-label fw-semibold">City/Town</label>
          <input type="text" name="city" class="form-control" value="<?= e($isEdit?$listing['city']:($_POST['city']??'')) ?>">
        </div>
      </div>
      <div class="dash-card">
        <h5 class="dash-card-title"><i class="bi bi-person me-2"></i>Seller Details</h5>
        <div class="mb-3">
          <label class="form-label fw-semibold">Your Name *</label>
          <input type="text" name="seller_name" class="form-control" value="<?= e($isEdit?$listing['seller_name']:($_POST['seller_name']??$_SESSION['user_name'])) ?>" required>
        </div>
        <div class="mb-3">
          <label class="form-label fw-semibold">Contact Phone *</label>
          <input type="tel" name="seller_phone" class="form-control" placeholder="0771234567" value="<?= e($isEdit?$listing['seller_phone']:($_POST['seller_phone']??'')) ?>" required>
        </div>
        <div class="form-check mb-3">
          <input class="form-check-input" type="checkbox" name="show_email" id="showEmail" value="1" <?= $isEdit&&$listing['show_email']?'checked':'' ?>>
          <label class="form-check-label" for="showEmail">Show my email on listing</label>
        </div>
        <div class="d-grid gap-2 mt-4">
          <button type="submit" class="btn btn-primary btn-lg"><i class="bi bi-cloud-upload me-2"></i><?= $isEdit?'Update Listing':'Submit Listing' ?></button>
          <a href="<?= url('dashboard/vehicles') ?>" class="btn btn-outline-secondary">Cancel</a>
        </div>
      </div>
    </div>
  </div>
</form>

<script>
// Dependent model
const formMake  = document.getElementById('formMake');
const formModel = document.getElementById('formModel');
if (formMake) {
  formMake.addEventListener('change', function(){
    const id = this.value;
    formModel.innerHTML='<option value="">Select Model</option>';
    if(!id) return;
    fetch('<?= url('ajax/models') ?>?manufacturer_id='+id).then(r=>r.json()).then(ms=>{
      ms.forEach(m=>{const o=document.createElement('option');o.value=m.id;o.textContent=m.name;formModel.appendChild(o);});
    });
  });
}
// Image preview
document.getElementById('imgInput')?.addEventListener('change',function(){
  const p=document.getElementById('imgPreview'); p.innerHTML='';
  [...this.files].forEach(f=>{const r=new FileReader();r.onload=e=>{const i=document.createElement('img');i.src=e.target.result;i.className='preview-thumb';p.appendChild(i);};r.readAsDataURL(f);});
});
</script>
