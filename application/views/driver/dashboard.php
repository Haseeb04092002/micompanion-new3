<?php $title = "Driver Dashboard";
include(APPPATH . 'views/_partials/header.php'); ?>
<?php $page_title = "Driver Dashboard";
$logout_url = "driver/driver_auth/logout";
include(APPPATH . 'views/_partials/topbar.php'); ?>

<div class="container pb-4">
  <div class="px-2">
    <?php if ($need_verify): ?>
      <div class="alert alert-warning">
        <b>You must enter your documents to be verified.</b>
        <div class="mt-2">
          <a class="btn btn-orange" href="<?= site_url('driver/driver_profile/verify') ?>">Upload Documents</a>
        </div>
      </div>
    <?php endif; ?>

    <!-- <div class="card card-soft p-3 mb-3">
      <div class="d-flex flex-wrap gap-2">
        <a class="btn btn-orange" href="<?= site_url('driver/driver_vehicles') ?>">My Vehicles</a>
        <a class="btn btn-orange" href="<?= site_url('driver/driver_jobs') ?>">My Jobs</a>
        <a class="btn btn-outline-dark" href="<?= site_url('driver/driver_notifications') ?>">Notifications</a>
      </div>
    </div> -->

    <div class="card card-soft p-3">
      <div class="fw-bold mb-2">Recent Jobs</div>
      <?php if (empty($jobs)): ?>
        <div class="text-muted">No jobs yet.</div>
      <?php else: ?>
        <?php foreach ($jobs as $j): ?>
          <a href="<?= site_url('driver/driver_jobs/view/' . $j['booking_id']) ?>"
            class="d-block text-decoration-none mb-2">

            <div class="border rounded-3 px-3 py-2 shadow-sm">

              <div class="d-flex justify-content-between align-items-center">
                <div class="fw-semibold text-dark small">
                  Cargo ID: #<?= (int)$j['booking_id'] ?>
                </div>

                <span class="badge bg-secondary text-uppercase small">
                  <?= htmlspecialchars($j['status']) ?>
                </span>
              </div>

              <div class="text-muted small mt-1">
                <?= htmlspecialchars($j['city_from']) ?>
                <span class="mx-1">→</span>
                <?= htmlspecialchars($j['city_to']) ?>
              </div>

            </div>
          </a>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </div>
</div>
<?php include(APPPATH . 'views/_partials/bottom_driver.php'); ?>
<?php include(APPPATH . 'views/_partials/footer.php'); ?>