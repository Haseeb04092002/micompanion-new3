<?php $title="Customer Notifications"; include(APPPATH.'views/_partials/header.php'); ?>
<?php $page_title="Notifications"; $logout_url="customer/customer_auth/logout"; include(APPPATH.'views/_partials/topbar.php'); ?>
<?php include(APPPATH.'views/_partials/alerts.php'); ?>

<div class="container pb-4">
  <div class="px-2">

    <?php if(empty($rows)): ?>
      <div class="alert alert-info">No notifications available.</div>
    <?php else: ?>

      <?php foreach($rows as $n): ?>
        <div class="card card-soft p-3 mb-2 <?= $n['is_read'] ? '' : 'border-warning' ?>">
          <div class="fw-bold"><?= htmlspecialchars($n['title']) ?></div>

          <div class="small text-muted mt-1">
            <?= htmlspecialchars($n['body']) ?>
          </div>

          <div class="small text-muted mt-2">
            <?= date('d M Y, h:i A', strtotime($n['created_at'])) ?>
          </div>

        </div>
      <?php endforeach; ?>

    <?php endif; ?>

  </div>
</div>

<?php include(APPPATH.'views/_partials/bottom_customer.php'); ?>
<?php include(APPPATH.'views/_partials/footer.php'); ?>
