<?php include(APPPATH.'views/_partials/header.php'); ?>
<?php $page_title="Messages"; $logout_url="admin/admin_auth/logout"; include(APPPATH.'views/_partials/topbar.php'); ?>
<?php include(APPPATH.'views/_partials/alerts.php'); ?>

<div class="container pb-4">
  <div class="px-2">

    <?php if(empty($threads)): ?>
      <div class="alert alert-info">No conversations yet.</div>
    <?php endif; ?>

    <?php foreach($threads as $t): ?>
      <a class="card card-soft p-3 mb-2 d-block text-decoration-none"
         href="<?= site_url('admin/admin_chat/thread/'.$t['thread_id']) ?>">

        <div class="d-flex justify-content-between align-items-center">
          <div class="fw-bold">
            <?= htmlspecialchars($t['peer_name']) ?>
            <span class="badge bg-secondary ms-1">
              <?= ucfirst(htmlspecialchars($t['peer_role'])) ?>
            </span>
          </div>

          <?php if((int)$t['unread_count'] > 0): ?>
            <span class="badge bg-primary">
              <?= (int)$t['unread_count'] ?>
            </span>
          <?php endif; ?>
        </div>

        <div class="small text-muted mt-1">
          <?= htmlspecialchars($t['last_message'] ?: 'No messages yet') ?>
        </div>

        <div class="small text-muted mt-1">
          <?= date('d M Y, h:i A', strtotime($t['updated_at'])) ?>
        </div>

      </a>
    <?php endforeach; ?>

  </div>
</div>

<?php include(APPPATH.'views/_partials/bottom_admin.php'); ?>
<?php include(APPPATH.'views/_partials/footer.php'); ?>
