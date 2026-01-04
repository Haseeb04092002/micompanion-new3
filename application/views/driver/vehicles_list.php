<?php include(APPPATH.'views/_partials/header.php'); ?>
<?php $page_title="My Vehicles"; include(APPPATH.'views/_partials/topbar.php'); ?>

<div class="container pb-4">
<a class="btn btn-orange mb-3" href="<?= site_url('driver/driver_vehicles/add') ?>">+ Add Vehicle</a>

<?php foreach($rows as $v): ?>
  <div class="card card-soft p-3 mb-2">
    
    <div class="fw-bold"><?= htmlspecialchars($v['name']) ?></div>
    <div class="small text-muted">
      <?= htmlspecialchars($v['category']) ?> |
      Model: <?= htmlspecialchars($v['model']) ?> |
      Status: <b><?= htmlspecialchars($v['status']) ?></b>
    </div>

    <div class="d-flex gap-2 mt-2 flex-wrap">
      <a class="btn btn-outline-dark btn-sm"
         href="<?= site_url('driver/driver_vehicles/view/'.$v['vehicle_id']) ?>">
        Details
      </a>

      <?php if($v['status'] === 'rejected'): ?>
        <span class="badge bg-danger">Rejected</span>
      <?php elseif($v['status'] === 'pending'): ?>
        <span class="badge bg-warning text-dark">Pending Approval</span>
      <?php else: ?>
        <span class="badge bg-success">Approved</span>
      <?php endif; ?>
    </div>

  </div>
<?php endforeach; ?>

</div>
<?php include(APPPATH.'views/_partials/bottom_driver.php'); ?>
<?php include(APPPATH.'views/_partials/footer.php'); ?>
