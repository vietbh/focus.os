<?php

declare(strict_types=1);

namespace App\Note\Application\UseCase;

use App\Identity\Domain\ValueObject\UserId;
use App\Note\Application\DTO\UpdateNoteInput;
use App\Note\Domain\Exception\NoteNotFoundException;
use App\Note\Domain\Repository\NoteRepositoryInterface;
use App\SharedKernel\Domain\Service\ClockInterface;

final readonly class UpdateNoteUseCase
{
    public function __construct(
        private NoteRepositoryInterface $notes,
        private ClockInterface $clock,
    ) {
    }

    public function execute(
        UserId $userId,
        UpdateNoteInput $input,
    ): void {
        $note = $this->notes->findById(
            $input->noteId,
        );

        if (
            $note === null
            || !$note->ownedBy(
                $userId,
            )
        ) {
            throw new NoteNotFoundException();
        }

        $note->update(
            title: $input->title,
            content: $input->content,
            updatedAt: $this->clock->now(),
        );

        $this->notes->save(
            $note,
        );
    }
}
