<?php $title = "Driver Login";
include(APPPATH . 'views/_partials/header.php'); ?>

<div class="container py-4">

  <div class="card card-soft p-3">
    <h5 style="color:var(--orange)">Driver Login</h5>

    <?php if (!empty($err)): ?>
      <div class="alert alert-danger"><?= $err ?></div>
    <?php endif; ?>

    <form method="post" action="<?= site_url('driver/driver_auth/login') ?>">
      <input class="form-control mb-2"
        name="email"
        type="email"
        placeholder="Email"
        required>

      <input class="form-control mb-3"
        name="password"
        type="password"
        placeholder="Password"
        required>

      <button class="btn btn-orange w-100"
        name="do_login"
        value="1">
        Login
      </button>
    </form>
  </div>

  <div class="text-center mt-3">
    <a href="<?= site_url('driver/driver_auth/register') ?>"
      class="text-decoration-none">
      Don’t have an account? <b>Register</b>
    </a>
  </div>
  <div class="text-center mt-2">
    <a href="<?= site_url('auth_forgot') ?>" class="small text-decoration-none">
      Forgot Password?
    </a>
  </div>

</div>

<?php include(APPPATH . 'views/_partials/bottom_auth.php'); ?>
<?php include(APPPATH . 'views/_partials/footer.php'); ?>