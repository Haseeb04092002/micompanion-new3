<?php include(APPPATH.'views/_partials/header.php'); ?>
<?php $page_title="My Vehicles"; include(APPPATH.'views/_partials/topbar.php'); ?>

<div class="container pb-4">
<a class="btn btn-orange mb-3" href="<?= site_url('driver/driver_vehicles/add') ?>">+ Add Vehicle</a>

<?php foreach($rows as $v): ?>
<div class="card card-soft p-3 mb-2">
 <div class="fw-bold"><?= $v['name'] ?></div>
 <div class="small"><?= $v['category'] ?> | <?= $v['status'] ?></div>
</div>
<?php endforeach; ?>
</div>
<?php include(APPPATH.'views/_partials/bottom_driver.php'); ?>
<?php include(APPPATH.'views/_partials/footer.php'); ?>
