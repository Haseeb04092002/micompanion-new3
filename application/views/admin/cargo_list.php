<?php include(APPPATH.'views/_partials/header.php'); ?>
<?php $page_title="Cargo Requests"; $logout_url="admin/admin_auth/logout"; include(APPPATH.'views/_partials/topbar.php'); ?>
<?php include(APPPATH.'views/_partials/alerts.php'); ?>

<div class="container pb-4">
<?php foreach($rows as $r): ?>
<div class="card card-soft p-3 mb-2">
  <div class="fw-bold">#<?= $r['booking_id'] ?> | <?= $r['city_from'] ?> → <?= $r['city_to'] ?></div>
  <div class="small">Custome555r: <?= $r['customer_name'] ?> | Status: <?= $r['status'] ?></div>

  <div class="mt-2">
    <a class="btn btn-orange btn-sm" href="<?= site_url('admin/admin_cargo/assign/'.$r['booking_id']) ?>">Assign Driver</a>
    <a class="btn btn-outline-dark btn-sm" href="<?= site_url('admin/admin_cargo_bilty/pdf/'.$r['booking_id']) ?>">Bilty PDF</a>
  </div>
</div>
<?php endforeach; ?>
</div>
<?php include(APPPATH.'views/_partials/bottom_admin.php'); ?>
<?php include(APPPATH.'views/_partials/footer.php'); ?>
