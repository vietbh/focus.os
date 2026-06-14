<?php

declare(strict_types=1);

namespace App\SharedKernel\Infrastructure\Persistence;

use App\SharedKernel\Domain\Service\TransactionManagerInterface;
use Doctrine\ORM\EntityManagerInterface;

final readonly class DoctrineTransactionManager implements TransactionManagerInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function wrap(
        callable $callback,
    ): mixed {
        return $this->entityManager->wrapInTransaction(
            $callback,
        );
    }
}
