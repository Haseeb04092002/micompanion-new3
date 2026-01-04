<?php $title="Admin Dashboard"; include(APPPATH.'views/_partials/header.php'); ?>
<?php $page_title="Admin Dashboard"; $logout_url="admin/admin_auth/logout"; include(APPPATH.'views/_partials/topbar.php'); ?>
<?php include(APPPATH.'views/_partials/alerts.php'); ?>

<div class="container pb-4">
  <div class="row g-3 px-2">
    <div class="col-12">
      <div class="card card-soft p-3">
        <div class="d-flex flex-wrap gap-2">
          <a class="btn btn-orange" href="<?= site_url('admin/admin_drivers') ?>">Drivers</a>
          <a class="btn btn-orange" href="<?= site_url('admin/admin_customers') ?>">Customers</a>
          <a class="btn btn-orange" href="<?= site_url('admin/admin_vehicles') ?>">Vehicles</a>
          <a class="btn btn-orange" href="<?= site_url('admin/admin_cargo') ?>">Cargo</a>
          <a class="btn btn-outline-dark" href="<?= site_url('admin/admin_chat') ?>">Chat</a>
          <a class="btn btn-outline-dark" href="<?= site_url('admin/admin_reports') ?>">Reports</a>
        </div>
      </div>
    </div>

    <div class="col-12">
      <div class="card card-soft p-3">
        <div class="fw-bold mb-2">Cargo Summary (by status)</div>
        <div class="d-flex flex-wrap gap-2">
          <?php foreach($cargo as $c): ?>
            <span class="chip"><?= htmlspecialchars($c['status']) ?>: <b><?= (int)$c['cnt'] ?></b></span>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include(APPPATH.'views/_partials/bottom_admin.php'); ?>
<?php include(APPPATH.'views/_partials/footer.php'); ?>
