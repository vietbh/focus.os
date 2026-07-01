// self.addEventListener('push', event => {
//
//     const payload = event.data
//         ? event.data.json()
//         : {};
//
//     event.waitUntil(
//         self.registration.showNotification(
//             payload.title ?? 'Focus OS',
//             {
//                 body: payload.body ?? '',
//                 icon: payload.icon ?? '/favicon.ico',
//                 badge: payload.badge ?? '/favicon.ico',
//                 data: {
//                     url: payload.url ?? '/',
//                 },
//             },
//         ),
//     );
//
// });
//
// self.addEventListener('notificationclick', event => {
//
//     event.notification.close();
//
//     event.waitUntil(
//         clients.openWindow(
//             event.notification.data.url ?? '/',
//         ),
//     );
//
// });

self.addEventListener('push', event => {

    const payload = event.data
        ? event.data.json()
        : {};

    event.waitUntil(
        self.registration.showNotification(
            payload.title ?? 'Focus OS',
            {
                body: payload.body ?? '',
                icon: payload.icon ?? '/favicon.ico',
                badge: payload.badge ?? '/favicon.ico',
                data: payload,
            },
        ),
    );

});

self.addEventListener('notificationclick', event => {

    event.notification.close();

    if (!event.notification.data?.url) {
        return;
    }

    event.waitUntil(
        clients.openWindow(
            event.notification.data.url,
        ),
    );

});
