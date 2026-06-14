<?php

declare(strict_types=1);

namespace App\Note\Application\UseCase;

use App\Note\Application\DTO\CreateNoteInput;
use App\Note\Domain\Entity\Note;
use App\Note\Domain\Repository\NoteRepositoryInterface;
use App\Note\Domain\ValueObject\NoteId;
use App\SharedKernel\Domain\Service\ClockInterface;
use Symfony\Component\Uid\Uuid;

final readonly class CreateNoteUseCase
{
    public function __construct(
        private NoteRepositoryInterface $notes,
        private ClockInterface $clock,
    ) {
    }

    public function execute(
        CreateNoteInput $input,
    ): Note {
        $note = Note::create(
            id: NoteId::fromString(
                Uuid::v7()->toRfc4122(),
            ),
            userId: $input->userId,
            title: $input->title,
            content: $input->content,
            createdAt: $this->clock->now(),
        );

        $this->notes->save(
            $note,
        );

        return $note;
    }
}
