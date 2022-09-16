import {NavigationRoute, registerRoute} from 'workbox-routing';
import {StaleWhileRevalidate, CacheFirst, NetworkOnly} from 'workbox-strategies';
import {precacheAndRoute} from 'workbox-precaching';
import * as navigationPreload from 'workbox-navigation-preload';

// Used to limit entries in cache, remove entries after a certain period of time
import {ExpirationPlugin} from 'workbox-expiration';
import {CacheableResponsePlugin} from "workbox-cacheable-response";

// Ensure your build step is configured to include /offline as part of your precache manifest.
precacheAndRoute(self.__WB_MANIFEST);

// Catch routing errors, like if the user is offline
self.addEventListener('install', async(event) => {
    event.waitUntil(
        caches.open('offline')
            .then((cache) => cache.add('/offline'))
    );
});

// notification push
self.addEventListener('push', (event) => {
    const data = event.data ? event.data.json() : {};
    event.waitUntil(self.registration.showNotification(data.title, data.options));
});

self.addEventListener("notificationclick", (event) => {
    event.notification.close();
    event.waitUntil(async function () {
        const url = event.notification.data.url || window.DEVSCAST.BASE_URL;
        const windowClients = await self.clients.matchAll({
            type: "window",
            includeUncontrolled: true,
        });

        for (let i = 0; i < windowClients.length; i++) {
            const client = windowClients[i];
            if (client.url === url && "focus" in client) {
                return client.focus();
            }
        }

        if (self.clients.openWindow) {
            return self.clients.openWindow(url);
        }
            return null;
    });
});

// Register this strategy to handle all navigations.
navigationPreload.enable();
registerRoute(
    new NavigationRoute(async(params) => {
        try {
            return await(new NetworkOnly()).handle(params);
        } catch (error) {
            return caches.match('/offline', {
                cacheName: 'offline',
            });
        }
    })
);

// Cache CSS, JS, and Web Worker requests with a Stale While Revalidate strategy
registerRoute(
    // Check to see if the request's destination is style for stylesheets, script for JavaScript, or worker for web worker
    ({request}) =>
    request.destination === 'style' ||
        request.destination === 'script' ||
        request.destination === 'worker',
    // Use a Stale While Revalidate caching strategy
    new StaleWhileRevalidate({
        // Put all cached files in a cache named 'assets'
        cacheName: 'assets',
        plugins: [
            // Ensure that only requests that result in a 200 status are cached
            new CacheableResponsePlugin({
                statuses: [200],
            }),
        ],
    }),
);

// Cache images with a Cache First strategy
registerRoute(
    // Check to see if the request's destination is style for an image
    ({request}) => request.destination === 'image',
    // Use a Cache First caching strategy
    new CacheFirst({
        // Put all cached files in a cache named 'images'
        cacheName: 'images',
        plugins: [
            // Ensure that only requests that result in a 200 status are cached
            new CacheableResponsePlugin({
                statuses: [200],
            }),
            // Don't cache more than 50 items, and expire them after 1 day
            new ExpirationPlugin({
                maxEntries: 50,
                maxAgeSeconds: 60 * 60 * 24, // 1 Day
            }),
        ],
    }),
);

// Message Handling
self.addEventListener('message', (event) => {
    if (event.data && event.data.type === 'SKIP_WAITING') {
        self.skipWaiting();
    }
});
