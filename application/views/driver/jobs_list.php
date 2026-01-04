<?php include(APPPATH.'views/_partials/header.php'); ?>
<?php $page_title="My Jobs"; include(APPPATH.'views/_partials/topbar.php'); ?>

<div class="container pb-4">
<?php foreach($rows as $r): ?>
<a class="card card-soft p-3 mb-2 d-block text-decoration-none"
   href="<?= site_url('driver/driver_jobs/view/'.$r['booking_id']) ?>">
 <div class="fw-bold">#<?= $r['booking_id'] ?> <?= $r['city_from'] ?> → <?= $r['city_to'] ?></div>
 <div class="small">Status: <?= $r['status'] ?></div>
</a>
<?php endforeach; ?>
</div>
<?php include(APPPATH.'views/_partials/bottom_driver.php'); ?>
<?php include(APPPATH.'views/_partials/footer.php'); ?>
