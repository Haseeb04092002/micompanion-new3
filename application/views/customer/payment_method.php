<?php $title="Customer Dashboard"; include(APPPATH.'views/_partials/header.php'); ?>
<?php $page_title="Customer Dashboard"; $logout_url="customer/customer_auth/logout"; include(APPPATH.'views/_partials/topbar.php'); ?>
<?php include(APPPATH.'views/_partials/alerts.php'); ?>

<div class="card">
  <div class="card-body">
    <h6>Pay for Cargo #<?= $cargo['cargo_id'] ?></h6>

    <p>Amount: <strong>Rs <?= $cargo['payment_amount'] ?></strong></p>

    <a href="<?= site_url('customer/payment/easypaisa/'.$cargo['cargo_id']) ?>"
       class="btn btn-success w-100 mb-2">
       Pay via Easypaisa
    </a>

    <a href="<?= site_url('customer/payment/manual/'.$cargo['cargo_id']) ?>"
       class="btn btn-outline-dark w-100">
       Manual Payment
    </a>
  </div>
</div>


<?php include(APPPATH.'views/_partials/bottom_customer.php'); ?>
<?php include(APPPATH.'views/_partials/footer.php'); ?>
