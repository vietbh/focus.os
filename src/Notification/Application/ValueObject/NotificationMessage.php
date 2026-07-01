<?php

declare(strict_types=1);

namespace App\Notification\Application\ValueObject;

final readonly class NotificationMessage
{
    public function __construct(
        private string $title,
        private string $body,
        private ?string $url = null,
        private ?string $icon = null,
        private ?string $badge = null,
    ) {
    }

    public function title(): string
    {
        return $this->title;
    }

    public function body(): string
    {
        return $this->body;
    }

    public function url(): ?string
    {
        return $this->url;
    }

    public function icon(): ?string
    {
        return $this->icon;
    }

    public function badge(): ?string
    {
        return $this->badge;
    }
}
