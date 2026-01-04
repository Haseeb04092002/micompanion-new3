<?php include(APPPATH.'views/_partials/header.php'); ?>
<?php $page_title="Job Detail"; include(APPPATH.'views/_partials/topbar.php'); ?>

<div class="container pb-4">
<div class="card card-soft p-3 mb-3">
  <div class="fw-bold">#<?= $booking['booking_id'] ?></div>
  <div><?= $booking['loc_from'] ?> → <?= $booking['loc_to'] ?></div>
</div>

<form method="post" class="card card-soft p-3">
  <select class="form-select mb-2" name="status" required>
    <option>accepted</option>
    <option>picked_up</option>
    <option>in_transit</option>
    <option>delivered</option>
    <option>mishap</option>
  </select>
  <textarea class="form-control mb-2" name="note" placeholder="Note (optional)"></textarea>
  <button class="btn btn-orange w-100" name="set_status">Update Status</button>
</form>
</div>
<?php include(APPPATH.'views/_partials/bottom_driver.php'); ?>
<?php include(APPPATH.'views/_partials/footer.php'); ?>
