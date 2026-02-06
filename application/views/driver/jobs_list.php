<?php include(APPPATH . 'views/_partials/header.php'); ?>
<?php $page_title = "My Jobs";
include(APPPATH . 'views/_partials/topbar.php'); ?>

<div class="container pb-4">


    <!-- TABS -->
    <ul class="nav nav-tabs mb-3">
      <li class="nav-item">
        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#my">
          My Jobs
        </button>
      </li>
      <li class="nav-item">
        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#requested">
          Requested Jobs
        </button>
      </li>
      <li class="nav-item">
        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#all">
          All Jobs
        </button>
      </li>
    </ul>

    <div class="tab-content">

      <!-- ===================== -->
      <!-- MY JOBS -->
      <!-- ===================== -->
      <div class="tab-pane fade show active" id="my">

        <?php if (empty($my_jobs)): ?>
          <div class="alert alert-light text-center">No jobs assigned.</div>
        <?php endif; ?>

        <?php foreach ($my_jobs as $j): ?>
          <div class="card mb-3 shadow-sm">
            <div class="card-body">

              <!-- HEADER -->
              <div class="d-flex justify-content-between align-items-center mb-2">
                <div class="fw-bold">
                  Cargo #<?= (int)$j['booking_id'] ?>
                </div>
                <span class="badge bg-success">
                  <?= ucfirst(str_replace('_', ' ', $j['status'])) ?>
                </span>
              </div>

              <!-- ROUTE -->
              <div class="small text-muted mb-2">
                <?= htmlspecialchars($j['city_from']) ?> → <?= htmlspecialchars($j['city_to']) ?>
              </div>

              <!-- CARGO DETAILS -->
              <div class="row small">
                <div class="col-6">
                  <strong>Type:</strong> <?= htmlspecialchars($j['cargo_type'] ?? '-') ?><br>
                  <strong>Weight:</strong> <?= htmlspecialchars($j['weight'] ?? '-') ?> kg<br>
                  <strong>Pieces:</strong> <?= htmlspecialchars($j['pieces'] ?? '-') ?>
                </div>
                <div class="col-6">
                  <strong>Pickup:</strong> <?= htmlspecialchars($j['pickup_address'] ?? '-') ?><br>
                  <strong>Drop:</strong> <?= htmlspecialchars($j['delivery_address'] ?? '-') ?>
                </div>
              </div>

              <hr>

              <!-- CUSTOMER DETAILS -->
              <div class="small">
                <strong>Customer:</strong> <?= htmlspecialchars($j['customer_name'] ?? '-') ?><br>
                <strong>Phone:</strong> <?= htmlspecialchars($j['customer_phone'] ?? '-') ?><br>
                <strong>Email:</strong> <?= htmlspecialchars($j['customer_email'] ?? '-') ?>
              </div>

              <!-- ACTION -->
              <div class="mt-3">
                <a href="<?= site_url('driver/driver_jobs/view/' . $j['booking_id']) ?>"
                  class="btn btn-sm btn-outline-dark w-100">
                  View / Update Status
                </a>
              </div>

            </div>
          </div>
        <?php endforeach; ?>

      </div>

      <!-- ===================== -->
      <!-- REQUESTED JOBS -->
      <!-- ===================== -->
      <div class="tab-pane fade" id="requested">

        <?php if (empty($requested_jobs)): ?>
          <div class="alert alert-light text-center">No requested jobs.</div>
        <?php endif; ?>

        <?php foreach ($requested_jobs as $j): ?>
          <div class="card mb-3 border-warning shadow-sm">
            <div class="card-body">

              <div class="d-flex justify-content-between mb-2">
                <div class="fw-bold">
                  Cargo #<?= (int)$j['booking_id'] ?>
                </div>
                <span class="badge bg-warning text-dark">
                  Waiting Approval
                </span>
              </div>

              <div class="small text-muted mb-2">
                <?= htmlspecialchars($j['city_from']) ?> → <?= htmlspecialchars($j['city_to']) ?>
              </div>

              <div class="row small">
                <div class="col-6">
                  <strong>Type:</strong> <?= htmlspecialchars($j['cargo_type'] ?? '-') ?><br>
                  <strong>Weight:</strong> <?= htmlspecialchars($j['weight'] ?? '-') ?> kg
                </div>
                <div class="col-6">
                  <strong>Pickup:</strong> <?= htmlspecialchars($j['pickup_address'] ?? '-') ?>
                </div>
              </div>

              <hr>

              <div class="small">
                <strong>Customer:</strong> <?= htmlspecialchars($j['customer_name'] ?? '-') ?><br>
                <strong>Phone:</strong> <?= htmlspecialchars($j['customer_phone'] ?? '-') ?>
              </div>

              <div class="mt-3">
                <a href="<?= site_url('driver/driver_jobs/view/' . $j['booking_id']) ?>"
                  class="btn btn-sm btn-outline-secondary w-100">
                  View Details
                </a>
              </div>

            </div>
          </div>
        <?php endforeach; ?>

      </div>

      <!-- ===================== -->
      <!-- ALL JOBS -->
      <!-- ===================== -->
      <div class="tab-pane fade" id="all">

        <?php if (empty($all_jobs)): ?>
          <div class="alert alert-light text-center">No available jobs.</div>
        <?php endif; ?>

        <?php foreach ($all_jobs as $j): ?>
          <div class="card mb-3 shadow-sm">
            <div class="card-body">

              <div class="fw-bold mb-1">
                Cargo #<?= (int)$j['booking_id'] ?>
              </div>

              <div class="small text-muted mb-2">
                <?= htmlspecialchars($j['city_from']) ?> → <?= htmlspecialchars($j['city_to']) ?>
              </div>

              <div class="row small">
                <div class="col-6">
                  <strong>Type:</strong> <?= htmlspecialchars($j['cargo_type'] ?? '-') ?><br>
                  <strong>Weight:</strong> <?= htmlspecialchars($j['weight'] ?? '-') ?> kg
                </div>
                <div class="col-6">
                  <strong>Pickup:</strong> <?= htmlspecialchars($j['pickup_address'] ?? '-') ?>
                </div>
              </div>

              <hr>

              <div class="small">
                <strong>Customer:</strong> <?= htmlspecialchars($j['customer_name'] ?? '-') ?><br>
                <strong>Phone:</strong> <?= htmlspecialchars($j['customer_phone'] ?? '-') ?>
              </div>

              <div class="mt-3">
                <a href="<?= site_url('driver/driver_jobs/request_job/' . $j['booking_id']) ?>"
                  class="btn btn-sm btn-outline-primary w-100">
                  Request Job
                </a>
              </div>

            </div>
          </div>
        <?php endforeach; ?>

      </div>

    </div>


  <!-- <?php foreach ($rows as $r): ?>
    <a class="card card-soft p-3 mb-2 d-block text-decoration-none"
      href="<?= site_url('driver/driver_jobs/view/' . $r['booking_id']) ?>">
      <div class="fw-bold">#<?= $r['booking_id'] ?> <?= $r['city_from'] ?> → <?= $r['city_to'] ?></div>
      <div class="small">Status: <?= $r['status'] ?></div>
    </a>
  <?php endforeach; ?> -->
</div>
<?php include(APPPATH . 'views/_partials/bottom_driver.php'); ?>
<?php include(APPPATH . 'views/_partials/footer.php'); ?>