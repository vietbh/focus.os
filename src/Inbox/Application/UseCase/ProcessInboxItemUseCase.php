<?php

declare(strict_types=1);

namespace App\Inbox\Application\UseCase;

use App\Identity\Domain\ValueObject\UserId;
use App\Inbox\Application\DTO\ProcessInboxItemInput;
use App\Inbox\Domain\Exception\InboxItemNotFoundException;
use App\SharedKernel\Infrastructure\Clock\SystemClock;
use App\SharedKernel\Infrastructure\Persistence\DoctrineTransactionManager;
use App\Task\Application\DTO\CreateTaskInput;
use App\Task\Application\UseCase\CreateTaskUseCase;
use App\Inbox\Domain\Repository\InboxItemRepositoryInterface;

final readonly class ProcessInboxItemUseCase
{
    public function __construct(
        private InboxItemRepositoryInterface $items,
        private CreateTaskUseCase $createTaskUseCase,
        private SystemClock $clock,
        private DoctrineTransactionManager $transaction,
    ) {
    }

    public function execute(
        ProcessInboxItemInput $input,
        UserId $userId,
    ): void {
        $item = $this->items->findById(
            $input->inboxItemId,
        );

        if ($item === null) {
            throw new InboxItemNotFoundException();
        }
        if (
            !$item->ownedBy(
                $userId,
            )
        ) {
            throw new InboxItemNotFoundException();
        }
        $this->createTaskUseCase->execute(
            new CreateTaskInput(
                userId: $item->userId(),
                areaId: $input->areaId,
                title: $input->title,
                description: $item->content(),
                nextAction: $input->nextAction,
                estimatedMinutes: $input->estimatedMinutes,
            ),
        );

        $item->markProcessed(
            $this->clock->now(),
        );
        $this->transaction->wrap(function () use ($item): void {
            $this->items->save(
                $item,
            );
        });
    }
}
