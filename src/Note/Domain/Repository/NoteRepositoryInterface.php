<?php

declare(strict_types=1);

namespace App\Note\Domain\Repository;

use App\Identity\Domain\ValueObject\UserId;
use App\Note\Domain\Entity\Note;
use App\Note\Domain\ValueObject\NoteId;

interface NoteRepositoryInterface
{
    public function save(
        Note $note,
    ): void;

    public function remove(
        Note $note,
    ): void;

    public function findById(
        NoteId $id,
    ): ?Note;

    /**
     * @return Note[]
     */
    public function findByUserId(
        UserId $userId,
    ): array;

    /**
     * @return Note[]
     */
    public function findRecentByUserId(
        UserId $userId,
        int $limit = 5,
    ): array;



}
