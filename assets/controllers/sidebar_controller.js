import { Controller } from '@hotwired/stimulus';

/* stimulusFetch: 'lazy' */
export default class extends Controller {
    static targets = [
        'panel',
        'overlay',
    ];

    open() {
        this.panelTarget.classList.remove('-translate-x-full');
        this.overlayTarget.classList.remove('hidden');

        document.body.classList.add('overflow-hidden');
    }

    close() {
        this.panelTarget.classList.add('-translate-x-full');
        this.overlayTarget.classList.add('hidden');

        document.body.classList.remove('overflow-hidden');
    }

    toggle() {
        if (
            this.panelTarget.classList.contains(
                '-translate-x-full',
            )
        ) {
            this.open();

            return;
        }

        this.close();
    }
}
