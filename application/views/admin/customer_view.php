<?php $title="Customer Details"; include(APPPATH.'views/_partials/header.php'); ?>
<?php $page_title="Customer Details"; $logout_url="admin/admin_auth/logout"; include(APPPATH.'views/_partials/topbar.php'); ?>

<div class="container pb-4">
  <div class="px-2">

    <!-- BASIC INFO -->
    <div class="card card-soft p-3 mb-3">
      <h5 class="mb-2" style="color:var(--orange)">Basic Information</h5>

      <div><b>Name:</b> <?= htmlspecialchars($user['name']) ?></div>
      <div><b>Email:</b> <?= htmlspecialchars($user['email']) ?></div>
      <div><b>Status:</b>
        <span class="badge bg-secondary"><?= htmlspecialchars($user['status']) ?></span>
      </div>
    </div>

    <!-- PROFILE DETAILS -->
    <div class="card card-soft p-3 mb-3">
      <h5 class="mb-2" style="color:var(--orange)">Verification Details</h5>

      <div><b>CNIC:</b> <?= htmlspecialchars($profile['cnic_no'] ?? '-') ?></div>
      <div><b>Phone:</b> <?= htmlspecialchars($profile['phone'] ?? '-') ?></div>
      <div><b>Address:</b><br><?= nl2br(htmlspecialchars($profile['address'] ?? '-')) ?></div>
    </div>

    <!-- DOCUMENTS -->
    <div class="card card-soft p-3 mb-3">
      <h5 class="mb-3" style="color:var(--orange)">Uploaded Documents</h5>

      <div class="row g-3">

        <!-- PROFILE PIC -->
        <div class="col-12 col-md-6">
          <div class="border rounded p-2 text-center">
            <div class="fw-bold mb-1">Profile Picture</div>
            <?php if(!empty($profile['profile_pic'])): ?>
              <img src="<?= base_url('uploads/users/'.$profile['profile_pic']) ?>"
                   class="img-fluid rounded"
                   style="max-height:220px">
            <?php else: ?>
              <div class="text-muted">Not uploaded</div>
            <?php endif; ?>
          </div>
        </div>

        <!-- CNIC IMAGE -->
        <div class="col-12 col-md-6">
          <div class="border rounded p-2 text-center">
            <div class="fw-bold mb-1">CNIC Front Image</div>
            <?php if(!empty($profile['cnic_img'])): ?>
              <img src="<?= base_url('uploads/users/'.$profile['cnic_img']) ?>"
                   class="img-fluid rounded"
                   style="max-height:220px">
            <?php else: ?>
              <div class="text-muted">Not uploaded</div>
            <?php endif; ?>
          </div>
        </div>

      </div>
    </div>

    <!-- ACTION BUTTONS -->
    <div class="card card-soft p-3">
      <div class="d-flex flex-wrap gap-2">
        <a class="btn btn-success"
           href="<?= site_url('admin/admin_customers/approve/'.$user['user_id']) ?>">
           Approve
        </a>

        <a class="btn btn-warning"
           href="<?= site_url('admin/admin_customers/reject/'.$user['user_id']) ?>">
           Reject
        </a>

        <a class="btn btn-danger"
           href="<?= site_url('admin/admin_customers/suspend/'.$user['user_id']) ?>">
           Suspend
        </a>

        <a class="btn btn-outline-dark"
           href="<?= site_url('admin/admin_customers') ?>">
           Back to List
        </a>
      </div>
    </div>

  </div>
</div>
<?php include(APPPATH.'views/_partials/bottom_admin.php'); ?>
<?php include(APPPATH.'views/_partials/footer.php'); ?>
