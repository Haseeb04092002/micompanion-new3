<div class="p-3 bg-white border-bottom sticky-top">
  <div class="d-flex align-items-center justify-content-between">
    <div class="fw-bold" style="color:var(--orange)"><?= isset($page_title)?$page_title:'Dashboard' ?></div>
    <div class="d-flex gap-2">
      <?php if(isset($logout_url)): ?>
        <a class="btn btn-sm btn-outline-dark" href="<?= site_url($logout_url) ?>">Logout</a>
      <?php endif; ?>
    </div>
  </div>
</div>
