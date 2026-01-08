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
      $logout_url = base_url('admin/admin_auth/logout');
      break;
  case 'driver':
      $logout_url = base_url('driver/driver_auth/logout');
      break;
  case 'customer':
      $logout_url = base_url('customer/customer_auth/logout');
      break;
}
?>

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
    <h5 class="offcanvas-title"
      id="appMenuLabel"
      style="color:var(--orange)">
      MiCompanion
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
      target="_blank"
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