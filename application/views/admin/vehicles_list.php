<?php include(APPPATH.'views/_partials/header.php'); ?>
<?php $page_title="Vehicles"; $logout_url="admin/admin_auth/logout"; include(APPPATH.'views/_partials/topbar.php'); ?>
<?php include(APPPATH.'views/_partials/alerts.php'); ?>

<div class="container pb-4">
<?php foreach($rows as $v): ?>
<div class="card card-soft p-3 mb-3">
  <div class="fw-bold"><?= $v['category'] ?> - <?= $v['name'] ?></div>
  <div class="small text-muted">Driver: <?= $v['driver_name'] ?> | Status: <?= $v['status'] ?></div>

  <div class="d-flex gap-2 mt-2">
    <img src="<?= base_url('uploads/vehicles/'.$v['front_img']) ?>" width="70">
    <img src="<?= base_url('uploads/vehicles/'.$v['back_img']) ?>" width="70">
  </div>

  <div class="mt-2">
    <a class="btn btn-success btn-sm" href="<?= site_url('admin/admin_vehicles/approve/'.$v['vehicle_id']) ?>">Approve</a>
    <a class="btn btn-danger btn-sm" href="<?= site_url('admin/admin_vehicles/reject/'.$v['vehicle_id']) ?>">Reject</a>
  </div>
</div>
<?php endforeach; ?>
</div>
<?php include(APPPATH.'views/_partials/bottom_admin.php'); ?>
<?php include(APPPATH.'views/_partials/footer.php'); ?>
