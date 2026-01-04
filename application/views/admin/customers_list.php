<?php include(APPPATH . 'views/_partials/header.php'); ?>
<?php $page_title = "Customers";
$logout_url = "admin/admin_auth/logout";
include(APPPATH . 'views/_partials/topbar.php'); ?>
<?php include(APPPATH . 'views/_partials/alerts.php'); ?>

<div class="container pb-4">
  <input class="form-control mb-3" id="q" placeholder="Search customer..." onkeyup="f()">

  <?php foreach ($rows as $r): ?>
    <div class="card card-soft p-3 mb-2 rowItem">
      <div class="justify-content-between align-items-center d-flex">
        <div class="fw-bold"><?= $r['name'] ?></div>
        <a class="btn btn-info p-1 btn-sm"
          href="<?= site_url('admin/admin_customers/view/' . $r['user_id']) ?>">
          Details
        </a>
      </div>
      <div class="small text-muted"><?= $r['email'] ?> | <?= $r['status'] ?></div>
      <div class="mt-2 d-flex gap-2">
        <a class="btn btn-success btn-sm" href="<?= site_url('admin/admin_customers/approve/' . $r['user_id']) ?>">Approve</a>
        <a class="btn btn-warning btn-sm" href="<?= site_url('admin/admin_customers/reject/' . $r['user_id']) ?>">Reject</a>
        <a class="btn btn-danger btn-sm" href="<?= site_url('admin/admin_customers/suspend/' . $r['user_id']) ?>">Suspend</a>


      </div>
    </div>
  <?php endforeach; ?>
</div>

<script>
  function f() {
    let q = document.getElementById('q').value.toLowerCase();
    document.querySelectorAll('.rowItem').forEach(r => {
      r.style.display = r.innerText.toLowerCase().includes(q) ? '' : 'none';
    });
  }
</script>
<?php include(APPPATH . 'views/_partials/bottom_admin.php'); ?>
<?php include(APPPATH . 'views/_partials/footer.php'); ?>