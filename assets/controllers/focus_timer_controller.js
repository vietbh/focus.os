
import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static values = {
        startedAt: String,
        pausedSeconds: Number,
        running: Boolean,
    };

    static targets = [
        'display',
    ];

    runningValueChanged(value) {
        if (value) {
            this.start();
        } else {
            this.stop();
        }
    }
    connect() {
        this.stop();
        this.render();

        if (this.runningValue) {
            this.start();
        }
    }

    disconnect() {
        this.stop();
    }

    start() {

        this.timer = window.setInterval(() => {
            this.render();
        }, 1000);
    }

    stop() {
        if (this.timer) {
            clearInterval(this.timer);
            this.timer = null;
        }
    }

    render() {
        let seconds = this.elapsedSeconds();

        this.displayTarget.textContent = this.format(seconds);
    }

    elapsedSeconds() {
        const startedAt = new Date(this.startedAtValue);

        const now = new Date();

        return Math.max(
            0,
            Math.floor(
                (now.getTime() - startedAt.getTime()) / 1000,
            ) - this.pausedSecondsValue,
        );
    }

    format(totalSeconds) {
        const hours = Math.floor(totalSeconds / 3600);
        const minutes = Math.floor((totalSeconds % 3600) / 60);
        const seconds = totalSeconds % 60;

        return [
            hours,
            minutes,
            seconds,
        ]
            .map(value => String(value).padStart(2, '0'))
            .join(':');
    }
}
