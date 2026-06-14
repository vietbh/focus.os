<?php

declare(strict_types=1);

namespace App\Inbox\Application\UseCase;

use App\Inbox\Application\DTO\ProcessInboxToNoteInput;
use App\Inbox\Domain\Repository\InboxItemRepositoryInterface;
use App\Note\Application\DTO\CreateNoteInput;
use App\Note\Application\UseCase\CreateNoteUseCase;
use App\SharedKernel\Domain\Service\ClockInterface;
use App\SharedKernel\Domain\Service\TransactionManagerInterface;

final readonly class ProcessInboxToNoteUseCase
{
    public function __construct(
        private InboxItemRepositoryInterface $items,
        private CreateNoteUseCase $createNoteUseCase,
        private ClockInterface $clock,
        private TransactionManagerInterface $transaction,
    ) {
    }

    public function execute(
        ProcessInboxToNoteInput $input,
    ): void {
        $item = $this->items->findById(
            $input->inboxItemId,
        );

        if ($item === null) {
            throw new \RuntimeException(
                'Inbox item not found.',
            );
        }

        $this->transaction->wrap(
            function () use ($item, $input): void {
                $this->createNoteUseCase->execute(
                    new CreateNoteInput(
                        userId: $item->userId(),
                        title: $input->title,
                        content: $item->content(),
                    ),
                );

                $item->markProcessed(
                    $this->clock->now(),
                );

                $this->items->save(
                    $item,
                );
            },
        );
    }
}
