<?php
// Auto-detect role from session
$role_label = 'Dashboard';

if ($this->session->userdata('admin_id')) {
  $role_label = 'Admin';
} elseif ($this->session->userdata('driver_id')) {
  $role_label = 'Driver';
} elseif ($this->session->userdata('customer_id')) {
  $role_label = 'Customer';
}
$user_role = $this->session->userdata('role');
$logout_url = '';
// 🔹 BOTTOM NAVIGATION
switch ($user_role) {
  case 'admin':
    $logout_url = 'admin/admin_auth/logout';
    break;
  case 'driver':
    $logout_url = 'driver/driver_auth/logout';
    break;
  case 'customer':
    $logout_url = 'customer/Customer_auth/logout';
    break;
}
?>

<style>
  /* Bell button */
  .notif-btn {
    background: #f8f9fa;
    border: none;
    position: relative;
    padding: 6px 10px;
    border-radius: 50%;
    cursor: pointer;
    font-size: 18px;
  }

  .notif-badge {
    position: absolute;
    top: -3px;
    right: -3px;
    background: #dc3545;
    color: #fff;
    font-size: 11px;
    padding: 2px 6px;
    border-radius: 10px;
  }

  /* Overlay */
  .notif-overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, 0.4);
    z-index: 9998;
  }

  /* Modal */
  .notif-modal {
    display: none;
    position: fixed;
    right: 10px;
    top: 60px;
    width: 360px;
    max-height: 80vh;
    background: #fff;
    border-radius: 14px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.25);
    z-index: 9999;
    overflow: hidden;
  }

  /* Mobile full screen */
  @media (max-width: 576px) {
    .notif-modal {
      right: 0;
      top: 0;
      width: 100%;
      height: 100%;
      max-height: 100%;
      border-radius: 0;
    }
  }

  /* Header */
  .notif-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px 15px;
    font-weight: bold;
    border-bottom: 1px solid #ddd;
  }

  .notif-header button {
    border: none;
    background: none;
    font-size: 20px;
    cursor: pointer;
  }

  /* Body */
  .notif-body {
    overflow-y: auto;
    max-height: calc(80vh - 50px);
  }

  /* Notification item */
  .notif-item {
    padding: 12px 15px;
    border-bottom: 1px solid #eee;
  }

  .notif-item.unread {
    background: #fff;
  }

  .notif-item.read {
    background: #f5f5f5;
  }

  .notif-item b {
    display: block;
  }
</style>

<div class="bg-primary border-bottom sticky-top">
  <div class="container p-0">
    <div class="text-center text-secondary fw-bold"
      style="color:var(--orange); font-size:14px;">
      <?= $role_label ?>
    </div>
  </div>
</div>


<!-- TOP APP BAR -->
<div class="px-3 py-2 bg-white border-bottom sticky-top">
  <div class="position-relative d-flex align-items-center">

    <!-- LEFT: MENU BUTTON + LOGO -->
    <div class="d-flex align-items-center gap-2">
      <!-- Offcanvas Toggle -->
      <button class="btn btn-sm btn-outline-dark"
        type="button"
        data-bs-toggle="offcanvas"
        data-bs-target="#appMenu"
        aria-controls="appMenu">
        <i class="bi bi-list"></i>
      </button>

      <!-- Logo -->
      <img src="<?= base_url('assets/icons/icon-192x192.png') ?>"
        alt="MiCompanion"
        style="height:32px;width:auto;">
    </div>

    <!-- CENTER: PAGE TITLE -->
    <div class="position-absolute start-50 translate-middle-x fw-bold"
      style="color:var(--orange);">
      <?= isset($page_title) ? $page_title : 'Dashboard' ?>
    </div>

    <!-- RIGHT: CHAT -->
    <div class="ms-auto">

      <button class="notif-btn" onclick="openNotifModal()">
        🔔
        <span id="notifBadge" class="notif-badge"></span>
      </button>

      <div id="notifOverlay" class="notif-overlay" onclick="closeNotifModal()"></div>

      <div id="notifModal" class="notif-modal">
        <div class="notif-header">
          <span>Notifications</span>
          <button onclick="closeNotifModal()">✕</button>
        </div>

        <div class="notif-body" id="notifList">
          <div class="p-3 text-muted">Loading…</div>
        </div>
      </div>


      <audio id="notifSound" preload="auto">
        <source src="<?= base_url('assets/sounds/notify.mp3') ?>" type="audio/mpeg">
      </audio>

      <?php
      $chat_url = '#';

      if ($this->session->userdata('admin_id')) {
        $chat_url = site_url('admin/admin_chat');
      } elseif ($this->session->userdata('customer_id')) {
        $chat_url = site_url('customer/customer_chat');
      } elseif ($this->session->userdata('driver_id')) {
        $chat_url = site_url('driver/driver_chat');
      }
      ?>
      <a class="btn btn-sm btn-outline-dark" href="<?= $chat_url ?>">
        <i class="bi bi-chat-text fs-4"></i>
      </a>
    </div>


  </div>
</div>

<!-- OFFCANVAS MENU -->
<div class="offcanvas offcanvas-start"
  tabindex="-1"
  id="appMenu"
  aria-labelledby="appMenuLabel">

  <div class="offcanvas-header border-bottom">
    <img src="<?= base_url('assets/icons/icon-192x192.png') ?>"
      alt="MiCompanion"
      style="height:32px;width:auto;">
    <h5 class="offcanvas-title ps-2 fs-3"
      id="appMenuLabel"
      style="color:var(--orange)">
       aramex
    </h5>
    <button type="button"
      class="btn-close"
      data-bs-dismiss="offcanvas"
      aria-label="Close"></button>
  </div>

  <div class="offcanvas-body p-0">

    <a href="<?= site_url('Welcome/about') ?>"
      class="d-flex align-items-center gap-3 px-3 py-3 border-bottom text-decoration-none">
      <i class="bi bi-info-circle fs-5"></i>
      <span>About Us</span>
    </a>

    <a target="_blank" href="https://www.youtube.com/watch?v=9eVYZ0LcrUo"
      class="d-flex align-items-center gap-3 px-3 py-3 border-bottom text-decoration-none">
      <i class="bi bi-question-circle fs-5"></i>
      <span>How to Use?</span>
    </a>

    <a class="d-flex align-items-center gap-3 px-3 py-3 border-bottom text-decoration-none"
      target="_blank"
      href="https://wa.me/923485467516">
      <i class="bi bi-whatsapp fs-5"></i> Chat on WhatsApp
    </a>

    <?php if (isset($logout_url)): ?>
      <a class="d-flex align-items-center gap-3 px-3 py-3 border-bottom text-decoration-none"
        href="<?= site_url($logout_url) ?>">
        <i class="bi bi-box-arrow-left fs-5"></i> Logout
      </a>
    <?php endif; ?>

    <a type="button" class="d-flex align-items-center gap-3 px-3 py-3 border-bottom text-decoration-none"
      onclick="forceUpdateApp()">
      <i class="bi bi-arrow-clockwise fs-5"></i> Update Version
    </a>

    <a target="_blank" href="https://itimium.com.pk/"
      class="d-flex align-items-center gap-3 px-3 py-3 text-decoration-none">
      <i class="bi bi-code-slash fs-5"></i>
      <span>About Developers</span>
    </a>

  </div>
</div>


<script>
  function openNotifModal() {
    document.getElementById('notifModal').style.display = 'block';
    document.getElementById('notifOverlay').style.display = 'block';
  }

  function closeNotifModal() {
    document.getElementById('notifModal').style.display = 'none';
    document.getElementById('notifOverlay').style.display = 'none';
  }

  let lastUnread = 0;
  let firstLoad = true;

  function loadNotifications() {
    fetch("<?= site_url('notifications/poll') ?>")
      .then(r => r.json())
      .then(d => {

        /* 🔔 SOUND */
        if (!firstLoad && d.unread > lastUnread) {
          const audio = document.getElementById('notifSound');
          if (audio) {
            audio.currentTime = 0;
            audio.play().catch(() => {});
          }
        }

        lastUnread = d.unread;
        firstLoad = false;

        document.getElementById('notifBadge').innerText =
          d.unread > 0 ? d.unread : '';

        let html = '';
        d.list.forEach(n => {
          html += `
<div class="notif-item ${n.is_read==0?'unread':'read'}">
  <b>${n.title}</b>
  <div class="small">${n.message}</div>
  ${n.is_read==0 ? `<button onclick="markRead(${n.id})">Mark read</button>` : ``}
</div>`;
        });

        document.getElementById('notifList').innerHTML =
          html || '<div class="p-3">No notifications</div>';
      });
  }

  function markRead(id) {
    fetch("<?= site_url('notifications/mark_read/') ?>" + id)
      .then(() => loadNotifications());
  }

  setInterval(loadNotifications, 2000);
  loadNotifications();


</script>