const CACHE_NAME = "micompanion-v1.0"; // Add versioning for easier updates
const urlsToCache = [

  "<?= base_url('index.php/micompanion'); ?>",
  "<?= base_url('manifest.json'); ?>",

  // CSS
  "<?= base_url('assets/css/bootstrap5.min.css'); ?>",
  "<?= base_url('assets/css/cropper.min.css'); ?>",
  "<?= base_url('assets/css/swiper-bundle.min.css'); ?>",
  "<?= base_url('assets/css/style.css'); ?>",
  "<?= base_url('assets/css/style_responsive.css'); ?>",
  "<?= base_url('assets/css/animated_cards.css'); ?>",
  "https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css",
  "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css",
  "https://fonts.googleapis.com",
  "https://fonts.gstatic.com",
  "https://fonts.googleapis.com/css2?family=Aclonica&family=Arapey:ital@0;1&family=Comic+Relief:wght@400;700&family=IBM+Plex+Sans:ital,wght@0,100..700;1,100..700&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Josefin+Sans:ital,wght@0,100..700;1,100..700&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Mulish:ital,wght@0,200..1000;1,200..1000&family=Nunito:ital,wght@0,200..1000;1,200..1000&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Oswald:wght@200..700&family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Urbanist:ital,wght@0,100..900;1,100..900&family=Yeseva+One&display=swap",


  // JS
  "<?= base_url('assets/js/bootstrap5.bundle.min.js'); ?>",
  "<?= base_url('assets/js/swiper-bundle.min.js'); ?>",
  "<?= base_url('assets/js/cropper.min.js'); ?>",
  "<?= base_url('assets/js/chart.js'); ?>",
  "<?= base_url('assets/js/haseeb.js'); ?>",

  // Icons
  "<?= base_url('assets/icons/icon-192x192.png'); ?>",
  "<?= base_url('assets/icons/icon-512x512.png'); ?>"
];

// INSTALL - cache essential files
self.addEventListener("install", event => {
  event.waitUntil(
    caches.open(CACHE_NAME).then(cache => {
      return cache.addAll(urlsToCache);
    }).catch(err => {
      console.error("Failed to cache resources on install:", err);
    })
  );
});

// ACTIVATE - clean up old caches if needed
self.addEventListener("activate", event => {
  event.waitUntil(
    caches.keys().then(cacheNames =>
      Promise.all(
        cacheNames.map(name => {
          if (name !== CACHE_NAME) {
            return caches.delete(name);
          }
        })
      )
    )
  );
});

// FETCH - return cached response or fetch from network
self.addEventListener("fetch", event => {
  event.respondWith(
    caches.match(event.request).then(response => {
      return response || fetch(event.request);
    }).catch(err => {
      console.error("Fetch failed:", err);
      return fetch(event.request);
    })
  );
});
