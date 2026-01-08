<?php include(APPPATH.'views/_partials/header.php'); ?>
<?php $page_title="Chats"; include(APPPATH.'views/_partials/topbar.php'); ?>

<div class="container pb-4">

  <!-- TABS -->
  <ul class="nav nav-tabs mb-3">
    <li class="nav-item">
      <a class="nav-link active" data-bs-toggle="tab" href="#customers">
        Customers
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-bs-toggle="tab" href="#drivers">
        Drivers
      </a>
    </li>
  </ul>

  <div class="tab-content">

    <!-- CUSTOMER THREADS -->
    <div class="tab-pane fade show active" id="customers">
      <?php foreach($customer_threads as $t): ?>
        <a href="<?= site_url('admin/admin_chat/chat/customer/'.$t['user_id']) ?>"
           class="card card-soft p-3 mb-2 text-decoration-none">
          <div class="fw-bold"><?= htmlspecialchars($t['name']) ?></div>
          <div class="small text-muted"><?= htmlspecialchars($t['last_message']) ?></div>
        </a>
      <?php endforeach; ?>
    </div>

    <!-- DRIVER THREADS -->
    <div class="tab-pane fade" id="drivers">
      <?php foreach($driver_threads as $t): ?>
        <a href="<?= site_url('admin/admin_chat/chat/driver/'.$t['user_id']) ?>"
           class="card card-soft p-3 mb-2 text-decoration-none">
          <div class="fw-bold"><?= htmlspecialchars($t['name']) ?></div>
          <div class="small text-muted"><?= htmlspecialchars($t['last_message']) ?></div>
        </a>
      <?php endforeach; ?>
    </div>

  </div>
</div>

<?php include(APPPATH.'views/_partials/footer.php'); ?>
