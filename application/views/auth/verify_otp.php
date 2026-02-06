<?php include(APPPATH.'views/_partials/header.php'); ?>

<div class="container p-4">
  <h5>Verify OTP</h5>

  <?php if (!empty($error)): ?>
    <div class="alert alert-danger"><?= $error ?></div>
  <?php endif; ?>

  <form method="post">
    <label>Enter OTP</label>
    <input type="text" name="otp" class="form-control" required>

    <button class="btn btn-success w-100 mt-3">
      Verify
    </button>
  </form>
</div>

<?php include(APPPATH.'views/_partials/footer.php'); ?>
