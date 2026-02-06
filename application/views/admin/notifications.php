<?php $title = "Admin Notifications";
include(APPPATH . 'views/_partials/header.php'); ?>
<?php $page_title = "Notifications";
$logout_url = "admin/admin_auth/logout";
include(APPPATH . 'views/_partials/topbar.php'); ?>

<div class="container pb-4">
  <div class="px-2">

    <?php if (empty($rows)): ?>
      <div class="alert alert-info">No notifications found.</div>
    <?php else: ?>

      <?php foreach ($rows as $n): ?>
        <div class="card card-soft p-3 mb-2 shadow-sm <?= $n['is_read'] ? '' : 'border border-warning' ?>">
          <div class="d-flex justify-content-between align-items-start">

            <div class="me-3">
              <div class="fw-semibold fs-6 mb-1">
                <?= htmlspecialchars($n['title']) ?>
              </div>

              <div class="text-muted small mb-2">
                <?= htmlspecialchars($n['body']) ?>
              </div>

              <div class="d-flex align-items-center gap-2 small text-muted">
                <i class="bi bi-clock"></i>
                <?= date('d M Y, h:i A', strtotime($n['created_at'])) ?>
              </div>
            </div>

          </div>
        </div>

      <?php endforeach; ?>

    <?php endif; ?>

  </div>
</div>

<?php include(APPPATH . 'views/_partials/bottom_admin.php'); ?>
<?php include(APPPATH . 'views/_partials/footer.php'); ?>