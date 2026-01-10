<?php $title="Customer Dashboard"; include(APPPATH.'views/_partials/header.php'); ?>
<?php $page_title="Customer Dashboard"; $logout_url="customer/customer_auth/logout"; include(APPPATH.'views/_partials/topbar.php'); ?>
<?php include(APPPATH.'views/_partials/alerts.php'); ?>

<form method="post">
  <label>Easypaisa Number</label>
  <input type="text" name="ep_number" class="form-control" required>

  <label>Transaction ID</label>
  <input type="text" name="ep_txn" class="form-control" required>

  <button class="btn btn-success mt-2">
    Submit Payment
  </button>
</form>


<?php include(APPPATH.'views/_partials/bottom_customer.php'); ?>
<?php include(APPPATH.'views/_partials/footer.php'); ?>
