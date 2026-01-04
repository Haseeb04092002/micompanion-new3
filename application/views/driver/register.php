<?php $title="Driver Register"; include(APPPATH.'views/_partials/header.php'); ?>

<div class="container py-4">

  <div class="card card-soft p-3">
    <h5 style="color:var(--orange)">Driver Registration</h5>

    <?php if(!empty($err)): ?>
      <div class="alert alert-danger"><?= $err ?></div>
    <?php endif; ?>

    <form method="post" action="<?= site_url('driver/driver_auth/register') ?>">

      <input class="form-control mb-2"
             name="name"
             placeholder="Full Name"
             required>

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
              name="do_register"
              value="1">
        Create Account
      </button>
    </form>
  </div>

  <div class="text-center mt-3">
    <a href="<?= site_url('driver/driver_auth/login') ?>"
       class="text-decoration-none">
       Already have an account? <b>Login</b>
    </a>
  </div>

</div>

<?php include(APPPATH.'views/_partials/bottom_auth.php'); ?>
<?php include(APPPATH.'views/_partials/footer.php'); ?>
