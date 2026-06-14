<?php

declare(strict_types=1);

namespace App\Note\Application\DTO;

use App\Note\Domain\ValueObject\NoteId;

final readonly class UpdateNoteInput
{
    public function __construct(
        public NoteId $noteId,
        public string $title,
        public ?string $content,
    ) {
    }
}
