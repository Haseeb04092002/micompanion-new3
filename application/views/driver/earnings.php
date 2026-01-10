<?php include(APPPATH.'views/_partials/header.php'); ?>

<div class="container p-3">
<h6>Your Earnings</h6>

<?php foreach($records as $r): ?>
<div class="card mb-2">
  <div class="card-body">
    Booking #<?= $r['booking_id'] ?><br>
    Amount: Rs <?= $r['driver_commission'] ?><br>
    Paid At: <?= date('d-M-Y',strtotime($r['driver_paid_at'])) ?>
  </div>
</div>
<?php endforeach; ?>
</div>


<?php include(APPPATH.'views/_partials/bottom_driver.php'); ?>
<?php include(APPPATH.'views/_partials/footer.php'); ?>
