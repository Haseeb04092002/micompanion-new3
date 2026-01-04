<?php include(APPPATH.'views/_partials/header.php'); ?>
<?php $page_title="New Booking"; include(APPPATH.'views/_partials/topbar.php'); ?>
<?php include(APPPATH.'views/_partials/alerts.php'); ?>

<div class="container pb-4">
  <div class="px-2">

    <form method="post" class="card card-soft p-3">

      <!-- FROM CITY -->
      <input class="form-control mb-2"
             name="city_from"
             placeholder="From City"
             required>

      <!-- PICKUP LOCATION -->
      <input class="form-control mb-2"
             name="loc_from"
             placeholder="Pickup Location"
             required>

      <!-- TO CITY -->
      <input class="form-control mb-2"
             name="city_to"
             placeholder="To City"
             required>

      <!-- DROP LOCATION -->
      <input class="form-control mb-2"
             name="loc_to"
             placeholder="Drop Location"
             required>

      <!-- UNITS -->
      <input class="form-control mb-2"
             name="units"
             type="number"
             min="1"
             placeholder="Cargo Units / Parcels"
             required>

      <!-- CARGO CATEGORY -->
      <input class="form-control mb-3"
             name="cargo_category"
             placeholder="Cargo Category (e.g. Electronics, Furniture)"
             required>

      <!-- VEHICLE TYPE (FROM APPROVED VEHICLES) -->
      <div class="mb-3">
        <label class="form-label fw-bold">Select Vehicle Type</label>
        <select class="form-select" name="vehicle_type" required>
          <option value="">-- Select Vehicle --</option>

          <?php foreach($vehicles as $v): ?>
            <option value="<?= htmlspecialchars($v['category']) ?>">
              <?= htmlspecialchars($v['category']) ?>
              — <?= htmlspecialchars($v['name']) ?>
              (<?= htmlspecialchars($v['driver_name']) ?>)
            </option>
          <?php endforeach; ?>

        </select>
      </div>

      <!-- SUBMIT -->
      <button class="btn btn-orange w-100" name="save" value="1">
        Create Booking
      </button>

    </form>

  </div>
</div>

<?php include(APPPATH.'views/_partials/bottom_customer.php'); ?>
<?php include(APPPATH.'views/_partials/footer.php'); ?>
