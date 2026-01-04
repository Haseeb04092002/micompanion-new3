<!doctype html>
<html lang="en">

<head>
  
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="default">
  <meta name="theme-color" content="#c60a00">
  <meta name="description" content="MiCompanion – Smart cargo and logistics management app for customers, drivers, and admins.">

  <title><?= isset($title) ? $title : 'Cargo PWA' ?></title>
  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link href="<?= base_url('assets/css/app.css') ?>" rel="stylesheet">
  <link rel="manifest" href="/manifest.json">
  <link rel="apple-touch-icon" href="<?= base_url('assets/icons/icon-192x192.png') ?>">

</head>

<body class="bg-light">

<!-- GLOBAL PAGE LOADER -->
<div id="pageLoader"
     class="position-fixed top-0 start-0 w-100 h-100 d-none
            align-items-center justify-content-center"
     style="background:rgba(255,255,255,.85); z-index:2000;">

  <div class="text-center">
    <div class="spinner-border text-warning mb-3"
         role="status"
         style="width:3rem;height:3rem;">
    </div>

    <div class="fw-bold" style="color:var(--orange);">
      Please wait...
    </div>
    <div class="small text-muted">
      Processing your request
    </div>
  </div>

</div>
