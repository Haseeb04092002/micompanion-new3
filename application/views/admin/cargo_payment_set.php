<?php include(APPPATH.'views/_partials/header.php'); ?>
<?php $page_title="Payment Setup"; include(APPPATH.'views/_partials/topbar.php'); ?>

<div class="card">
  <div class="card-body">
    <h6>Delivered Cargo – Payment Setup</h6>

    <ul class="small text-muted">
      <li>Pickup: <?= $cargo['pickup_location'] ?></li>
      <li>Drop: <?= $cargo['drop_location'] ?></li>
      <li>Cargo Type: <?= $cargo['cargo_type'] ?></li>
      <li>Units: <?= $cargo['units'] ?></li>
      <li>Vehicle: <?= $cargo['vehicle_type'] ?></li>
    </ul>

    <form method="post">
      <label class="form-label">Payment Amount</label>
      <input type="number" step="0.01" name="payment_amount"
             class="form-control" required>

      <button class="btn btn-primary mt-2">
        Post Amount
      </button>
    </form>
  </div>
</div>


<?php include(APPPATH.'views/_partials/footer.php'); ?>
