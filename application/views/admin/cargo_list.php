<?php include(APPPATH.'views/_partials/header.php'); ?>
<?php $page_title="Cargo Requests"; $logout_url="admin/admin_auth/logout"; include(APPPATH.'views/_partials/topbar.php'); ?>
<?php include(APPPATH.'views/_partials/alerts.php'); ?>

<div class="container pb-4">
  <div class="px-2">

    <?php if(empty($rows)): ?>
      <div class="alert alert-info">No cargo requests found.</div>
    <?php endif; ?>

    <?php foreach($rows as $r): ?>
      <div class="card card-soft p-3 mb-3">

        <!-- HEADER -->
        <div class="d-flex justify-content-between align-items-center">
          <div class="fw-bold">
            Cargo #<?= (int)$r['booking_id'] ?>
          </div>

          <span class="badge bg-secondary">
            <?= htmlspecialchars($r['status']) ?>
          </span>
        </div>

        <!-- BILTY -->
        <div class="small text-muted mt-1">
          Bilty ID: <b><?= htmlspecialchars($r['bilty_code']) ?></b>
        </div>

        <!-- LOCATIONS -->
        <div class="mt-2 small">
          <div>
            <b>Pickup:</b>
            <?= htmlspecialchars($r['loc_from']) ?>,
            <?= htmlspecialchars($r['city_from']) ?>
          </div>
          <div>
            <b>Drop-off:</b>
            <?= htmlspecialchars($r['loc_to']) ?>,
            <?= htmlspecialchars($r['city_to']) ?>
          </div>
        </div>

        <!-- CUSTOMER -->
        <div class="small mt-1">
          <b>Customer:</b> <?= htmlspecialchars($r['customer_name']) ?>
        </div>

        <!-- ACTIONS -->
        <div class="mt-3 d-flex gap-2 flex-wrap">
          <a class="btn btn-orange btn-sm"
             href="<?= site_url('admin/admin_cargo/assign/'.$r['booking_id']) ?>">
            Assign Driver
          </a>

          <a class="btn btn-outline-dark btn-sm"
             href="<?= site_url('admin/admin_cargo/view/'.$r['booking_id']) ?>">
            View Details
          </a>

          <a class="btn btn-outline-dark btn-sm"
             href="<?= site_url('admin/admin_cargo_bilty/pdf/'.$r['booking_id']) ?>">
            Bilty PDF
          </a>
        </div>

      </div>
    <?php endforeach; ?>

  </div>
</div>

<?php include(APPPATH.'views/_partials/bottom_admin.php'); ?>
<?php include(APPPATH.'views/_partials/footer.php'); ?>
