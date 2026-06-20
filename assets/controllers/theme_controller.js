import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    connect() {
        this.apply();
        window.addEventListener(
            'theme:changed',
            (event) => {
                document.documentElement.dataset.theme =
                    event.detail.theme;

                this.apply();
            }
        );
    }

    apply() {
        const theme =
            document.documentElement.dataset.theme;

        if (theme === 'dark') {
            document.documentElement.classList.add(
                'dark'
            );

            return;
        }

        if (theme === 'light') {
            document.documentElement.classList.remove(
                'dark'
            );

            return;
        }

        const prefersDark =
            window.matchMedia(
                '(prefers-color-scheme: dark)'
            ).matches;

        document.documentElement.classList.toggle(
            'dark',
            prefersDark,
        );
    }
}
