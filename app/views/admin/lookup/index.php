<h2 class="h4 fw-bold mb-4">Manage Lookup Data</h2>
<ul class="nav nav-tabs mb-4" id="lookupTabs">
  <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#manufacturers">Makes</a></li>
  <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#models">Models</a></li>
  <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#part-cats">Part Categories</a></li>
  <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#service-cats">Service Categories</a></li>
  <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#districts">Districts</a></li>
  <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#cities">Cities</a></li>
</ul>

<div class="tab-content">

  <!-- Manufacturers -->
  <div class="tab-pane fade show active" id="manufacturers">
    <div class="row g-4">
      <div class="col-md-4">
        <div class="dash-card"><h6 class="fw-bold mb-3">Add Manufacturer</h6>
          <form method="POST" action="<?= url('admin/lookup/manufacturer') ?>"><?= csrfField() ?>
            <div class="input-group"><input type="text" name="name" class="form-control" placeholder="e.g. Toyota" required><button class="btn btn-primary">Add</button></div>
          </form>
        </div>
      </div>
      <div class="col-md-8"><div class="dash-card"><h6 class="fw-bold mb-3">Manufacturers (<?= count($manufacturers) ?>)</h6>
        <div class="row g-2">
          <?php foreach ($manufacturers as $m): ?>
            <div class="col-6 col-md-4"><div class="d-flex justify-content-between align-items-center border rounded p-2"><span><?= e($m['name']) ?></span>
              <form method="POST" action="<?= url('admin/lookup/manufacturer/'.$m['id'].'/delete') ?>" onsubmit="return confirm('Delete?')"><?= csrfField() ?><button class="btn btn-link p-0 text-danger"><i class="bi bi-x-circle"></i></button></form>
            </div></div>
          <?php endforeach; ?>
        </div>
      </div></div>
    </div>
  </div>

  <!-- Models -->
  <div class="tab-pane fade" id="models">
    <div class="row g-4">
      <div class="col-md-4"><div class="dash-card"><h6 class="fw-bold mb-3">Add Model</h6>
        <form method="POST" action="<?= url('admin/lookup/model') ?>"><?= csrfField() ?>
          <div class="mb-2"><select name="manufacturer_id" class="form-select" required><option value="">Select Make</option><?php foreach ($manufacturers as $m): ?><option value="<?= $m['id'] ?>"><?= e($m['name']) ?></option><?php endforeach; ?></select></div>
          <div class="input-group"><input type="text" name="name" class="form-control" placeholder="Model name" required><button class="btn btn-primary">Add</button></div>
        </form>
      </div></div>
      <div class="col-md-8"><div class="dash-card"><h6 class="fw-bold mb-3">Models (<?= count($models) ?>)</h6>
        <div class="table-responsive"><table class="table table-sm"><tbody>
          <?php foreach ($models as $m): ?>
            <tr><td class="text-muted"><?= e($m['manufacturer_name']) ?></td><td><?= e($m['name']) ?></td><td class="text-end"><form method="POST" action="<?= url('admin/lookup/model/'.$m['id'].'/delete') ?>" onsubmit="return confirm('Delete?')"><?= csrfField() ?><button class="btn btn-link p-0 text-danger btn-sm"><i class="bi bi-x-circle"></i></button></form></td></tr>
          <?php endforeach; ?>
        </tbody></table></div>
      </div></div>
    </div>
  </div>

  <!-- Part Categories -->
  <div class="tab-pane fade" id="part-cats">
    <div class="row g-4">
      <div class="col-md-4"><div class="dash-card"><h6 class="fw-bold mb-3">Add Part Category</h6>
        <form method="POST" action="<?= url('admin/lookup/part-category') ?>"><?= csrfField() ?>
          <div class="input-group"><input type="text" name="name" class="form-control" placeholder="Category name" required><button class="btn btn-primary">Add</button></div>
        </form>
      </div></div>
      <div class="col-md-8"><div class="dash-card"><h6 class="fw-bold mb-3">Categories</h6>
        <div class="row g-2"><?php foreach ($partCategories as $c): ?><div class="col-6 col-md-4"><div class="d-flex justify-content-between align-items-center border rounded p-2"><span><?= e($c['name']) ?></span><form method="POST" action="<?= url('admin/lookup/part-category/'.$c['id'].'/delete') ?>" onsubmit="return confirm('Delete?')"><?= csrfField() ?><button class="btn btn-link p-0 text-danger"><i class="bi bi-x-circle"></i></button></form></div></div><?php endforeach; ?></div>
      </div></div>
    </div>
  </div>

  <!-- Service Categories -->
  <div class="tab-pane fade" id="service-cats">
    <div class="row g-4">
      <div class="col-md-4"><div class="dash-card"><h6 class="fw-bold mb-3">Add Service Category</h6>
        <form method="POST" action="<?= url('admin/lookup/service-category') ?>"><?= csrfField() ?>
          <div class="input-group"><input type="text" name="name" class="form-control" placeholder="Category name" required><button class="btn btn-primary">Add</button></div>
        </form>
      </div></div>
      <div class="col-md-8"><div class="dash-card"><h6 class="fw-bold mb-3">Categories</h6>
        <div class="row g-2"><?php foreach ($serviceCategories as $c): ?><div class="col-6 col-md-4"><div class="d-flex justify-content-between align-items-center border rounded p-2"><span><?= e($c['name']) ?></span><form method="POST" action="<?= url('admin/lookup/service-category/'.$c['id'].'/delete') ?>" onsubmit="return confirm('Delete?')"><?= csrfField() ?><button class="btn btn-link p-0 text-danger"><i class="bi bi-x-circle"></i></button></form></div></div><?php endforeach; ?></div>
      </div></div>
    </div>
  </div>

  <!-- Districts -->
  <div class="tab-pane fade" id="districts">
    <div class="row g-4">
      <div class="col-md-4"><div class="dash-card"><h6 class="fw-bold mb-3">Add District</h6>
        <form method="POST" action="<?= url('admin/lookup/district') ?>"><?= csrfField() ?>
          <div class="input-group"><input type="text" name="name" class="form-control" placeholder="District name" required><button class="btn btn-primary">Add</button></div>
        </form>
      </div></div>
      <div class="col-md-8"><div class="dash-card"><h6 class="fw-bold mb-3">Districts (25)</h6>
        <div class="row g-2"><?php foreach ($districts as $d): ?><div class="col-6 col-md-4"><div class="border rounded p-2 text-center small"><?= e($d['name']) ?></div></div><?php endforeach; ?></div>
      </div></div>
    </div>
  </div>

  <!-- Cities -->
  <div class="tab-pane fade" id="cities">
    <div class="row g-4">
      <div class="col-md-4"><div class="dash-card"><h6 class="fw-bold mb-3">Add City</h6>
        <form method="POST" action="<?= url('admin/lookup/city') ?>"><?= csrfField() ?>
          <div class="mb-2"><select name="district_id" class="form-select" required><option value="">Select District</option><?php foreach ($districts as $d): ?><option value="<?= $d['id'] ?>"><?= e($d['name']) ?></option><?php endforeach; ?></select></div>
          <div class="input-group"><input type="text" name="name" class="form-control" placeholder="City/Town name" required><button class="btn btn-primary">Add</button></div>
        </form>
      </div></div>
      <div class="col-md-8"><div class="dash-card"><h6 class="fw-bold mb-3">Cities (<?= count($cities) ?>)</h6>
        <div class="table-responsive" style="max-height:400px;overflow-y:auto"><table class="table table-sm"><tbody>
          <?php foreach ($cities as $c): ?><tr><td class="text-muted"><?= e($c['district_name']) ?></td><td><?= e($c['name']) ?></td><td class="text-end"><form method="POST" action="<?= url('admin/lookup/city/'.$c['id'].'/delete') ?>" onsubmit="return confirm('Delete?')"><?= csrfField() ?><button class="btn btn-link btn-sm p-0 text-danger"><i class="bi bi-x-circle"></i></button></form></td></tr><?php endforeach; ?>
        </tbody></table></div>
      </div></div>
    </div>
  </div>

</div>
