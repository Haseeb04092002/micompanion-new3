<?php $title="Vehicle Details"; include(APPPATH.'views/_partials/header.php'); ?>
<?php $page_title="Vehicle Details"; $logout_url="driver/driver_auth/logout"; include(APPPATH.'views/_partials/topbar.php'); ?>
<?php include(APPPATH.'views/_partials/alerts.php'); ?>

<div class="container pb-4">
  <div class="px-2">

    <!-- BASIC INFO -->
    <div class="card card-soft p-3 mb-3">
      <h5 style="color:var(--orange)">Vehicle Information</h5>

      <div><b>Category:</b> <?= htmlspecialchars($vehicle['category']) ?></div>
      <div><b>Name:</b> <?= htmlspecialchars($vehicle['name']) ?></div>
      <div><b>Model:</b> <?= htmlspecialchars($vehicle['model']) ?></div>
      <div>
        <b>Status:</b>
        <?php if($vehicle['status']=='approved'): ?>
          <span class="badge bg-success">Approved</span>
        <?php elseif($vehicle['status']=='rejected'): ?>
          <span class="badge bg-danger">Rejected</span>
        <?php else: ?>
          <span class="badge bg-warning text-dark">Pending</span>
        <?php endif; ?>
      </div>
    </div>

    <!-- ADDITIONAL DETAILS -->
    <?php if(!empty($vehicle['details'])): ?>
      <div class="card card-soft p-3 mb-3">
        <h5 style="color:var(--orange)">Additional Details</h5>
        <div><?= nl2br(htmlspecialchars($vehicle['details'])) ?></div>
      </div>
    <?php endif; ?>

    <!-- IMAGES -->
    <div class="card card-soft p-3 mb-3">
      <h5 style="color:var(--orange)">Vehicle Images</h5>

      <div class="row g-3 mt-1">
        <div class="col-12 col-md-6 text-center">
          <div class="fw-bold mb-1">Front Image</div>
          <?php if(!empty($vehicle['front_img'])): ?>
            <img src="<?= base_url('uploads/vehicles/'.$vehicle['front_img']) ?>"
                 class="img-fluid rounded">
          <?php else: ?>
            <div class="text-muted">No image uploaded</div>
          <?php endif; ?>
        </div>

        <div class="col-12 col-md-6 text-center">
          <div class="fw-bold mb-1">Back Image</div>
          <?php if(!empty($vehicle['back_img'])): ?>
            <img src="<?= base_url('uploads/vehicles/'.$vehicle['back_img']) ?>"
                 class="img-fluid rounded">
          <?php else: ?>
            <div class="text-muted">No image uploaded</div>
          <?php endif; ?>
        </div>
      </div>
    </div>

    <!-- ACTION -->
    <div class="card card-soft p-3">
      <a class="btn btn-outline-dark w-100"
         href="<?= site_url('driver/driver_vehicles') ?>">
        Back to My Vehicles
      </a>
    </div>

  </div>
</div>

<?php include(APPPATH.'views/_partials/bottom_driver.php'); ?>
<?php include(APPPATH.'views/_partials/footer.php'); ?>
