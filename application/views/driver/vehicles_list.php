<?php include(APPPATH . 'views/_partials/header.php'); ?>
<?php $page_title = "My Vehicles";
include(APPPATH . 'views/_partials/topbar.php'); ?>

<div class="container pb-4">

  <!-- Add Vehicle Button -->
  <div class="d-grid mb-3">
    <a class="btn btn-orange btn-lg"
      href="<?= site_url('driver/driver_vehicles/add') ?>">
      <i class="bi bi-plus-circle me-1"></i> Add Vehicle
    </a>
  </div>

  <?php foreach ($rows as $v): ?>

    <div class="card card-soft shadow-sm border-0 mb-3">
      <div class="card-body">

        <!-- Top Row -->
        <div class="d-flex justify-content-between align-items-start">

          <div>
            <h6 class="mb-1 fw-bold">
              <?= htmlspecialchars($v['name']) ?>
            </h6>

            <div class="small text-muted">
              <?= htmlspecialchars($v['category']) ?> •
              Model: <?= htmlspecialchars($v['model']) ?>
            </div>
          </div>

          <!-- Status Badge -->
          <?php if ($v['status'] === 'rejected'): ?>
            <span class="badge rounded-pill bg-danger">
              Rejected
            </span>
          <?php elseif ($v['status'] === 'pending'): ?>
            <span class="badge rounded-pill" style="color: white; background-color: #6c757d; ">
              Pending
            </span>
          <?php else: ?>
            <span class="badge rounded-pill bg-success">
              Approved
            </span>
          <?php endif; ?>

        </div>

        <hr class="my-2">

        <!-- Actions -->
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">

          <div class="small text-muted">
            Vehicle Status:
            <strong class="text-capitalize">
              <?= htmlspecialchars($v['status']) ?>
            </strong>
          </div>

          <a class="btn btn-outline-dark btn-sm"
            href="<?= site_url('driver/driver_vehicles/view/' . $v['vehicle_id']) ?>">
            <i class="bi bi-eye me-1"></i> Details
          </a>

        </div>

      </div>
    </div>

  <?php endforeach; ?>

</div>


<?php include(APPPATH . 'views/_partials/bottom_driver.php'); ?>
<?php include(APPPATH . 'views/_partials/footer.php'); ?>