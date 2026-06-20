<?php

declare(strict_types=1);

namespace App\Identity\Infrastructure\Persistence\Repository;

use App\Identity\Domain\Entity\User;
use App\Identity\Domain\Entity\UserPreference;
use App\Identity\Domain\Repository\UserPreferenceRepositoryInterface;
use App\Identity\Domain\ValueObject\UserId;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Component\DependencyInjection\Attribute\AsAlias;

#[AsAlias(UserPreferenceRepositoryInterface::class)]
final readonly class DoctrineUserPreferenceRepository
    implements UserPreferenceRepositoryInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function save(
        UserPreference $preference,
    ): void {
        $this->entityManager->persist(
            $preference,
        );

        $this->entityManager->flush();
    }

    public function getByUser(
        UserId $userId,
    ): UserPreference
    {
        $user = $this->entityManager
            ->find(
                User::class,
                $userId->value(),
            );

        if (!$user instanceof User) {
            throw new EntityNotFoundException(
                sprintf(
                    'User "%s" not found.',
                    $userId->value(),
                ),
            );
        }

        $preference =
            $this->entityManager
                ->getRepository(
                    UserPreference::class,
                )
                ->findOneBy([
                    'user' => $user,
                ]);

        if (
            $preference instanceof UserPreference
        ) {
            return $preference;
        }

        $preference =
            UserPreference::create(
                $user,
            );

        $this->save(
            $preference,
        );

        return $preference;
    }

}
