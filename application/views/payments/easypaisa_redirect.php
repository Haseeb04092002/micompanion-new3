<form id="epForm" method="post"
      action="<?= $this->config->item('easypaisa')['init_url'] ?>">

  <input type="hidden" name="storeId" value="<?= $store_id ?>">
  <input type="hidden" name="orderId" value="<?= $order_id ?>">
  <input type="hidden" name="amount" value="<?= $amount ?>">
  <input type="hidden" name="hash" value="<?= $hash ?>">
  <input type="hidden" name="postBackURL" value="<?= $callback ?>">

</form>

<script>
document.getElementById('epForm').submit();
</script>
