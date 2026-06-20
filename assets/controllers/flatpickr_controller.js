import { Controller } from '@hotwired/stimulus';
import flatpickr from 'flatpickr';
import 'flatpickr/dist/flatpickr.min.css';
import { getComponent } from '@symfony/ux-live-component';
import {Vietnamese} from "flatpickr/dist/l10n/vn.js";

export default class extends Controller {
    async connect() {
        this.initializePicker();

        const root = this.element?.closest(
            "[data-controller*='live']"
        );

        if (!root) {
            return;
        }

        this.component = await getComponent(root);

        this.component.on(
            'render:finished',
            () => {
                this.initializePicker();
            }
        );
    }

    initializePicker() {
        this.picker?.destroy();

        this.picker = flatpickr(this.element, {
            altInput: true,
            altFormat: 'd/m/Y',
            dateFormat: 'd/m/Y',
            allowInput: true,
            minDate: 'today',
            locale: Vietnamese
        });
    }

    disconnect() {
        this.picker?.destroy();
    }
}
