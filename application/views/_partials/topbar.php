<!-- TOP APP BAR -->
<div class="p-3 bg-white border-bottom sticky-top">
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

    <!-- RIGHT: LOGOUT -->
    <div class="ms-auto">
      <?php if(isset($logout_url)): ?>
        <a class="btn btn-sm btn-outline-dark"
           href="<?= site_url($logout_url) ?>">
          Logout
        </a>
      <?php endif; ?>
    </div>

  </div>
</div>

<!-- OFFCANVAS MENU -->
<div class="offcanvas offcanvas-start"
     tabindex="-1"
     id="appMenu"
     aria-labelledby="appMenuLabel">

  <div class="offcanvas-header border-bottom">
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

    <a href="<?= site_url('pages/about') ?>"
       class="d-flex align-items-center gap-3 px-3 py-3 border-bottom text-decoration-none">
      <i class="bi bi-info-circle fs-5"></i>
      <span>About Us</span>
    </a>

    <a href="<?= site_url('pages/how_to_use') ?>"
       class="d-flex align-items-center gap-3 px-3 py-3 border-bottom text-decoration-none">
      <i class="bi bi-question-circle fs-5"></i>
      <span>How to Use?</span>
    </a>

    <a href="<?= site_url('pages/support') ?>"
       class="d-flex align-items-center gap-3 px-3 py-3 border-bottom text-decoration-none">
      <i class="bi bi-headset fs-5"></i>
      <span>Support & Help</span>
    </a>

    <a href="<?= site_url('pages/developers') ?>"
       class="d-flex align-items-center gap-3 px-3 py-3 text-decoration-none">
      <i class="bi bi-code-slash fs-5"></i>
      <span>About Developers</span>
    </a>

  </div>
</div>
