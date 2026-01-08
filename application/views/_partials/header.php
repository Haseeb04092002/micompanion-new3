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

<!-- NATIVE APP SPLASH -->
<div id="appSplash" class="app-splash">
  <div class="splash-inner">

    <img src="<?= base_url('assets/icons/icon-192x192.png') ?>"
         alt="MiCompanion"
         class="splash-logo">

    <div class="splash-title">MiCompanion</div>
    <div class="splash-tagline">Your Smart Cargo Companion</div>

  </div>
</div>



<!-- GLOBAL PAGE LOADER -->
<div id="pageLoader" class="page-loader d-none">
  <div class="loader-content text-center">
    <div class="spinner-border text-warning mb-3"
         role="status"
         style="width:3rem;height:3rem;">
    </div>

    <div class="fw-bold" style="color:var(--orange);">
      Please wait...
    </div>
  </div>
</div>

<script>
(function () {

  const splashKey = 'micompanion_splash_v1';
  const splash = document.getElementById('appSplash');

  // Disable scroll during splash
  document.body.style.overflow = 'hidden';

  if (!localStorage.getItem(splashKey)) {

    // First launch → show splash
    setTimeout(() => {
      splash.classList.add('hide');

      setTimeout(() => {
        splash.remove();
        document.body.style.overflow = '';
        localStorage.setItem(splashKey, '1');
      }, 700);

    }, 1800); // total splash time

  } else {

    // Already shown → remove instantly
    splash.remove();
    document.body.style.overflow = '';
  }

})();
</script>

