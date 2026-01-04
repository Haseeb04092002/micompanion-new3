<?php $title="Customer Dashboard"; include(APPPATH.'views/_partials/header.php'); ?>
<?php $page_title="Customer Dashboard"; $logout_url="customer/customer_auth/logout"; include(APPPATH.'views/_partials/topbar.php'); ?>
<?php include(APPPATH.'views/_partials/alerts.php'); ?>

<div class="container pb-4">
  <div class="px-2">

    <!-- VERIFICATION ALERT -->
    <?php if($need_verify): ?>
      <div class="alert alert-warning">
        <b>You must enter your documents to be verified.</b>
        <div class="mt-2">
          <a class="btn btn-orange" href="<?= site_url('customer/customer_profile/verify') ?>">
            Upload Documents
          </a>
        </div>
      </div>
    <?php endif; ?>

    <!-- ACTION BUTTONS -->
    <div class="card card-soft p-3 mb-3">
      <div class="d-flex flex-wrap gap-2">
        <a class="btn btn-orange" href="<?= site_url('customer/customer_booking/create') ?>">
          New Booking
        </a>

        <a class="btn btn-orange" href="<?= site_url('customer/customer_booking/listing') ?>">
          My Bookings
        </a>

        <a class="btn btn-outline-dark" href="<?= site_url('customer/customer_notifications') ?>">
          Notifications
        </a>
      </div>
    </div>

    <!-- RECENT BOOKINGS -->
    <div class="card card-soft p-3">
      <div class="fw-bold mb-2">Recent Bookings</div>

      <?php if(empty($bookings)): ?>
        <div class="text-muted">No bookings yet.</div>
      <?php else: ?>
        <?php foreach($bookings as $b): ?>
          <a class="d-block text-decoration-none border rounded p-2 mb-2"
             href="<?= site_url('customer/customer_booking/view/'.$b['booking_id']) ?>">

            <div class="fw-bold">
              #<?= (int)$b['booking_id'] ?> —
              <?= htmlspecialchars($b['city_from']) ?> → <?= htmlspecialchars($b['city_to']) ?>
            </div>

            <div class="small text-muted">
              Status: <?= htmlspecialchars($b['status']) ?>
            </div>
          </a>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>

  </div>
</div>
<?php include(APPPATH.'views/_partials/bottom_customer.php'); ?>
<?php include(APPPATH.'views/_partials/footer.php'); ?>
