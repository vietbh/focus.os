<?php

declare(strict_types=1);

namespace App\Identity\Application\UseCase;

use App\Area\Application\DTO\CreateAreaInput;
use App\Area\Application\UseCase\CreateAreaUseCase;
use App\Area\Domain\Repository\AreaRepositoryInterface;
use App\Identity\Application\DTO\OAuthUserData;
use App\Identity\Domain\Entity\User;
use App\Identity\Domain\Enum\AuthProvider;
use App\Identity\Domain\Repository\UserRepositoryInterface;
use App\Identity\Domain\ValueObject\UserId;
use App\SharedKernel\Domain\Service\ClockInterface;
use App\SharedKernel\Domain\Uuid\UuidGeneratorInterface;
use App\SharedKernel\Infrastructure\Persistence\DoctrineTransactionManager;

final readonly class FindOrCreateUserUseCase
{
    public function __construct(
        private UserRepositoryInterface $users,
        private UuidGeneratorInterface $uuidGenerator,
        private ClockInterface $clock,
        private CreateAreaUseCase  $createAreaUseCase,
        private AreaRepositoryInterface $areaRepository,
        private DoctrineTransactionManager $transaction,
    ) {
    }

    public function execute(
        OAuthUserData $data,
    ): User {
        $user = $this->users->findByProvider(
            $data->providerId,
        );

        if ($user === null) {
            $user = User::create(
                id: UserId::fromString(
                    $this->uuidGenerator->generate(),
                ),
                email: $data->email,
                name: $data->name,
                avatar: $data->avatar,
                provider: AuthProvider::GOOGLE,
                providerId: $data->providerId,
                createdAt: $this->clock->now(),
            );
        } else {
            $user->updateProfile(
                name: $data->name,
                avatar: $data->avatar,
                updatedAt: $this->clock->now(),
            );
        }

        $this->transaction->wrap(function () use ($user): void {
            $this->users->save(
                $user,
            );
        });

        if (!$this->areaRepository->findByUserId($user->id())){
            $this->createAreaUseCase->execute(
                new CreateAreaInput(
                    userId: $user->id(),
                    goalId: null,
                    name: 'Personal',
                ),
            );
        }

        return $user;
    }
}
