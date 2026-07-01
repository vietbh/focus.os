import { Controller } from '@hotwired/stimulus';

export default class extends Controller {

    static values = {
        vapidKey: String,
        subscribeUrl: String,
    };

    async connect() {

        if (!('serviceWorker' in navigator)) {
            console.warn('Service Worker is not supported.');
            return;
        }

        if (!('PushManager' in window)) {
            console.warn('Push API is not supported.');
            return;
        }

        this.registration = await navigator.serviceWorker.register('/sw.js');

        console.log('Service Worker registered.', this.registration);

    }

    async subscribe() {

        try {

            if (Notification.permission === 'denied') {
                console.warn('Notification permission denied.');
                return;
            }

            if (Notification.permission === 'default') {

                const permission = await Notification.requestPermission();

                if (permission !== 'granted') {
                    return;
                }

            }

            let subscription = await this.registration.pushManager.getSubscription();

            if (subscription) {

                console.log('Existing subscription found.');

                await this.saveSubscription(subscription);

                return;

            }

            const applicationServerKey = this.base64ToUint8Array(
                this.vapidKeyValue,
            );

            console.log({
                vapidKey: this.vapidKeyValue,
                keyLength: applicationServerKey.length,
                secure: window.isSecureContext,
                origin: location.origin,
            });

            subscription = await this.registration.pushManager.subscribe({

                userVisibleOnly: true,

                applicationServerKey,

            });

            console.log('Subscription created.', subscription);

            await this.saveSubscription(subscription);

        } catch (error) {

            console.error('Push subscription failed.');

            console.error(error);

        }

    }

    async unsubscribe() {

        const subscription =
            await this.registration.pushManager.getSubscription();

        if (!subscription) {
            return;
        }

        await subscription.unsubscribe();

        console.log('Subscription removed.');

    }

    async saveSubscription(subscription) {

        const response = await fetch(
            this.subscribeUrlValue,
            {

                method: 'POST',

                headers: {
                    'Content-Type': 'application/json',
                },

                body: JSON.stringify(
                    subscription.toJSON(),
                ),

            },
        );

        if (!response.ok) {
            throw new Error(
                'Unable to save subscription.',
            );
        }

    }

    base64ToUint8Array(base64String) {

        const padding =
            '='.repeat(
                (4 - base64String.length % 4) % 4,
            );

        const base64 =
            (base64String + padding)
                .replace(/-/g, '+')
                .replace(/_/g, '/');

        const rawData =
            window.atob(base64);

        return Uint8Array.from(
            [...rawData].map(
                char => char.charCodeAt(0),
            ),
        );

    }

    async test() {

        const registration = await navigator.serviceWorker.ready;

        await registration.showNotification(
            'Focus OS',
            {
                body: 'Hello from Focus OS 🎉',
                icon: '/favicon.ico',
                badge: '/favicon.ico',
                data: {
                    url: '/',
                },
            },
        );

    }

}
