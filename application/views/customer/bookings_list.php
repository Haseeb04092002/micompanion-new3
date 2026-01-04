<?php include(APPPATH.'views/_partials/header.php'); ?>
<?php $page_title="My Bookings"; include(APPPATH.'views/_partials/topbar.php'); ?>

<div class="container pb-4">
  <div class="px-2">

    <?php if(empty($rows)): ?>
      <div class="alert alert-info">No bookings found.</div>
    <?php endif; ?>

    <?php foreach($rows as $r): ?>
      <div class="card card-soft p-3 mb-3">

        <!-- HEADER -->
        <div class="d-flex justify-content-between align-items-center">
          <div class="fw-bold">
            Booking #<?= (int)$r['booking_id'] ?>
          </div>

          <?php if($r['status']=='requested'): ?>
            <span class="badge bg-warning text-dark">Requested</span>
          <?php elseif($r['status']=='assigned'): ?>
            <span class="badge bg-info">Assigned</span>
          <?php elseif($r['status']=='picked_up'): ?>
            <span class="badge bg-primary">Picked Up</span>
          <?php elseif($r['status']=='in_transit'): ?>
            <span class="badge bg-primary">In Transit</span>
          <?php elseif($r['status']=='delivered'): ?>
            <span class="badge bg-success">Delivered</span>
          <?php else: ?>
            <span class="badge bg-secondary"><?= htmlspecialchars($r['status']) ?></span>
          <?php endif; ?>
        </div>

        <!-- DATE -->
        <div class="small text-muted mt-1">
          Requested on:
          <?= date('d M Y, h:i A', strtotime($r['created_at'])) ?>
        </div>

        <!-- LOCATIONS -->
        <div class="mt-2">
          <div class="small">
            <b>Pickup:</b> <?= htmlspecialchars($r['loc_from']) ?> (<?= htmlspecialchars($r['city_from']) ?>)
          </div>
          <div class="small">
            <b>Drop-off:</b> <?= htmlspecialchars($r['loc_to']) ?> (<?= htmlspecialchars($r['city_to']) ?>)
          </div>
        </div>

        <!-- ACTION -->
        <div class="mt-3 text-end">
          <a class="btn btn-outline-dark btn-sm"
             href="<?= site_url('customer/customer_booking/view/'.$r['booking_id']) ?>">
            View Details
          </a>
        </div>

      </div>
    <?php endforeach; ?>

  </div>
</div>

<?php include(APPPATH.'views/_partials/bottom_customer.php'); ?>
<?php include(APPPATH.'views/_partials/footer.php'); ?>
