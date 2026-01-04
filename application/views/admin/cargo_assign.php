<?php include(APPPATH.'views/_partials/header.php'); ?>
<?php $page_title="Assign Driver"; include(APPPATH.'views/_partials/topbar.php'); ?>

<div class="container pb-4">
<div class="card card-soft p-3">
<form method="post">
  <div class="mb-2">
    <label>Driver + Vehicle</label>
    <select class="form-select" name="driver_id" required>
      <option value="">Select</option>
      <?php foreach($vehicles as $v): ?>
        <option value="<?= $v['driver_id'] ?>"><?= $v['driver_name'] ?> (<?= $v['category'] ?>)</option>
      <?php endforeach; ?>
    </select>
  </div>

  <div class="mb-3">
    <label>Vehicle</label>
    <select class="form-select" name="vehicle_id" required>
      <?php foreach($vehicles as $v): ?>
        <option value="<?= $v['vehicle_id'] ?>"><?= $v['name'] ?> (<?= $v['model'] ?>)</option>
      <?php endforeach; ?>
    </select>
  </div>

  <button class="btn btn-orange w-100" name="do_assign" value="1">Assign</button>
</form>
</div>
</div>
<?php include(APPPATH.'views/_partials/bottom_admin.php'); ?>
<?php include(APPPATH.'views/_partials/footer.php'); ?>
