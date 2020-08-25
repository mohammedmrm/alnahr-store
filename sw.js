importScripts(
  "https://storage.googleapis.com/workbox-cdn/releases/4.3.1/workbox-sw.js"
);

self.addEventListener("message", (event) => {
  if (event.data && event.data.type === "SKIP_WAITING") {
    self.skipWaiting();
  }
});

workbox.routing.registerRoute(
  // Cache js files.
  /\.js/,
  // Use cache but update in the background.
  new workbox.strategies.StaleWhileRevalidate({
    // Use a custom cache name.
    cacheName: "js-cache-client",
  })
);
/*workbox.routing.registerRoute(
  // Cache js files.
  /\.php/,
  // Use cache but update in the background.
  new workbox.strategies.StaleWhileRevalidate({
    // Use a custom cache name.
    cacheName: "php-cache-client",
  })
);*/

workbox.routing.registerRoute(
  // Cache CSS files.
  /\.css/,
  // Use cache but update in the background.
  new workbox.strategies.StaleWhileRevalidate({
    // Use a custom cache name.
    cacheName: "css-cache-client",
  })
);

workbox.routing.registerRoute(
  // Cache image files.
  /\.(?:png|jpg|jpeg|svg|gif)$/,
  // Use the cache if it's available.
  new workbox.strategies.StaleWhileRevalidate({
    // Use a custom cache name.
    cacheName: "image-cache-client",
    plugins: [
      new workbox.expiration.Plugin({
        // Cache only 20 images.
        maxEntries: 20,
        // Cache for a maximum of a week.
        maxAgeSeconds: 7 * 24 * 60 * 60,
      }),
    ],
  })
);

/**
 * The workboxSW.precacheAndRoute() method efficiently caches and responds to
 * requests for URLs in the manifest.
 * See https://goo.gl/S9QRab
 */
self.__precacheManifest = [
  {
    url: "layout.php",
    revision: "87c56f81355eb5393263a10c471d8929",
  },

  {
    url: "bootstrap-4.3.1-dist/css/bootstrap-grid.css",
    revision: "59e3488e09a8bc96de5884586f3c67ec",
  },
  {
    url: "bootstrap-4.3.1-dist/css/bootstrap-grid.min.css",
    revision: "7aba9868c6ffadaf2c45d1bafe86d2c3",
  },
  {
    url: "bootstrap-4.3.1-dist/css/bootstrap-reboot.css",
    revision: "b53d1eaf9daeab26f2772281ae060120",
  },
  {
    url: "bootstrap-4.3.1-dist/css/bootstrap-reboot.min.css",
    revision: "220e4dc01283a9e9c5c146f984eb8934",
  },
  {
    url: "bootstrap-4.3.1-dist/css/bootstrap.css",
    revision: "bd551f56ce2be3eba2812e605ab4f5b2",
  },
  {
    url: "bootstrap-4.3.1-dist/css/bootstrap.min.css",
    revision: "a15c2ac3234aa8f6064ef9c1f7383c37",
  },
  {
    url: "bootstrap-4.3.1-dist/css/toast.css",
    revision: "c277b74bb7960f4a79c2fa7e6530a4f7",
  },
  {
    url: "bootstrap-4.3.1-dist/js/bootstrap.bundle.js",
    revision: "a9247b1fe21ee409d0b37e74100de687",
  },
  {
    url: "bootstrap-4.3.1-dist/js/bootstrap.bundle.min.js",
    revision: "a454220fc07088bf1fdd19313b6bfd50",
  },
  {
    url: "bootstrap-4.3.1-dist/js/bootstrap.js",
    revision: "7f827fe484ec04346553202782b0664b",
  },
  {
    url: "bootstrap-4.3.1-dist/js/bootstrap.min.js",
    revision: "e1d98d47689e00f8ecbc5d9f61bdb42e",
  },
  {
    url: "bootstrap-4.3.1-dist/js/jquery-3.2.1.min.js",
    revision: "c9f5aeeca3ad37bf2aa006139b935f0a",
  },
  { url: "Cairo.ttf", revision: "0387a0b8b59d6b26cb736ec76d5045b0" },
  {
    url: "Cairofont.woff2",
    revision: "2bc71088819b2156b8b135db52f95065",
  },
  {
    url: "Cairofont2.woff2",
    revision: "0f76f616dfdcbec3148d8e934486ba97",
  },

  { url: "install.php", revision: "23736ba16f9cf4d7c1eb3fde1eded1e7" },
  { url: "js/alert.js", revision: "f13b73a2ea45588cc618f355731216be" },
  { url: "js/app.js", revision: "d41d8cd98f00b204e9800998ecf8427e" },
  { url: "js/charts.js", revision: "e6b351a021414530cd42a228f0ae0427" },
  {
    url: "js/firebase-sw.js",
    revision: "1a1038b37f3a2b124fc877a838a3f046",
  },
  {
    url: "js/getAllDrivers.js",
    revision: "bf742a8f8127d051503cd267934d8eb5",
  },
  {
    url: "js/getBraches.js",
    revision: "6bca9c786f09fb356e82829026b52393",
  },
  {
    url: "js/getCities.js",
    revision: "7f31ad2532e72f3e7dc494a398d05ab0",
  },
  {
    url: "js/getClients.js",
    revision: "ac53111ca01de4428695183defc84796",
  },
  {
    url: "js/getDrivers.js",
    revision: "1e64af85296e71c32461996f76f5d85d",
  },
  {
    url: "js/getorderStatus.js",
    revision: "cb96f388f3e178a58b1232590c375893",
  },
  { url: "js/getRoles.js", revision: "97bbbb71e8388061fb249338015d9f35" },
  {
    url: "js/getStores.js",
    revision: "c0260a6f59f6fe2d7dd67f166b73baf9",
  },
  { url: "js/getTowns.js", revision: "0694794ac52bb803616192c23b3243e2" },
  { url: "js/location.js", revision: "a82468c64c8f410b6d486eb68bc88068" },
  { url: "js/popover.js", revision: "36affe2ca6cb85233ee7362c5d8b7893" },
  {
    url: "js/scanner-jquery.js",
    revision: "eb712613eef143d2754bbeaf7c5c4496",
  },
  { url: "js/toast.js", revision: "fae7f854c415e506d7f8d298fa9228e3" },
  { url: "js/webfont.js", revision: "9224f101e832356c17974cffa186ade2" },
  { url: "README.md", revision: "12bfa1ca2343d74d54f4ef19c7c5ce0a" },
].concat(self.__precacheManifest || []);
workbox.precaching.precacheAndRoute(self.__precacheManifest, {});
