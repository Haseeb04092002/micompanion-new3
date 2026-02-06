<?php $title="Add Vehicle"; include(APPPATH.'views/_partials/header.php'); ?>
<?php $page_title="Add Vehicle"; $logout_url="driver/driver_auth/logout"; include(APPPATH.'views/_partials/topbar.php'); ?>

<div class="container pb-4">
  <div class="px-2">

    <div class="card card-soft p-3">

      <?php if(!empty($err)): ?>
        <div class="alert alert-danger"><?= $err ?></div>
      <?php endif; ?>

      <form method="post" enctype="multipart/form-data">

        <!-- VEHICLE CATEGORY -->
        <div class="mb-2">
          <label class="form-label">Vehicle Category</label>
          <select class="form-select" name="category" required>
            <option value="">Select Category</option>
            <option value="Truck">Truck</option>
            <option value="Van">Van</option>
            <option value="Pickup">Pickup</option>
            <option value="Rickshaw">Rickshaw</option>
            <option value="Bike">Bike</option>
          </select>
        </div>

        <!-- VEHICLE NAME -->
        <div class="mb-2">
          <label class="form-label">Vehicle Name</label>
          <input class="form-control"
                 name="name"
                 placeholder="e.g. Suzuki Bolan, Hino 500"
                 required>
        </div>

        <!-- VEHICLE MODEL -->
        <div class="mb-2">
          <label class="form-label">Vehicle Model</label>
          <input class="form-control"
                 name="model"
                 placeholder="e.g. 2020"
                 required>
        </div>

        <!-- FRONT IMAGE -->
        <div class="mb-2">
          <label class="form-label">Front Image (jpg/png)</label>
          <input class="form-control"
                 type="file"
                 name="front_img"
                 accept="image/*"
                 required>
        </div>

        <!-- BACK IMAGE -->
        <div class="mb-3">
          <label class="form-label">Back Image (jpg/png)</label>
          <input class="form-control"
                 type="file"
                 name="back_img"
                 accept="image/*"
                 required>
        </div>

        <!-- EXTRA DETAILS -->
        <div class="mb-3">
          <label class="form-label">Additional Details (Optional)</label>
          <textarea class="form-control"
                    name="details"
                    rows="3"
                    placeholder="Capacity, condition, special notes"></textarea>
        </div>

        <!-- SUBMIT -->
        <button class="btn btn-orange w-100"
                name="save"
                value="1">
          Submit Vehicle for Approval
        </button>

      </form>
    </div>

  </div>
</div>

<?php include(APPPATH.'views/_partials/bottom_driver.php'); ?>
<?php include(APPPATH.'views/_partials/footer.php'); ?>
