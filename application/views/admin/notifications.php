<?php $title="Admin Notifications"; include(APPPATH.'views/_partials/header.php'); ?>
<?php $page_title="Notifications"; $logout_url="admin/admin_auth/logout"; include(APPPATH.'views/_partials/topbar.php'); ?>
<?php include(APPPATH.'views/_partials/alerts.php'); ?>

<div class="container pb-4">
  <div class="px-2">

    <?php if(empty($rows)): ?>
      <div class="alert alert-info">No notifications found.</div>
    <?php else: ?>

      <?php foreach($rows as $n): ?>
        <div class="card card-soft p-3 mb-2 <?= $n['is_read'] ? '' : 'border-warning' ?>">
          <div class="d-flex justify-content-between">
            <div>
              <div class="fw-bold"><?= htmlspecialchars($n['title']) ?></div>
              <div class="small text-muted"><?= htmlspecialchars($n['body']) ?></div>
              <div class="small text-muted mt-1">
                <?= date('d M Y, h:i A', strtotime($n['created_at'])) ?>
              </div>
            </div>

            <?php if(!$n['is_read']): ?>
              <span class="badge bg-warning text-dark">New</span>
            <?php endif; ?>
          </div>
        </div>
      <?php endforeach; ?>

    <?php endif; ?>

  </div>
</div>

<?php include(APPPATH.'views/_partials/bottom_admin.php'); ?>
<?php include(APPPATH.'views/_partials/footer.php'); ?>
