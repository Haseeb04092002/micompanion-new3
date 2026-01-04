<div class="p-3 bg-white border-bottom sticky-top">
  <div class="position-relative d-flex align-items-center">

    <!-- LEFT: LOGO -->
    <div class="d-flex align-items-center">
      <img src="<?= base_url('assets/icons/icon-192x192.png') ?>"
           alt="MiCompanion"
           style="height:32px;width:auto;">
    </div>

    <!-- CENTER: PAGE TITLE -->
    <div class="position-absolute start-50 translate-middle-x fw-bold"
         style="color:var(--orange);">
      <?= isset($page_title) ? $page_title : 'Dashboard' ?>
    </div>

    <!-- RIGHT: ACTIONS -->
    <div class="ms-auto d-flex gap-2">
      <?php if(isset($logout_url)): ?>
        <a class="btn btn-sm btn-outline-dark"
           href="<?= site_url($logout_url) ?>">
          Logout
        </a>
      <?php endif; ?>
    </div>

  </div>
</div>
