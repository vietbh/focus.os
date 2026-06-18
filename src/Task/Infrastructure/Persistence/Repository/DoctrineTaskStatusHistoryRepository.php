<?php

declare(strict_types=1);

namespace App\Task\Infrastructure\Persistence\Repository;

use App\Identity\Domain\ValueObject\UserId;
use App\Task\Domain\Entity\Task;
use App\Task\Domain\Entity\TaskStatusHistory;
use App\Task\Domain\Enum\TaskStatus;
use App\Task\Domain\Repository\TaskStatusHistoryRepositoryInterface;
use App\Task\Domain\ValueObject\TaskId;
use Doctrine\ORM\EntityManagerInterface;

final readonly class DoctrineTaskStatusHistoryRepository implements TaskStatusHistoryRepositoryInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function save(
        TaskStatusHistory $history,
    ): void {
        $this->entityManager->persist(
            $history,
        );

        $this->entityManager->flush();
    }

    public function findByTaskId(
        TaskId $taskId,
    ): array {
        return $this->entityManager
            ->createQueryBuilder()
            ->select('h')
            ->from(TaskStatusHistory::class, 'h')
            ->andWhere('h.taskId = :taskId')
            ->setParameter(
                'taskId',
                $taskId,
            )
            ->orderBy(
                'h.occurredAt',
                'ASC',
            )
            ->getQuery()
            ->getResult();
    }

    public function countStatusChangedBetween(
        UserId $userId,
        TaskStatus $status,
        \DateTimeImmutable $from,
        \DateTimeImmutable $to,
    ): int {
        return (int) $this->entityManager
            ->createQueryBuilder()
            ->select('COUNT(h.id)')
            ->from(
                TaskStatusHistory::class,
                'h',
            )
            ->join(
                Task::class,
                't',
                'WITH',
                't.id = h.taskId',
            )
            ->andWhere(
                't.userId = :userId',
            )
            ->andWhere(
                'h.toStatus = :status',
            )
            ->andWhere(
                'h.occurredAt >= :from',
            )
            ->andWhere(
                'h.occurredAt < :to',
            )
            ->setParameter(
                'userId',
                $userId->value(),
            )
            ->setParameter(
                'status',
                $status,
            )
            ->setParameter(
                'from',
                $from,
            )
            ->setParameter(
                'to',
                $to,
            )
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function calculateFocusMinutesBetween(
        UserId $userId,
        \DateTimeImmutable $from,
        \DateTimeImmutable $to,
    ): int {
        $histories = $this->entityManager
            ->createQueryBuilder()
            ->select('h')
            ->from(
                TaskStatusHistory::class,
                'h',
            )
            ->join(
                Task::class,
                't',
                'WITH',
                't.id = h.taskId',
            )
            ->andWhere(
                't.userId = :userId',
            )
            ->andWhere(
                'h.occurredAt >= :from',
            )
            ->andWhere(
                'h.occurredAt < :to',
            )
            ->orderBy(
                'h.occurredAt',
                'ASC',
            )
            ->setParameter(
                'userId',
                $userId->value(),
            )
            ->setParameter(
                'from',
                $from,
            )
            ->setParameter(
                'to',
                $to,
            )
            ->getQuery()
            ->getResult();

        $focusStartedAt = null;
        $focusMinutes = 0;

        foreach ($histories as $history) {

            if (
                $history->toStatus() === TaskStatus::DOING
            ) {
                $focusStartedAt = $history->occurredAt();

                continue;
            }

            if (
                $focusStartedAt !== null
                && (
                    $history->toStatus() === TaskStatus::INTERRUPTED
                    || $history->toStatus() === TaskStatus::DONE
                )
            ) {
                $focusMinutes += (int) floor(
                    (
                        $history->occurredAt()->getTimestamp()
                        - $focusStartedAt->getTimestamp()
                    ) / 60
                );

                $focusStartedAt = null;
            }
        }

        return $focusMinutes;
    }
}
