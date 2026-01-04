<?php $title="Driver Dashboard"; include(APPPATH.'views/_partials/header.php'); ?>
<?php $page_title="Driver Dashboard"; $logout_url="driver/driver_auth/logout"; include(APPPATH.'views/_partials/topbar.php'); ?>
<?php include(APPPATH.'views/_partials/alerts.php'); ?>

<div class="container pb-4">
  <div class="px-2">
    <?php if($need_verify): ?>
      <div class="alert alert-warning">
        <b>You must enter your documents to be verified.</b>
        <div class="mt-2">
          <a class="btn btn-orange" href="<?= site_url('driver/driver_profile/verify') ?>">Upload Documents</a>
        </div>
      </div>
    <?php endif; ?>

    <div class="card card-soft p-3 mb-3">
      <div class="d-flex flex-wrap gap-2">
        <a class="btn btn-orange" href="<?= site_url('driver/driver_vehicles') ?>">My Vehicles</a>
        <a class="btn btn-orange" href="<?= site_url('driver/driver_jobs') ?>">My Jobs</a>
        <a class="btn btn-outline-dark" href="<?= site_url('driver/driver_notifications') ?>">Notifications</a>
      </div>
    </div>

    <div class="card card-soft p-3">
      <div class="fw-bold mb-2">Recent Jobs</div>
      <?php if(empty($jobs)): ?>
        <div class="text-muted">No jobs yet.</div>
      <?php else: ?>
        <?php foreach($jobs as $j): ?>
          <a class="d-block text-decoration-none border rounded p-2 mb-2"
             href="<?= site_url('driver/driver_jobs/view/'.$j['booking_id']) ?>">
             <div class="fw-bold">#<?= (int)$j['booking_id'] ?> - <?= htmlspecialchars($j['city_from']) ?> → <?= htmlspecialchars($j['city_to']) ?></div>
             <div class="small text-muted">Status: <?= htmlspecialchars($j['status']) ?></div>
          </a>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </div>
</div>
<?php include(APPPATH.'views/_partials/bottom_driver.php'); ?>
<?php include(APPPATH.'views/_partials/footer.php'); ?>
