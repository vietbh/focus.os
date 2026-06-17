
/* stimulusFetch: 'lazy' */
import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = [
        'backdrop',
        'panel',
    ];

    open() {
        this.element.classList.remove('hidden');

        requestAnimationFrame(() => {
            this.backdropTarget.classList.remove(
                'opacity-0',
            );

            this.panelTarget.classList.remove(
                'opacity-0',
                'translate-y-4',
            );
        });

        document.body.classList.add(
            'overflow-hidden',
        );
    }

    close() {
        this.backdropTarget.classList.add(
            'opacity-0',
        );

        this.panelTarget.classList.add(
            'opacity-0',
            'translate-y-4',
        );

        setTimeout(() => {
            this.element.classList.add(
                'hidden',
            );
        }, 200);

        document.body.classList.remove(
            'overflow-hidden',
        );
    }

    closeOnEscape(event) {
        if (event.key === 'Escape') {
            this.close();
        }
    }
}
