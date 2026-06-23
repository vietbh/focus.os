<?php

namespace App\Task\Infrastructure\Service;

use App\Task\Domain\Repository\TaskRepositoryInterface;
use App\Task\Domain\Service\SingleDoingRule;
use App\Task\Domain\ValueObject\TaskId;
use Symfony\Component\DependencyInjection\Attribute\AsAlias;

#[AsAlias(SingleDoingRule::class)]
final readonly class DoctrineSingleDoingRule
    implements SingleDoingRule
{
    public function __construct(
        private TaskRepositoryInterface $repository,
    ) {
    }

    public function ensure(
        TaskId $taskId
    ): void {
        $doing = $this->repository
            ->findCurrentDoing();

        if ($doing === null) {
            return;
        }

        if (
            $doing->id()->equals(
                $taskId
            )
        ) {
            return;
        }

        throw new MultipleDoingTaskException();
    }
}
