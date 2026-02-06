<?php $title = "Drivers";
include(APPPATH . 'views/_partials/header.php'); ?>
<?php $page_title = "Drivers";
$logout_url = "admin/admin_auth/logout";
include(APPPATH . 'views/_partials/topbar.php'); ?>

<div class="container pb-4">
  <div class="px-2">
    <div class="card card-soft p-3 mb-3">
      <input class="form-control" id="q" placeholder="Search driver name/email/cnic/phone..." onkeyup="filterRows()">
      <small class="text-muted d-block mt-2">Approve / Reject / Suspend driver.</small>
    </div>

    <?php foreach ($rows as $r): ?>
      <div class="card card-soft p-3 mb-2 rowItem">
        <div class="d-flex justify-content-between align-items-center">
          <div class="fw-bold fs-4">
            <?= htmlspecialchars($r['name']) ?>
          </div>
          <span class="badge bg-secondary text-light badge-sm">
            <?= htmlspecialchars($r['status']) ?>
          </span>
        </div>

        <div class="small text-muted">
          <?= htmlspecialchars($r['email']) ?>
        </div>

        <div class="small text-muted mt-1">
          CNIC: <?= htmlspecialchars($r['cnic_no'] ?? '-') ?> |
          Phone: <?= htmlspecialchars($r['phone'] ?? '-') ?>
        </div>

        <div class="mt-2 d-flex gap-2">
          <a class="<?= ($r['status'] != 'approved') ? 'd-block' : 'd-none' ?> btn btn-success btn-sm p-1"
            href="<?= site_url('admin/admin_drivers/approve/' . $r['user_id']) ?>">
            Approve
          </a>

          <a class="<?= ($r['status'] != 'rejected') ? 'd-block' : 'd-none' ?> btn btn-warning btn-sm p-1"
            href="<?= site_url('admin/admin_drivers/reject/' . $r['user_id']) ?>">
            Reject
          </a>

          <a class="<?= ($r['status'] != 'suspended') ? 'd-block' : 'd-none' ?> btn btn-danger btn-sm p-1"
            href="<?= site_url('admin/admin_drivers/suspend/' . $r['user_id']) ?>">
            Suspend
          </a>

          <a class="btn btn-info btn-sm p-1"
            href="<?= site_url('admin/admin_drivers/view/' . $r['user_id']) ?>">
            Details
          </a>
        </div>
      </div>

    <?php endforeach; ?>
  </div>
</div>

<script>
  function filterRows() {
    var q = (document.getElementById('q').value || '').toLowerCase();
    document.querySelectorAll('.rowItem').forEach(function(el) {
      el.style.display = el.innerText.toLowerCase().indexOf(q) > -1 ? '' : 'none';
    });
  }
</script>
<?php include(APPPATH . 'views/_partials/bottom_admin.php'); ?>
<?php include(APPPATH . 'views/_partials/footer.php'); ?>