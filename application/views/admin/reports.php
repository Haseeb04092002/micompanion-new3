<?php include(APPPATH.'views/_partials/header.php'); ?>
<?php $page_title="Reports"; $logout_url="admin/admin_auth/logout"; include(APPPATH.'views/_partials/topbar.php'); ?>
<?php include(APPPATH.'views/_partials/alerts.php'); ?>

<div class="container pb-4">
  <div class="px-2">

    <!-- SUMMARY CARDS -->
    <div class="row g-2 mb-3">
      <div class="col-6">
        <div class="card card-soft p-3 text-center">
          <div class="small text-muted">Total Bookings</div>
          <div class="fw-bold fs-5"><?= (int)$summary['total_bookings']??'0' ?></div>
        </div>
      </div>
      <div class="col-6">
        <div class="card card-soft p-3 text-center">
          <div class="small text-muted">Completed</div>
          <div class="fw-bold fs-5"><?= (int)$summary['completed']??'0' ?></div>
        </div>
      </div>
      <div class="col-6">
        <div class="card card-soft p-3 text-center">
          <div class="small text-muted">Active Drivers</div>
          <div class="fw-bold fs-5"><?= (int)$summary['active_drivers']??'0' ?></div>
        </div>
      </div>
      <div class="col-6">
        <div class="card card-soft p-3 text-center">
          <div class="small text-muted">Customers</div>
          <div class="fw-bold fs-5"><?= (int)$summary['customers']??'0' ?></div>
        </div>
      </div>
    </div>

    <!-- REPORT LINKS -->
    <div class="d-none card card-soft p-3 mb-3">
      <h5 style="color:var(--orange)">Cargo Reports</h5>

      <a class="d-block py-2 border-bottom text-decoration-none"
         href="<?= site_url('admin/admin_reports/cargo_daily') ?>">
        📦 Daily Cargo Report
      </a>

      <a class="d-block py-2 border-bottom text-decoration-none"
         href="<?= site_url('admin/admin_reports/cargo_monthly') ?>">
        📦 Monthly Cargo Report
      </a>

      <a class="d-block py-2 text-decoration-none"
         href="<?= site_url('admin/admin_reports/cargo_status') ?>">
        📦 Status-wise Cargo Report
      </a>
    </div>

    <div class="card card-soft p-3 mb-3">
      <h5 style="color:var(--orange)">Driver Reports</h5>

      <a class="d-block py-2 border-bottom text-decoration-none"
         href="<?= site_url('admin/admin_reports/driver_performance') ?>">
        🚚 Driver Performance
      </a>

      <a class="d-block py-2 text-decoration-none"
         href="<?= site_url('admin/admin_reports/driver_activity') ?>">
        🚚 Driver Activity Log
      </a>
    </div>

    <div class="card card-soft p-3 mb-3">
      <h5 style="color:var(--orange)">Customer Reports</h5>

      <a class="d-block py-2 border-bottom text-decoration-none"
         href="<?= site_url('admin/admin_reports/customer_bookings') ?>">
        👤 Customer-wise Bookings
      </a>

      <a class="d-block py-2 text-decoration-none"
         href="<?= site_url('admin/admin_reports/top_customers') ?>">
        👤 Top Customers
      </a>
    </div>

    <div class="card card-soft p-3">
      <h5 style="color:var(--orange)">System Reports</h5>

      <a class="d-block py-2 border-bottom text-decoration-none"
         href="<?= site_url('admin/admin_reports/notifications') ?>">
        🔔 Notifications Report
      </a>

      <a class="d-block py-2 text-decoration-none"
         href="<?= site_url('admin/admin_reports/logs') ?>">
        ⚙️ System Activity Log
      </a>
    </div>

  </div>
</div>

<?php include(APPPATH.'views/_partials/bottom_admin.php'); ?>
<?php include(APPPATH.'views/_partials/footer.php'); ?>
