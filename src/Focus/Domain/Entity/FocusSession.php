<?php

declare(strict_types=1);

namespace App\Focus\Domain\Entity;

use App\Focus\Domain\Enum\FocusSessionStatus;
use App\Focus\Domain\Exception\FocusSessionException;
use App\Focus\Domain\ValueObject\FocusSessionId;
use App\Identity\Domain\ValueObject\UserId;
use App\Task\Domain\ValueObject\TaskId;
use DateTimeImmutable;

final class FocusSession
{
    /*
     |--------------------------------------------------------------------------
     | Identity
     |--------------------------------------------------------------------------
     */

    private FocusSessionId $id;

    private UserId $userId;

    private TaskId $taskId;

    /*
     |--------------------------------------------------------------------------
     | State
     |--------------------------------------------------------------------------
     */

    private FocusSessionStatus $status;

    private \DateTimeImmutable $startedAt;

    private ?\DateTimeImmutable $pausedAt = null;

    private ?\DateTimeImmutable $endedAt = null;

    /**
     * Total paused duration in seconds.
     */
    private int $pausedSeconds = 0;

    /*
     |--------------------------------------------------------------------------
     | Audit
     |--------------------------------------------------------------------------
     */

    private \DateTimeImmutable $createdAt;

    private \DateTimeImmutable $updatedAt;

    private function __construct(
        FocusSessionId $id,
    ) {
        $this->id = $id;
    }

    public static function start(
        UserId $userId,
        TaskId $taskId,
        ?\DateTimeImmutable $startedAt = null,
    ): self {
        $startedAt ??= new \DateTimeImmutable();

        $session = new self(
            FocusSessionId::generate(),
        );

        $session->userId = $userId;
        $session->taskId = $taskId;

        $session->status = FocusSessionStatus::ACTIVE;

        $session->startedAt = $startedAt;
        $session->createdAt = $startedAt;
        $session->updatedAt = $startedAt;

        return $session;
    }

    /*
     |--------------------------------------------------------------------------
     | Lifecycle
     |--------------------------------------------------------------------------
     */

    public function pause(
        ?\DateTimeImmutable $pausedAt = null,
    ): void {
        $this->assertActive();

        $pausedAt ??= new \DateTimeImmutable();

        $this->status = FocusSessionStatus::PAUSED;
        $this->pausedAt = $pausedAt;

        $this->touch($pausedAt);
    }

    public function resume(
        ?\DateTimeImmutable $resumedAt = null,
    ): void {
        $this->assertPaused();

        $time ??= new DateTimeImmutable();

        $this->completePause($time);

        $this->status = FocusSessionStatus::ACTIVE;

        $this->touch($time);
    }

    public function stop(
        ?\DateTimeImmutable $endedAt = null,
    ): void {
        $this->assertNotCompleted();

        $time ??= new DateTimeImmutable();

        if ($this->isPaused()) {
            $this->completePause($time);
        }

        $this->status = FocusSessionStatus::COMPLETED;
        $this->endedAt = $time;

        $this->touch($time);
    }

    /*
     |--------------------------------------------------------------------------
     | State
     |--------------------------------------------------------------------------
     */

    public function isActive(): bool
    {
        return $this->status === FocusSessionStatus::ACTIVE;
    }

    public function isPaused(): bool
    {
        return $this->status === FocusSessionStatus::PAUSED;
    }

    public function isCompleted(): bool
    {
        return $this->status === FocusSessionStatus::COMPLETED;
    }

    public function belongsTo(
        UserId $userId,
    ): bool {
        return $this->userId->equals($userId);
    }

    public function belongsToTask(
        TaskId $taskId,
    ): bool {
        return $this->taskId->equals($taskId);
    }

    /*
     |--------------------------------------------------------------------------
     | Identity
     |--------------------------------------------------------------------------
     */

    public function id(): FocusSessionId
    {
        return $this->id;
    }

    public function userId(): UserId
    {
        return $this->userId;
    }

    public function taskId(): TaskId
    {
        return $this->taskId;
    }

    /*
     |--------------------------------------------------------------------------
     | Information
     |--------------------------------------------------------------------------
     */

    public function status(): FocusSessionStatus
    {
        return $this->status;
    }

    public function startedAt(): \DateTimeImmutable
    {
        return $this->startedAt;
    }

    public function pausedAt(): ?\DateTimeImmutable
    {
        return $this->pausedAt;
    }

    public function endedAt(): ?\DateTimeImmutable
    {
        return $this->endedAt;
    }

    public function pausedSeconds(): int
    {
        return $this->pausedSeconds;
    }

    public function createdAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function updatedAt(): \DateTimeImmutable
    {
        return $this->updatedAt;
    }

    /*
     |--------------------------------------------------------------------------
     | Helpers
     |--------------------------------------------------------------------------
     */

    private function touch(
        \DateTimeImmutable $time,
    ): void {
        $this->updatedAt = $time;
    }

    private function calculatePausedSeconds(
        \DateTimeImmutable $until,
    ): int {
        if ($this->pausedAt === null) {
            throw FocusSessionException::missingPauseTimestamp();
        }

        return max(
            0,
            $until->getTimestamp() - $this->pausedAt->getTimestamp(),
        );
    }

    /*
     |--------------------------------------------------------------------------
     | Assertions
     |--------------------------------------------------------------------------
     */

    private function assertActive(): void
    {
        if ($this->isActive()) {
            return;
        }

        throw FocusSessionException::cannotPause(
            $this->status,
        );
    }

    private function assertPaused(): void
    {
        if ($this->isPaused()) {
            return;
        }

        throw FocusSessionException::cannotResume(
            $this->status,
        );
    }

    private function assertNotCompleted(): void
    {
        if (!$this->isCompleted()) {
            return;
        }

        throw FocusSessionException::alreadyCompleted();
    }

    private function completePause(
        DateTimeImmutable $time,
    ): void
    {
        $this->pausedSeconds += $this->calculatePausedSeconds($time);
        $this->pausedAt = null;
    }

    private function changeStatus(
        FocusSessionStatus $status,
    ): void
    {
        $this->status = $status;
    }



}
