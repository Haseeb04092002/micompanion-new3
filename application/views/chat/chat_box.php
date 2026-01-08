<?php
include(APPPATH.'views/_partials/header.php');
$page_title = $chat_with_name;
include(APPPATH.'views/_partials/topbar.php');

$user_role = $this->session->userdata('role'); // admin|driver|customer
?>

<div class="container chat-wrapper">

  <div id="chatMessages" class="mb-3" style="min-height:65vh;">
    <?php $this->load->view('chat/_messages', ['messages'=>$messages]); ?>
  </div>

  <!-- INPUT BAR (fixed above bottom nav) -->
  <form method="post"
        action="<?= $send_url ?>"
        class="position-fixed start-0 end-0 bg-white p-2 border-top"
        style="bottom:60px;">
    <div class="container">
      <div class="d-flex gap-2">
        <input type="text" name="message" class="form-control" placeholder="Type a message..." required autocomplete="off">
        <button class="btn btn-orange">
          <i class="bi bi-send"></i>
        </button>
      </div>
    </div>
  </form>

</div>

<?php
// bottom nav + footer (as you want both)
switch ($user_role) {
  case 'admin':    include(APPPATH.'views/_partials/bottom_admin.php'); break;
  case 'driver':   include(APPPATH.'views/_partials/bottom_driver.php'); break;
  case 'customer': include(APPPATH.'views/_partials/bottom_customer.php'); break;
}
include(APPPATH.'views/_partials/footer.php');
?>

<style>
.chat-wrapper{ padding-bottom: 140px; }
</style>

<script>
// Requires jQuery loaded in header/footer
let lastId = <?= (int)$last_id ?>;
const fetchUrl = "<?= $fetch_url ?>";

function fetchNewMessages(){
  $.get(fetchUrl, { last_id: lastId }, function(resp){
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
