<?php $title="Driver Verification"; include(APPPATH.'views/_partials/header.php'); ?>
<?php $page_title="Driver Verification"; $logout_url="driver/driver_auth/logout"; include(APPPATH.'views/_partials/topbar.php'); ?>

<div class="container pb-4">
  <div class="px-2">
    <div class="card card-soft p-3">
      <?php if(!empty($err)): ?><div class="alert alert-danger"><?= $err ?></div><?php endif; ?>

      <form method="post" enctype="multipart/form-data">
        <div class="mb-2">
          <label class="form-label">Driving License Number</label>
          <input class="form-control" name="license_no" value="<?= htmlspecialchars($row['license_no'] ?? '') ?>" required>
        </div>

        <div class="mb-2">
          <label class="form-label">CNIC Number</label>
          <input class="form-control" name="cnic_no" value="<?= htmlspecialchars($row['cnic_no'] ?? '') ?>" required>
        </div>

        <div class="mb-2">
          <label class="form-label">Phone</label>
          <input class="form-control" name="phone" value="<?= htmlspecialchars($row['phone'] ?? '') ?>" required>
        </div>

        <div class="mb-2">
          <label class="form-label">Residential Address</label>
          <textarea class="form-control" name="address" required><?= htmlspecialchars($row['address'] ?? '') ?></textarea>
        </div>

        <div class="mb-2">
          <label class="form-label">Profile Picture (jpg/png)</label>
          <input class="form-control" type="file" name="profile_pic">
        </div>

        <div class="mb-2">
          <label class="form-label">Driving License Front Image</label>
          <input class="form-control" type="file" name="license_img">
        </div>

        <div class="mb-3">
          <label class="form-label">CNIC Front Image</label>
          <input class="form-control" type="file" name="cnic_img">
        </div>

        <button class="btn btn-orange w-100" name="save" value="1">Save Verification</button>
      </form>
    </div>
  </div>
</div>
<?php include(APPPATH.'views/_partials/bottom_driver.php'); ?>
<?php include(APPPATH.'views/_partials/footer.php'); ?>
