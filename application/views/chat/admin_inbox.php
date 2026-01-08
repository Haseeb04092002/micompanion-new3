<?php
include(APPPATH.'views/_partials/header.php');
$page_title = "Chat Inbox";
include(APPPATH.'views/_partials/topbar.php');
?>

<div class="container py-3">
  <div class="list-group">
    <?php foreach($threads as $t): ?>
      <a class="list-group-item list-group-item-action"
         href="<?= site_url('admin/admin_chat/with/'.$t['other_user_id']) ?>">
        <div class="d-flex justify-content-between">
          <div>
            <strong>User #<?= (int)$t['other_user_id'] ?></strong>
            <div class="small text-muted">Thread #<?= (int)$t['thread_id'] ?></div>
          </div>
          <div class="small text-muted">
            <?= date('d-M H:i', strtotime($t['created_at'])) ?>
          </div>
        </div>
      </a>
    <?php endforeach; ?>
  </div>
</div>

<?php include(APPPATH.'views/_partials/footer.php'); ?>
