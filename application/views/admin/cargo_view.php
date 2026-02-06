<?php include(APPPATH.'views/_partials/header.php'); ?>
<?php $page_title="Cargo Details"; $logout_url="admin/admin_auth/logout"; include(APPPATH.'views/_partials/topbar.php'); ?>

<div class="container pb-4">
  <div class="px-2">

    <!-- BASIC INFO -->
    <div class="card card-soft p-3 mb-3">
      <h5 style="color:var(--orange)">Cargo Information</h5>

      <div><b>Cargo ID:</b> #<?= (int)$cargo['booking_id'] ?></div>
      <div><b>Bilty ID:</b> <?= htmlspecialchars($cargo['bilty_code']) ?></div>
      <div>
        <b>Status:</b>
        <span class="badge bg-secondary"><?= htmlspecialchars($cargo['status']) ?></span>
      </div>
      <div>
        <b>Requested On:</b>
        <?= date('d M Y, h:i A', strtotime($cargo['created_at'])) ?>
      </div>
    </div>

    <!-- CUSTOMER -->
    <div class="card card-soft p-3 mb-3">
      <h5 style="color:var(--orange)">Customer Details</h5>
      <div><b>Name:</b> <?= htmlspecialchars($cargo['customer_name']) ?></div>
      <div><b>Phone:</b> <?= htmlspecialchars($cargo['customer_phone']) ?></div>
    </div>

    <!-- LOCATIONS -->
    <div class="card card-soft p-3 mb-3">
      <h5 style="color:var(--orange)">Locations</h5>

      <div class="mb-2">
        <b>Pickup Location</b><br>
        <?= htmlspecialchars($cargo['loc_from']) ?><br>
        <span class="small text-muted"><?= htmlspecialchars($cargo['city_from']) ?></span>
      </div>

      <div>
        <b>Drop-off Location</b><br>
        <?= htmlspecialchars($cargo['loc_to']) ?><br>
        <span class="small text-muted"><?= htmlspecialchars($cargo['city_to']) ?></span>
      </div>
    </div>

    <!-- CARGO DETAILS -->
    <div class="card card-soft p-3 mb-3">
      <h5 style="color:var(--orange)">Cargo Details</h5>
      <div><b>Category:</b> <?= htmlspecialchars($cargo['cargo_category']) ?></div>
      <div><b>Units:</b> <?= (int)$cargo['units'] ?></div>
      <div><b>Vehicle Type:</b> <?= htmlspecialchars($cargo['vehicle_type']) ?></div>
    </div>

    <!-- DRIVER -->
    <?php if(!empty($cargo['driver_name'])): ?>
      <div class="card card-soft p-3 mb-3">
        <h5 style="color:var(--orange)">Assigned Driver</h5>
        <div><b>Name:</b> <?= htmlspecialchars($cargo['driver_name']) ?></div>
        <div><b>Phone:</b> <?= htmlspecialchars($cargo['driver_phone']) ?></div>
        <div><b>Vehicle:</b> <?= htmlspecialchars($cargo['vehicle_name']) ?></div>
      </div>
    <?php endif; ?>

    <!-- ACTIONS -->
    <div class="card card-soft p-3">
      <div class="d-flex gap-2 flex-wrap">
        <a class="btn btn-orange w-100"
           href="<?= site_url('admin/admin_cargo/assign/'.$cargo['booking_id']) ?>">
          Assign / Change Driver
        </a>

        <a class="btn btn-outline-dark w-100"
           href="<?= site_url('admin/admin_cargo_bilty/pdf/'.$cargo['booking_id']) ?>">
          Download Bilty PDF
        </a>

        <a class="btn btn-outline-dark w-100"
           href="<?= site_url('admin/admin_cargo') ?>">
          Back to Cargo Requests
        </a>
      </div>
    </div>

  </div>
</div>

<?php include(APPPATH.'views/_partials/bottom_admin.php'); ?>
<?php include(APPPATH.'views/_partials/footer.php'); ?>
