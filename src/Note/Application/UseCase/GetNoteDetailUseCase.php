<?php

declare(strict_types=1);

namespace App\Note\Application\UseCase;

use App\Identity\Domain\ValueObject\UserId;
use App\Note\Domain\Entity\Note;
use App\Note\Domain\Repository\NoteRepositoryInterface;
use App\Note\Domain\ValueObject\NoteId;

final readonly class GetNoteDetailUseCase
{
    public function __construct(
        private NoteRepositoryInterface $notes,
    ) {
    }

    public function execute(
        UserId $userId,
        NoteId $noteId,
    ): ?Note {
        $note = $this->notes->findById(
            $noteId,
        );

        if ($note === null) {
            return null;
        }

        if (
            !$note->ownedBy(
                $userId,
            )
        ) {
            return null;
        }

        return $note;
    }
}
