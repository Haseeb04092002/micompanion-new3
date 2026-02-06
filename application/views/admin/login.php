<?php $title = "Admin Login";
include(APPPATH . 'views/_partials/header.php'); ?>
<div class="container py-5">
  <div class="card card-soft p-4 mx-auto" style="max-width:420px;">
    <h4 class="mb-3" style="color:var(--orange)">Admin Login</h4>

    <?php if (!empty($err)): ?>
      <div class="alert alert-danger"><?= $err ?></div>
    <?php endif; ?>
    <form method="post">
      <div class="mb-2">
        <label class="form-label">Email</label>
        <input name="email" type="email" class="form-control" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Password</label>
        <input name="password" type="password" class="form-control" required>
      </div>
      <button class="btn btn-orange w-100" name="do_login" value="1">Login</button>
    </form>
    

    <div class="text-center mt-2">
      <a href="<?= site_url('auth_forgot') ?>" class="small text-decoration-none">
        Forgot Password?
      </a>
    </div>
  </div>
</div>
<?php include(APPPATH . 'views/_partials/bottom_auth.php'); ?>
<?php include(APPPATH . 'views/_partials/footer.php'); ?>