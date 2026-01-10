<?php include(APPPATH.'views/_partials/header.php'); ?>

<div class="container p-3">
<form method="post" enctype="multipart/form-data">

  <label>Commission Amount</label>
  <input type="number" step="0.01" name="driver_commission"
         class="form-control" required>

  <hr>

  <div class="form-check">
    <input class="form-check-input" type="radio" name="payment_method" value="easypaisa" checked>
    <label class="form-check-label">Easypaisa</label>
  </div>

  <input type="text" name="ep_txn" class="form-control mt-1"
         placeholder="Transaction ID">

  <hr>

  <div class="form-check">
    <input class="form-check-input" type="radio" name="payment_method" value="manual">
    <label class="form-check-label">Manual (Upload Proof)</label>
  </div>

  <input type="file" name="proof" class="form-control mt-1">

  <button class="btn btn-primary w-100 mt-3">
    Pay Driver
  </button>
</form>
</div>
<?php include(APPPATH.'views/_partials/bottom_admin.php'); ?>
<?php include(APPPATH.'views/_partials/footer.php'); ?>
