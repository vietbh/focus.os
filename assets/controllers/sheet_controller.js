import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = [
        'backdrop',
        'panel',
    ];

    connect() {
        this.handleClick =
            this.handleClick.bind(this);

        document.addEventListener(
            'click',
            this.handleClick,
        );
    }

    disconnect() {
        document.removeEventListener(
            'click',
            this.handleClick,
        );

        document.body.classList.remove(
            'overflow-hidden',
        );
    }

    handleClick(event) {
        const openTrigger =
            event.target.closest(
                '[data-sheet-toggle]',
            );

        if (openTrigger) {
            const targetId =
                openTrigger.dataset.sheetToggle;

            if (
                targetId ===
                this.element.id
            ) {
                this.open();
            }
        }

        const dismissTrigger =
            event.target.closest(
                '[data-sheet-dismiss]',
            );

        if (
            dismissTrigger &&
            this.element.contains(
                dismissTrigger,
            )
        ) {
            this.close();
        }
    }

    open() {
        this.backdropTarget.classList.remove(
            'hidden',
        );

        this.panelTarget.classList.remove(
            'hidden',
        );

        document.body.classList.add(
            'overflow-hidden',
        );
    }

    close() {
        this.backdropTarget.classList.add(
            'hidden',
        );

        this.panelTarget.classList.add(
            'hidden',
        );

        document.body.classList.remove(
            'overflow-hidden',
        );
    }
}
