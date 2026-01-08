<?php include(APPPATH.'views/_partials/header.php'); ?>
<?php $page_title=$chat_with_name; include(APPPATH.'views/_partials/topbar.php'); ?>

<div class="container pb-5">

  <!-- CHAT MESSAGES -->
  <div class="mb-3" style="min-height:65vh;">
    <?php foreach($messages as $m): ?>
      <div class="d-flex mb-2 <?= $m['is_me'] ? 'justify-content-end' : 'justify-content-start' ?>">
        <div class="p-2 rounded"
             style="max-width:75%;
                    background:<?= $m['is_me'] ? '#dcf8c6' : '#f1f1f1' ?>;">
          <div><?= nl2br(htmlspecialchars($m['message'])) ?></div>
          <div class="small text-muted text-end">
            <?= date('h:i A', strtotime($m['created_at'])) ?>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>

  <!-- MESSAGE BOX -->
  <form method="post" class="position-fixed bottom-0 start-0 end-0 bg-white p-2 border-top">
    <div class="d-flex gap-2">
      <input type="text"
             name="message"
             class="form-control"
             placeholder="Type a message..."
             required>

      <button class="btn btn-orange">
        <i class="bi bi-send"></i>
      </button>
    </div>
  </form>

</div>

<?php include(APPPATH.'views/_partials/footer.php'); ?>
