<?php include(APPPATH . 'views/_partials/header.php'); ?>
<?php $page_title = "Cargo Requests";
$logout_url = "admin/admin_auth/logout";
include(APPPATH . 'views/_partials/topbar.php'); ?>

<div class="container pb-4">
  <div class="px-2">

    <?php if (empty($rows)): ?>
      <div class="alert alert-info">No cargo requests found.</div>
    <?php endif; ?>

    <?php foreach ($rows as $r): ?>
      <div class="card shadow-sm border-0 mb-3">
        <div class="card-body py-3">

          <!-- HEADER -->
          <div class="d-flex justify-content-between align-items-start">
            <div>
              <div class="fw-semibold">
                Cargo #<?= (int)$r['booking_id'] ?>
              </div>
              <div class="small text-muted">
                Bilty: <strong><?= htmlspecialchars($r['bilty_code']) ?></strong>
              </div>
            </div>

            <!-- STATUS -->
            <span class="badge rounded-pill bg-secondary text-capitalize">
              <?= htmlspecialchars($r['status']) ?>
            </span>
          </div>

          <!-- LOCATIONS -->
          <div class="mt-2 small">
            <div class="text-muted">
              <span class="fw-semibold text-dark">Pickup:</span>
              <?= htmlspecialchars($r['loc_from']) ?>,
              <?= htmlspecialchars($r['city_from']) ?>
            </div>
            <div class="text-muted">
              <span class="fw-semibold text-dark">Drop-off:</span>
              <?= htmlspecialchars($r['loc_to']) ?>,
              <?= htmlspecialchars($r['city_to']) ?>
            </div>
          </div>

          <!-- CUSTOMER -->
          <div class="mt-1 small text-muted">
            <span class="fw-semibold text-dark">Customer:</span>
            <?= htmlspecialchars($r['customer_name']) ?>
          </div>

          <!-- ACTIONS -->
          <div class="mt-3 d-flex justify-content-end gap-2 flex-wrap">

            <a class="btn btn-orange btn-sm px-3"
              href="<?= site_url('admin/admin_cargo/assign/' . $r['booking_id']) ?>">
              Assign
            </a>

            <a class="btn btn-outline-dark btn-sm px-3"
              href="<?= site_url('admin/admin_cargo/view/' . $r['booking_id']) ?>">
              Details
            </a>

            <a class="btn btn-outline-dark btn-sm px-3"
              href="<?= site_url('admin/admin_cargo_bilty/pdf/' . $r['booking_id']) ?>">
              Bilty PDF
            </a>

          </div>

        </div>
      </div>

    <?php endforeach; ?>

  </div>
</div>

<?php include(APPPATH . 'views/_partials/bottom_admin.php'); ?>
<?php include(APPPATH . 'views/_partials/footer.php'); ?>