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


<div id="globalAlert"
     class="position-fixed top-0 start-50 translate-middle-x mt-3"
     style="z-index:9999; display:none;">

  <div class="alert alert-primary shadow d-flex align-items-start gap-3"
       role="alert"
       style="min-width:320px; max-width:90vw;">

    <i class="bi bi-bell fs-4"></i>

    <div>
      <div id="alertTitle" class="fw-bold">Notification</div>
      <div id="alertBody" class="small"></div>
    </div>

    <button type="button" class="btn-close ms-auto"
      onclick="hideGlobalAlert()"></button>

  </div>
</div>




<!-- GLOBAL PAGE LOADER -->
<!-- <div id="pageLoader" class="page-loader d-none">
  <div class="loader-content text-center">
    <div class="spinner-border text-warning mb-3"
         role="status"
         style="width:3rem;height:3rem;">
    </div>

    <div class="fw-bold" style="color:var(--orange);">
      Please wait...
    </div>
  </div>
</div> -->

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

let lastNotiId = 0;

function showGlobalAlert(title, body, clickUrl = null) {
  $('#alertTitle').text(title);
  $('#alertBody').text(body);
  $('#globalAlert').fadeIn();

  if (clickUrl) {
    $('#globalAlert').off('click').on('click', function () {
      window.location.href = clickUrl;
    });
  }

  setTimeout(hideGlobalAlert, 5000);
}

function hideGlobalAlert() {
  $('#globalAlert').fadeOut();
}

function pollNotifications() {
  $.get("<?= site_url('notifications/poll') ?>", { last_id: lastNotiId }, function(res){
    if (!res || !res.notifications) return;

    res.notifications.forEach(function(n){
      lastNotiId = n.noti_id;

      let url = '#';
      if (n.ref_type === 'chat') {
        url = n.chat_url;
      }

      showGlobalAlert(n.title, n.body, url);
    });
  }, 'json');
}

setInterval(pollNotifications, 3000);

</script>

