<?php include(APPPATH.'views/_partials/header.php'); ?>

<div class="container p-4">
  <h5>Reset Password</h5>

  <form method="post">
    <label>New Password</label>
    <input type="password" name="password" class="form-control" required>

    <button class="btn btn-primary w-100 mt-3">
      Update Password
    </button>
  </form>
</div>

<?php include(APPPATH.'views/_partials/footer.php'); ?>
