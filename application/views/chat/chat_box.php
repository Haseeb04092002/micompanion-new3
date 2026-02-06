<?php
include(APPPATH . 'views/_partials/header.php');
$page_title = "Chat with " . $chat_with_name;
include(APPPATH . 'views/_partials/topbar.php');

$user_role = $this->session->userdata('role'); // admin|driver|customer
?>

<div class="container-fluid chat-wrapper px-0">

  <!-- CHAT BODY -->
  <div id="chatMessages"
    class="chat-body px-3 pt-3 pb-5"
    style="min-height:70vh; background:#efeae257;">

    <?php $this->load->view('chat/_messages', ['messages' => $messages]); ?>

  </div>

  <!-- INPUT BAR (WhatsApp Style) -->
  <form method="post"
    action="<?= $send_url ?>"
    class="chat-input-bar position-fixed start-0 end-0 border-top"
    style="bottom:60px; background:#f0f0f0;">

    <div class="container py-2">
      <div class="d-flex align-items-center gap-2">

        <input type="text"
          name="message"
          class="form-control rounded-pill px-3"
          placeholder="Type a message"
          autocomplete="off"
          required>

        <button class="btn btn-orange rounded-circle"
          style="width:42px;height:42px;">
          <i class="bi bi-send-fill"></i>
        </button>

      </div>
    </div>
  </form>

</div>


<?php
// bottom nav + footer (as you want both)
switch ($user_role) {
  case 'admin':
    include(APPPATH . 'views/_partials/bottom_admin.php');
    break;
  case 'driver':
    include(APPPATH . 'views/_partials/bottom_driver.php');
    break;
  case 'customer':
    include(APPPATH . 'views/_partials/bottom_customer.php');
    break;
}
include(APPPATH . 'views/_partials/footer.php');
?>

<style>
  /* CHAT BODY */
  .chat-body {
    overflow-y: auto;
  }

  /* CHAT BUBBLES */
  .chat-bubble {
    max-width: 75%;
    padding: 8px 12px;
    border-radius: 8px;
    font-size: 14px;
    line-height: 1.4;
    position: relative;
    word-wrap: break-word;
  }

  /* OUTGOING (Me) */
  .chat-outgoing {
    background: #dcf8c6;
    border-top-right-radius: 0;
  }

  /* INCOMING */
  .chat-incoming {
    background: #ffffff;
    border-top-left-radius: 0;
  }

  /* TIME */
  .chat-time {
    font-size: 11px;
    color: #777;
    margin-top: 4px;
    text-align: right;
  }

  /* INPUT BAR */
  .chat-input-bar {
    z-index: 1030;
  }
</style>
<script>
  // Requires jQuery loaded in header/footer
  let lastId = <?= (int)$last_id ?>;
  const fetchUrl = "<?= $fetch_url ?>";

  function fetchNewMessages() {
    $.get(fetchUrl, {
      last_id: lastId
    }, function(resp) {
      if (!resp) return;
      if (resp.html && resp.html.trim() !== '') {
        $('#chatMessages').append(resp.html);
        lastId = parseInt(resp.last_id || lastId, 10);

        // auto scroll to bottom
        window.scrollTo(0, document.body.scrollHeight);
      }
    }, 'json');
  }

  setInterval(fetchNewMessages, 2000);
</script>