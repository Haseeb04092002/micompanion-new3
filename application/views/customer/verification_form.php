<?php $title="Customer Verification"; include(APPPATH.'views/_partials/header.php'); ?>
<?php $page_title="Customer Verification"; $logout_url="customer/customer_auth/logout"; include(APPPATH.'views/_partials/topbar.php'); ?>

<div class="container pb-4">
  <div class="px-2">
    <div class="card card-soft p-3">

      <?php if(!empty($err)): ?>
        <div class="alert alert-danger"><?= $err ?></div>
      <?php endif; ?>

      <form method="post" enctype="multipart/form-data">

        <!-- CNIC NUMBER -->
        <div class="mb-2">
          <label class="form-label">CNIC Number</label>
          <input class="form-control"
                 name="cnic_no"
                 value="<?= htmlspecialchars($row['cnic_no'] ?? '') ?>"
                 placeholder="xxxxx-xxxxxxx-x"
                 required>
        </div>

        <!-- PHONE -->
        <div class="mb-2">
          <label class="form-label">Phone</label>
          <input class="form-control"
                 name="phone"
                 value="<?= htmlspecialchars($row['phone'] ?? '') ?>"
                 placeholder="03xx-xxxxxxx"
                 required>
        </div>

        <!-- ADDRESS -->
        <div class="mb-2">
          <label class="form-label">Residential Address</label>
          <textarea class="form-control"
                    name="address"
                    rows="3"
                    required><?= htmlspecialchars($row['address'] ?? '') ?></textarea>
        </div>

        <!-- PROFILE PIC -->
        <div class="mb-2">
          <label class="form-label">Profile Picture (jpg/png)</label>
          <input class="form-control" type="file" name="profile_pic">
          <?php if(!empty($row['profile_pic'])): ?>
            <small class="text-muted">Current file exists</small>
          <?php endif; ?>
        </div>

        <!-- CNIC IMAGE -->
        <div class="mb-3">
          <label class="form-label">CNIC Front Image (jpg/png)</label>
          <input class="form-control" type="file" name="cnic_img">
          <?php if(!empty($row['cnic_img'])): ?>
            <small class="text-muted">Current file exists</small>
          <?php endif; ?>
        </div>

        <!-- SUBMIT -->
        <button class="btn btn-orange w-100" name="save" value="1">
          Save Verification
        </button>

      </form>
    </div>
  </div>
</div>
<?php include(APPPATH.'views/_partials/bottom_customer.php'); ?>
<?php include(APPPATH.'views/_partials/footer.php'); ?>
