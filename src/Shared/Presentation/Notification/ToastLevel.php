<?php

declare(strict_types=1);

namespace App\Shared\Presentation\Notification;

enum ToastLevel: string
{
    case Success = 'success';
    case Info = 'info';
    case Warning = 'warning';
    case Error = 'error';
}
