<?php
include(APPPATH.'views/_partials/header.php');
$page_title = "Chat Inbox";
include(APPPATH.'views/_partials/topbar.php');
?>

<div class="container py-3">

  <!-- TABS -->
  <ul class="nav nav-tabs mb-3" role="tablist">
    <li class="nav-item" role="presentation">
      <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#customers">
        Customers
      </button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" data-bs-toggle="tab" data-bs-target="#drivers">
        Drivers
      </button>
    </li>
  </ul>

  <div class="tab-content">

    <!-- CUSTOMERS TAB -->
    <div class="tab-pane fade show active" id="customers">
      <?php if (empty($threads_customers)): ?>
        <div class="text-muted text-center py-4">No customer chats</div>
      <?php endif; ?>

      <?php foreach ($threads_customers as $t): ?>
        <div class="card mb-2 shadow-sm">
          <div class="card-body">

            <div class="d-flex justify-content-between align-items-start">

              <div>
                <span class="badge bg-primary mb-1">Customer</span>
                <div class="fw-bold"><?= htmlspecialchars($t['name']) ?></div>
                <div class="small text-muted">
                  ID: <?= (int)$t['user_id'] ?> |
                  <?= htmlspecialchars($t['phone']) ?>
                </div>
              </div>

              <div class="text-end">
                <div class="small text-muted">
                  <?= date('d-M h:i A', strtotime($t['last_msg_at'])) ?>
                </div>
                <a href="<?= site_url('admin/admin_chat/with/'.$t['user_id']) ?>"
                   class="btn btn-sm btn-outline-primary mt-2">
                  Chat
                </a>
              </div>

            </div>

          </div>
        </div>
      <?php endforeach; ?>
    </div>

    <!-- DRIVERS TAB -->
    <div class="tab-pane fade" id="drivers">
      <?php if (empty($threads_drivers)): ?>
        <div class="text-muted text-center py-4">No driver chats</div>
      <?php endif; ?>

      <?php foreach ($threads_drivers as $t): ?>
        <div class="card mb-2 shadow-sm">
          <div class="card-body">

            <div class="d-flex justify-content-between align-items-start">

              <div>
                <span class="badge bg-warning text-dark mb-1">Driver</span>
                <div class="fw-bold"><?= htmlspecialchars($t['name']) ?></div>
                <div class="small text-muted">
                  ID: <?= (int)$t['user_id'] ?> |
                  <?= htmlspecialchars($t['phone']) ?>
                </div>
              </div>

              <div class="text-end">
                <div class="small text-muted">
                  <?= date('d-M h:i A', strtotime($t['last_msg_at'])) ?>
                </div>
                <a href="<?= site_url('admin/admin_chat/with/'.$t['user_id']) ?>"
                   class="btn btn-sm btn-outline-warning mt-2">
                  Chat
                </a>
              </div>

            </div>

          </div>
        </div>
      <?php endforeach; ?>
    </div>

  </div>
</div>

<?php include(APPPATH.'views/_partials/footer.php'); ?>
