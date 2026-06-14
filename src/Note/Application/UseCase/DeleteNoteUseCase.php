<?php

declare(strict_types=1);

namespace App\Note\Application\UseCase;

use App\Identity\Domain\ValueObject\UserId;
use App\Note\Domain\Exception\NoteNotFoundException;
use App\Note\Domain\Repository\NoteRepositoryInterface;
use App\Note\Domain\ValueObject\NoteId;

final readonly class DeleteNoteUseCase
{
    public function __construct(
        private NoteRepositoryInterface $notes,
    ) {
    }

    public function execute(
        UserId $userId,
        NoteId $noteId,
    ): void {
        $note = $this->notes->findById(
            $noteId,
        );

        if (
            $note === null
            || !$note->ownedBy(
                $userId,
            )
        ) {
            throw new NoteNotFoundException();
        }

        $this->notes->remove(
            $note,
        );
    }
}
