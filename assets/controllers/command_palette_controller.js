import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = [
        'modal',
    ];

    connect() {
        this.boundKeyDown =
            this.handleKeyDown.bind(this);

        document.addEventListener(
            'keydown',
            this.boundKeyDown,
        );
    }

    disconnect() {
        document.removeEventListener(
            'keydown',
            this.boundKeyDown,
        );
    }

    handleKeyDown(event) {
        const shortcut =
            (event.metaKey || event.ctrlKey)
            && event.key === 'k';

        if (!shortcut) {
            return;
        }

        event.preventDefault();

        this.open();
    }

    open() {
        this.modalTarget.classList.remove(
            'hidden',
        );
    }

    close() {
        this.modalTarget.classList.add(
            'hidden',
        );
    }
}
