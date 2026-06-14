<?php

declare(strict_types=1);

namespace App\Note\Application\UseCase;

use App\Identity\Domain\ValueObject\UserId;
use App\Note\Domain\Repository\NoteRepositoryInterface;

final readonly class GetNoteListUseCase
{
    public function __construct(
        private NoteRepositoryInterface $notes,
    ) {
    }

    public function execute(
        UserId $userId,
    ): array {
        return $this->notes->findByUserId(
            $userId,
        );
    }
}
