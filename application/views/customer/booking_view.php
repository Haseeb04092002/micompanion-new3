<?php include(APPPATH.'views/_partials/header.php'); ?>
<?php $page_title="Booking Details"; include(APPPATH.'views/_partials/topbar.php'); ?>
<?php include(APPPATH.'views/_partials/alerts.php'); ?>

<div class="container pb-4">
  <div class="px-2">

    <!-- BASIC INFO -->
    <div class="card card-soft p-3 mb-3">
      <h5 style="color:var(--orange)">Booking Information</h5>

      <div><b>Booking ID:</b> #<?= (int)$booking['booking_id'] ?></div>
      <div>
        <b>Status:</b>
        <span class="badge bg-secondary"><?= htmlspecialchars($booking['status']) ?></span>
      </div>
      <div>
        <b>Requested On:</b>
        <?= date('d M Y, h:i A', strtotime($booking['created_at'])) ?>
      </div>
    </div>

    <!-- LOCATIONS -->
    <div class="card card-soft p-3 mb-3">
      <h5 style="color:var(--orange)">Locations</h5>

      <div class="mb-2">
        <b>Pickup Location</b><br>
        <?= htmlspecialchars($booking['loc_from']) ?><br>
        <span class="small text-muted"><?= htmlspecialchars($booking['city_from']) ?></span>
      </div>

      <div>
        <b>Drop-off Location</b><br>
        <?= htmlspecialchars($booking['loc_to']) ?><br>
        <span class="small text-muted"><?= htmlspecialchars($booking['city_to']) ?></span>
      </div>
    </div>

    <!-- CARGO DETAILS -->
    <div class="card card-soft p-3 mb-3">
      <h5 style="color:var(--orange)">Cargo Details</h5>

      <div><b>Category:</b> <?= htmlspecialchars($booking['cargo_category']) ?></div>
      <div><b>Units:</b> <?= (int)$booking['units'] ?></div>
      <div><b>Vehicle Type:</b> <?= htmlspecialchars($booking['vehicle_type']) ?></div>
    </div>

    <!-- DRIVER INFO (IF ASSIGNED) -->
    <?php if(!empty($booking['driver_name'])): ?>
      <div class="card card-soft p-3 mb-3">
        <h5 style="color:var(--orange)">Assigned Driver</h5>
        <div><b>Name:</b> <?= htmlspecialchars($booking['driver_name']) ?></div>
        <div><b>Phone:</b> <?= htmlspecialchars($booking['driver_phone']) ?></div>
      </div>
    <?php endif; ?>

    <!-- ACTION -->
    <div class="card card-soft p-3">
      <a class="btn btn-outline-dark w-100"
         href="<?= site_url('customer/customer_booking/listing') ?>">
        Back to My Bookings
      </a>
    </div>

  </div>
</div>

<?php include(APPPATH.'views/_partials/bottom_customer.php'); ?>
<?php include(APPPATH.'views/_partials/footer.php'); ?>
