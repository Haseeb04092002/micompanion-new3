<?php include(APPPATH . 'views/_partials/header.php'); ?>
<?php $page_title = "Vehicles";
$logout_url = "admin/admin_auth/logout";
include(APPPATH . 'views/_partials/topbar.php'); ?>

<div class="container pb-3">

<?php foreach ($rows as $v): ?>

  <div class="card border-0 shadow-sm mb-2">
    <div class="card-body py-2 px-3">

      <!-- TOP ROW -->
      <div class="d-flex justify-content-between align-items-center">

        <div class="fw-semibold small">
          <?= htmlspecialchars($v['category']) ?> — <?= htmlspecialchars($v['name']) ?>
        </div>

        <?php if ($v['status'] === 'approved'): ?>
          <span class="badge bg-success">Approved</span>
        <?php elseif ($v['status'] === 'rejected'): ?>
          <span class="badge bg-danger">Rejected</span>
        <?php else: ?>
          <span class="badge bg-warning text-dark">Pending</span>
        <?php endif; ?>

      </div>

      <!-- DETAILS (INLINE, COMPACT) -->
      <div class="row small text-muted mt-1">

        <div class="col-6">
          <span>Driver:</span>
          <strong class="text-dark"><?= htmlspecialchars($v['driver_name']) ?></strong>
        </div>

        <!-- <div class="col-6 text-end">
          <span>Status:</span>
          <strong class="text-capitalize text-dark"><?= htmlspecialchars($v['status']) ?></strong>
        </div> -->

      </div>

      <!-- IMAGES + ACTIONS -->
      <div class="d-flex justify-content-between align-items-center mt-2">

        <!-- IMAGES -->
        <div class="d-flex gap-2">
          <img src="<?= base_url('uploads/vehicles/' . $v['front_img']) ?>"
               class="rounded border"
               style="width:55px;height:auto">

          <img src="<?= base_url('uploads/vehicles/' . $v['back_img']) ?>"
               class="rounded border"
               style="width:55px;height:auto">
        </div>

        <!-- ACTIONS -->
        <div class="d-flex gap-1">

          <?php if ($v['status'] !== 'approved'): ?>
            <a href="<?= site_url('admin/admin_vehicles/approve/' . $v['vehicle_id']) ?>"
               class="btn btn-outline-success btn-sm px-2">
              ✓
            </a>
          <?php endif; ?>

          <?php if ($v['status'] !== 'rejected'): ?>
            <a href="<?= site_url('admin/admin_vehicles/reject/' . $v['vehicle_id']) ?>"
               class="btn btn-outline-danger btn-sm px-2">
              ✕
            </a>
          <?php endif; ?>

        </div>

      </div>

    </div>
  </div>

<?php endforeach; ?>

</div>




<?php include(APPPATH . 'views/_partials/bottom_admin.php'); ?>
<?php include(APPPATH . 'views/_partials/footer.php'); ?>