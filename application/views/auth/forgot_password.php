<?php include(APPPATH.'views/_partials/header.php'); ?>

<div class="container p-4">
  <h5>Forgot Password</h5>

  <?php if (!empty($error)): ?>
    <div class="alert alert-danger"><?= $error ?></div>
  <?php endif; ?>

  <form method="post">
    <label>Email</label>
    <input type="email" name="email" class="form-control" required>

    <button class="btn btn-primary w-100 mt-3">
      Send OTP
    </button>
  </form>
</div>

<?php include(APPPATH.'views/_partials/footer.php'); ?>