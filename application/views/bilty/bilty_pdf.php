<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">

  <style>
    body {
      font-family: DejaVu Sans;
      font-size: 12px;
      margin: 10px;
    }

    /* HEADER & FOOTER */
    .header, .footer {
      width: 100%;
      border-bottom: 1px solid #000;
      margin-bottom: 10px;
      padding-bottom: 6px;
    }

    .footer {
      border-top: 1px solid #000;
      border-bottom: none;
      margin-top: 20px;
      padding-top: 6px;
      font-size: 11px;
      text-align: center;
    }

    .header-table {
      width: 100%;
    }

    .header-table td {
      vertical-align: middle;
    }

    .company-name {
      font-size: 42px;
      font-weight: bold;
      color: #e30613;
      text-align: center;
      letter-spacing: 1px;
    }

    .logo img {
      width: 80px;
    }

    /* SECTIONS */
    .section {
      border: 1px solid #000;
      padding: 8px;
      margin-bottom: 10px;
    }

    .section h4 {
      margin: 0 0 6px 0;
      font-size: 14px;
      border-bottom: 1px solid #000;
      padding-bottom: 3px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
    }

    td {
      padding: 4px;
      vertical-align: top;
    }

    .label {
      font-weight: bold;
      width: 30%;
    }

    /* SIGNATURES */
    .sign-table td {
      height: 60px;
      vertical-align: bottom;
      text-align: center;
    }

    .sign-line {
      border-top: 1px solid #000;
      width: 80%;
      margin: 0 auto 4px;
    }

    /* QR */
    .qr-box {
      text-align: center;
      margin-top: 25px;
    }
  </style>
</head>

<body>

<!-- ================= HEADER ================= -->
<div class="header">
  <table class="header-table">
    <tr>
      <td class="logo" width="20%">
        <!-- <img src="<?= base_url('assets/images/pdf-logo.png') ?>" alt="aramex"> -->
      </td>
      <td class="company-name" width="60%">
        aramex
      </td>
      <td width="20%"></td>
    </tr>
  </table>
</div>

<!-- ================= BASIC INFO ================= -->
<div class="section">
  <table>
    <tr>
      <td class="label">Bilty Code</td>
      <td><?= $b['bilty_code'] ?></td>
      <td class="label">Booking Date</td>
      <td><?= date('d-M-Y', strtotime($b['created_at'])) ?></td>
    </tr>
    <tr>
      <td class="label">Cargo Status</td>
      <td><?= strtoupper($b['status']) ?></td>
      <td class="label">Payment Status</td>
      <td><?= !empty($b['payment_status']) ? strtoupper($b['payment_status']) : 'UNPAID' ?></td>
    </tr>
  </table>
</div>

<!-- ================= CUSTOMER DETAILS ================= -->
<div class="section">
  <h4>Customer Details</h4>
  <table>
    <tr>
      <td class="label">Name</td>
      <td><?= $b['customer_name'] ?></td>
      <td class="label">Phone</td>
      <td><?= $b['customer_phone'] ?></td>
    </tr>
    <tr>
      <td class="label">CNIC</td>
      <td><?= $b['customer_cnic'] ?></td>
      <td class="label">Email</td>
      <td><?= $b['customer_email'] ?></td>
    </tr>
  </table>
</div>

<!-- ================= PICKUP & DROP ================= -->
<div class="section">
  <h4>Pickup & Drop-off</h4>
  <table>
    <tr>
      <td class="label">From City</td>
      <td><?= $b['city_from'] ?></td>
      <td class="label">Pickup Location</td>
      <td><?= $b['loc_from'] ?></td>
    </tr>
    <tr>
      <td class="label">To City</td>
      <td><?= $b['city_to'] ?></td>
      <td class="label">Drop Location</td>
      <td><?= $b['loc_to'] ?></td>
    </tr>
  </table>
</div>

<!-- ================= CARGO DETAILS ================= -->
<div class="section">
  <h4>Cargo Details</h4>
  <table>
    <tr>
      <td class="label">Cargo Category</td>
      <td><?= $b['cargo_category'] ?></td>
      <td class="label">Units</td>
      <td><?= $b['units'] ?></td>
    </tr>
    <tr>
      <td class="label">Vehicle Type</td>
      <td colspan="3"><?= $b['vehicle_type'] ?></td>
    </tr>
  </table>
</div>

<!-- ================= DRIVER & VEHICLE ================= -->
<?php if (!empty($b['driver_name'])): ?>
<div class="section">
  <h4>Driver & Vehicle Details</h4>
  <table>
    <tr>
      <td class="label">Driver Name</td>
      <td><?= $b['driver_name'] ?></td>
      <td class="label">Phone</td>
      <td><?= $b['driver_phone'] ?></td>
    </tr>
    <tr>
      <td class="label">CNIC</td>
      <td><?= $b['driver_cnic'] ?></td>
      <td class="label">License No</td>
      <td><?= $b['driver_license_no'] ?></td>
    </tr>
    <tr>
      <td class="label">Vehicle</td>
      <td colspan="3">
        <?= $b['vehicle_category'] ?> - <?= $b['vehicle_name'] ?> (<?= $b['vehicle_model'] ?>)
      </td>
    </tr>
  </table>
</div>
<?php endif; ?>

<!-- ================= SIGNATURES ================= -->
<div class="section">
  <h4>Signatures</h4>
  <table class="sign-table">
    <tr>
      <td>
        <div class="sign-line"></div>
        Customer Signature
      </td>
      <td>
        <div class="sign-line"></div>
        Driver Signature
      </td>
    </tr>
  </table>
</div>

<!-- ================= QR CODE ================= -->
<?php
  $qr_url = base_url(); // Change to Play Store URL later
  $qr_img = "https://chart.googleapis.com/chart?chs=120x120&cht=qr&chl=" . urlencode($qr_url);
?>
<div class="qr-box">
  <img src="<?= $qr_img ?>" alt="QR Code">
  <div style="font-size:11px;margin-top:6px">
    Scan to download our app
  </div>
</div>

<!-- ================= FOOTER ================= -->
<div class="footer">
  Contact: 0336-8438235 |
  Email: records@aramex-pk.com |
  Address: Lahore, Chakwal, Pakistan
</div>

</body>
</html>
