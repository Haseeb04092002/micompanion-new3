<?php include(APPPATH.'views/_partials/header.php'); ?>
<h5 class="p-3">Driver Commission Payments</h5>

<div class="container">
<?php foreach($records as $r): ?>
  <div class="card mb-2">
    <div class="card-body">
      <div class="fw-bold">Booking #<?= $r['booking_id'] ?></div>
      <div class="small text-muted">
        <?= $r['city_from'] ?> → <?= $r['city_to'] ?><br>
        Cargo: <?= $r['cargo_category'] ?> | Units: <?= $r['units'] ?><br>
        Vehicle: <?= $r['vehicle_type'] ?>
      </div>

      <hr>

      <div>
        <strong><?= $r['driver_name'] ?></strong><br>
        Phone: <?= $r['phone'] ?><br>
        CNIC: <?= $r['cnic_no'] ?>
      </div>

      <hr>

      <?php if ($r['driver_payment_status']=='pending'): ?>
        <a href="<?= site_url('admin/driver_easypaisa/pay/'.$booking_id) ?>"
          class="btn btn-success btn-sm">
          Pay via EasyPaisa
        </a>

        <a href="<?= site_url('admin/driver_payments/pay/'.$r['booking_id']) ?>"
           class="btn btn-success btn-sm">Pay Driver</a>
      <?php else: ?>
        <span class="badge bg-success">Paid</span>
      <?php endif; ?>
    </div>
  </div>
<?php endforeach; ?>
</div>
<?php include(APPPATH.'views/_partials/bottom_admin.php'); ?>
<?php include(APPPATH.'views/_partials/footer.php'); ?>
