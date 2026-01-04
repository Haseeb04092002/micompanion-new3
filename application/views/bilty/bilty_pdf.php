<!doctype html>
<html>
<head>
<style>
body{font-family:DejaVu Sans;font-size:12px}
.h{color:#ef6c00;font-size:20px;font-weight:bold}
.box{border:1px solid #000;padding:10px;margin-bottom:10px}
</style>
</head>
<body>

<div class="h">Cargo Delivery Bilty</div>
<hr>

<div class="box">
<b>Bilty Code:</b> <?= $b['bilty_code'] ?><br>
<b>Date:</b> <?= date('d-M-Y',strtotime($b['created_at'])) ?>
</div>

<div class="box">
<b>From:</b> <?= $b['loc_from'] ?> (<?= $b['city_from'] ?>)<br>
<b>To:</b> <?= $b['loc_to'] ?> (<?= $b['city_to'] ?>)
</div>

<div class="box">
<b>Cargo Category:</b> <?= $b['cargo_category'] ?><br>
<b>Units:</b> <?= $b['units'] ?><br>
<b>Vehicle Type:</b> <?= $b['vehicle_type'] ?>
</div>

<div class="box">
<b>Status:</b> <?= strtoupper($b['status']) ?>
</div>

<p style="text-align:center;margin-top:30px">
This is a system generated bilty.
</p>

</body>
</html>
