<?php
include(APPPATH.'views/_partials/header.php');
$page_title = $chat_with_name;
include(APPPATH.'views/_partials/topbar.php');

$user_role = $this->session->userdata('role');
?>

<div class="container chat-wrapper">

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

  <!-- CHAT INPUT BAR -->
  <form method="post"
        class="position-fixed start-0 end-0 bg-white p-2 border-top"
        style="bottom:60px;">
    <div class="d-flex gap-2">
      <input type="text" name="message" class="form-control" placeholder="Type a message..." required>
      <button class="btn btn-orange">
        <i class="bi bi-send"></i> <?= $user_role ?>
      </button>
    </div>
  </form>

</div>

<?php
// 🔹 BOTTOM NAVIGATION
switch ($user_role) {
    case 'admin':
        include(APPPATH.'views/_partials/bottom_admin.php');
        break;
    case 'driver':
        include(APPPATH.'views/_partials/bottom_driver.php');
        break;
    case 'customer':
        include(APPPATH.'views/_partials/bottom_customer.php');
        break;
}

// 🔹 FOOTER
include(APPPATH.'views/_partials/footer.php');
?>
