<?php

declare(strict_types=1);

namespace App\Shared\Presentation\Notification;

final readonly class ToastNotification
{
    public function __construct(
        public ToastLevel $level,
        public string $message,
        public ?string $title = null,
        public int $duration = 4000,
    ) {
    }

    public function toArray(): array
    {
        return [
            'level' => $this->level->value,
            'title' => $this->title,
            'message' => $this->message,
            'duration' => $this->duration,
        ];
    }
}
