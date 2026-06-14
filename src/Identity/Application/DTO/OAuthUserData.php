<?php

declare(strict_types=1);

namespace App\Identity\Application\DTO;

final readonly class OAuthUserData
{
    public function __construct(
        public string $providerId,
        public string $email,
        public string $name,
        public ?string $avatar,
    ) {
    }
}
