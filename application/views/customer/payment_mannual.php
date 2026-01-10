<?php $title="Customer Dashboard"; include(APPPATH.'views/_partials/header.php'); ?>
<?php $page_title="Customer Dashboard"; $logout_url="customer/customer_auth/logout"; include(APPPATH.'views/_partials/topbar.php'); ?>
<?php include(APPPATH.'views/_partials/alerts.php'); ?>

<form method="post" enctype="multipart/form-data">
  <label>Upload Payment Proof</label>
  <input type="file" name="proof" class="form-control" required>

  <button class="btn btn-primary mt-2">
    Submit Proof
  </button>
</form>



<?php include(APPPATH.'views/_partials/bottom_customer.php'); ?>
<?php include(APPPATH.'views/_partials/footer.php'); ?>
