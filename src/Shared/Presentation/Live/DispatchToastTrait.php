<?php

namespace App\Shared\Presentation\Live;

use App\Shared\Presentation\Notification\ToastLevel;
use App\Shared\Presentation\Notification\ToastNotification;

trait DispatchToastTrait
{
    use BrowserEventTrait;

    protected function toast(
        ToastNotification $toast,
    ): void {
        $this->dispatchAppEvent(
            'toast',
            $toast->toArray(),
        );
    }

    protected function toastSuccess(
        string $message,
        ?string $title = null,
    ): void {
        $this->toast(
            new ToastNotification(
                ToastLevel::Success,
                $message,
                $title,
            )
        );
    }

    protected function toastError(
        string $message,
        ?string $title = null,

    ):void
    {
        $this->toast(
            new ToastNotification(
                ToastLevel::Error,
                $message,
                $title,
            )
        );
    }
}
