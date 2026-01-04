<?php $title="Drivers"; include(APPPATH.'views/_partials/header.php'); ?>
<?php $page_title="Drivers"; $logout_url="admin/admin_auth/logout"; include(APPPATH.'views/_partials/topbar.php'); ?>
<?php include(APPPATH.'views/_partials/alerts.php'); ?>

<div class="container pb-4">
  <div class="px-2">
    <div class="card card-soft p-3 mb-3">
      <input class="form-control" id="q" placeholder="Search driver name/email/cnic/phone..." onkeyup="filterRows()">
      <small class="text-muted d-block mt-2">Approve / Reject / Suspend driver.</small>
    </div>

    <?php foreach($rows as $r): ?>
      <div class="card card-soft p-3 mb-3 rowItem">
        <div class="d-flex justify-content-between">
          <div>
            <div class="fw-bold"><?= htmlspecialchars($r['name']) ?></div>
            <div class="text-muted small"><?= htmlspecialchars($r['email']) ?> | Status: <b><?= htmlspecialchars($r['status']) ?></b></div>
            <div class="small">CNIC: <?= htmlspecialchars($r['cnic_no'] ?? '') ?> | Phone: <?= htmlspecialchars($r['phone'] ?? '') ?></div>
          </div>
          <div class="d-flex gap-2">
            <a class="btn btn-sm btn-success" href="<?= site_url('admin/admin_drivers/approve/'.$r['user_id']) ?>">Approve</a>
            <a class="btn btn-sm btn-warning" href="<?= site_url('admin/admin_drivers/reject/'.$r['user_id']) ?>">Reject</a>
            <a class="btn btn-sm btn-danger" href="<?= site_url('admin/admin_drivers/suspend/'.$r['user_id']) ?>">Suspend</a>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>

<script>
function filterRows(){
  var q = (document.getElementById('q').value || '').toLowerCase();
  document.querySelectorAll('.rowItem').forEach(function(el){
    el.style.display = el.innerText.toLowerCase().indexOf(q) > -1 ? '' : 'none';
  });
}
</script>
<?php include(APPPATH.'views/_partials/bottom_admin.php'); ?>
<?php include(APPPATH.'views/_partials/footer.php'); ?>
