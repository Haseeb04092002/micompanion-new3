<!doctype html>
<html lang="en">


<head>

  <!-- =========================
       CHARACTER & VIEWPORT (FIRST)
  ========================== -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">

  <!-- =========================
       PRIMARY SEO (VERY IMPORTANT)
  ========================== -->
  <title>Aramex Cargo : Aramex – Cargo Delivery & Logistics Management</title>

  <meta name="description" content="Aramex is a smart cargo delivery and logistics management platform for customers, drivers, and administrators. Track shipments, manage drivers, handle documents, payments, and deliveries in real time.">

  <meta name="keywords" content="cargo delivery, logistics management, freight management, shipment tracking, delivery app, transport management system, cargo software, logistics PWA, aramex cargo">

  <meta name="author" content="Aramex Logistics">
  <meta name="robots" content="index, follow">

  <!-- =========================
       OPEN GRAPH (READ EARLY BY WHATSAPP)
  ========================== -->
  <meta property="og:type" content="website">
  <meta property="og:site_name" content="Aramex Cargo">
  <meta property="og:title" content="Aramex – Cargo Delivery & Logistics Management">
  <meta property="og:description" content="Smart cargo delivery and logistics platform for customers, drivers, and admins. Real-time tracking, document approval, and payments.">
  <meta property="og:image" content="https://companion.itimium.com.pk/assets/images/og-image.png">
  <meta property="og:url" content="https://companion.itimium.com.pk/">

  <!-- =========================
       TWITTER / X (AFTER OG)
  ========================== -->
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:title" content="Aramex – Cargo Delivery & Logistics Management">
  <meta name="twitter:description" content="Manage cargo, drivers, documents, and deliveries with Aramex logistics platform.">
  <meta name="twitter:image" content="https://companion.itimium.com.pk/assets/images/og-image.png">

  <!-- =========================
       THEME / BRANDING
  ========================== -->
  <meta name="theme-color" content="#c60a00">
  <meta name="msapplication-TileColor" content="#c60a00">

  <!-- =========================
       PWA CONFIGURATION
  ========================== -->
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="default">
  <meta name="apple-mobile-web-app-title" content="Aramex Cargo">

  <link rel="manifest" href="/manifest.json">
  <link rel="apple-touch-icon" sizes="192x192" href="https://companion.itimium.com.pk/assets/icons/icon-192x192.png">
  <link rel="apple-touch-icon" sizes="512x512" href="https://companion.itimium.com.pk/assets/icons/icon-512x512.png">

  <!-- =========================
       FAVICONS
  ========================== -->
  <link rel="icon" type="image/png" sizes="32x32" href="https://companion.itimium.com.pk/assets/icons/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="https://companion.itimium.com.pk/assets/icons/favicon-16x16.png">

  <!-- =========================
       STYLES (LAST)
  ========================== -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link href="<?= base_url('assets/css/app.css') ?>" rel="stylesheet">

</head>




<body class="bg-light">

  <!-- NATIVE APP SPLASH -->
  <div id="appSplash" class="app-splash">
    <div class="splash-inner">

      <img src="<?= base_url('assets/icons/icon-192x192.png') ?>"
        alt="aramex"
        class="splash-logo">

      <div class="splash-title">aramex</div>
      <div class="splash-tagline">Your Smart Cargo Companion</div>

    </div>
  </div>


  <script>
    (function() {

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