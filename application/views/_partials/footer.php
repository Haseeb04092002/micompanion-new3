<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
if ('serviceWorker' in navigator) {

  navigator.serviceWorker.register('/service-worker.js');

  // 🔁 Check for updates every 5 seconds
  setInterval(() => {
    navigator.serviceWorker.getRegistration().then(reg => {
      if (reg) reg.update();
    });
  }, 5000);

  // 🔔 When new SW is ready
  navigator.serviceWorker.addEventListener('controllerchange', () => {
    console.log('New version activated');
    window.location.reload();
  });
}
function forceUpdateApp() {
  if (!('serviceWorker' in navigator)) return;

  navigator.serviceWorker.getRegistration().then(reg => {
    if (reg && reg.waiting) {
      reg.waiting.postMessage('SKIP_WAITING');
    }

    caches.keys().then(keys => {
      Promise.all(keys.map(k => caches.delete(k))).then(() => {
        window.location.reload(true);
      });
    });
  });
}
</script>

<script>
(function () {
  const loader = document.getElementById('pageLoader');

  function showLoader() {
    if (loader) loader.classList.remove('d-none');
  }

  function hideLoader() {
    if (loader) loader.classList.add('d-none');
  }

  /* -----------------------------
     Show loader on link clicks
     ----------------------------- */
  document.addEventListener('click', function (e) {
    const link = e.target.closest('a');
    if (!link) return;

    const href = link.getAttribute('href');
    if (!href || href.startsWith('#') || href.startsWith('javascript')) return;
    if (link.hasAttribute('target')) return;

    showLoader();
  });

  /* -----------------------------
     Show loader on form submit
     ----------------------------- */
  document.addEventListener('submit', function () {
    showLoader();
  });

  /* -----------------------------
     Expose manual controls
     ----------------------------- */
  window.showPageLoader = showLoader;
  window.hidePageLoader = hideLoader;

})();
</script>

</body>
</html>
