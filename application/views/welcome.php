<?php include(APPPATH.'views/_partials/header.php'); ?>

<div class="container py-5 text-center">

  <h2 style="color:var(--orange)" class="mb-4">Cargo Delivery App</h2>

  <p class="text-muted mb-4">
    Fast • Secure • Reliable Logistics
  </p>

  <div class="d-grid gap-3 col-10 mx-auto">
    <a href="<?= site_url('customer/customer_auth/login') ?>" class="btn btn-orange btn-lg">
      I am a Customer
    </a>

    <a href="<?= site_url('driver/driver_auth/login') ?>" class="btn btn-outline-dark btn-lg">
      I am a Driver
    </a>

    <a href="<?= site_url('admin/admin_auth/login') ?>" class="btn btn-outline-secondary btn-lg">
      Admin Login
    </a>
  </div>

</div>

<?php include(APPPATH.'views/_partials/footer.php'); ?>
