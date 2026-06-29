import { Controller } from '@hotwired/stimulus';

/* stimulusFetch: 'lazy' */

export default class extends Controller {
    static targets = [
        'list',
        'template',
    ];

    connect() {
        window.addEventListener(
            'app:toast',
            this.onToast,
        );
    }

    disconnect() {
        window.removeEventListener(
            'app:toast',
            this.onToast,
        );
    }

    onToast = (event) => {
        this.show(
            event.detail ?? {},
        );
    };

    show(toast) {
        const template = this.templateTarget.content.cloneNode(true);

        const element = template.firstElementChild;

        element.dataset.level = toast.level ?? 'info';

        element.querySelector(
            '[data-toast-title]',
        ).textContent = toast.title ?? '';

        element.querySelector(
            '[data-toast-message]',
        ).textContent = toast.message ?? '';

        this.listTarget.append(element);

        requestAnimationFrame(() => {
            element.classList.remove(
                'translate-x-8',
                'opacity-0',
            );

            element.classList.add(
                'translate-x-0',
                'opacity-100',
            );
        });

        const duration = toast.duration ?? 4000;

        setTimeout(
            () => this.close(element),
            duration,
        );
    }

    close(element) {
        element.classList.remove(
            'translate-x-0',
            'opacity-100',
        );

        element.classList.add(
            'translate-x-8',
            'opacity-0',
        );

        element.addEventListener(
            'transitionend',
            () => element.remove(),
            {
                once: true,
            },
        );
    }

    dismiss(event) {
        this.close(
            event.currentTarget.closest('[data-toast]'),
        );
    }
}
