<?php

declare(strict_types=1);

namespace App\Tests\Identity\Infrastructure\Persistence\Repository;

use App\Identity\Domain\Entity\User;
use App\Identity\Domain\Enum\AuthProvider;
use App\Identity\Domain\ValueObject\UserId;
use App\Identity\Infrastructure\Persistence\Repository\DoctrineUserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

final class UserRepositoryTest extends KernelTestCase
{
    private DoctrineUserRepository $repository;

    protected function setUp(): void
    {
        self::bootKernel();

        $this->repository = self::getContainer()->get(
            DoctrineUserRepository::class,
        );

        $this->entityManager = self::getContainer()->get(
            EntityManagerInterface::class,
        );
    }

    public function test_save_user(): void
    {
        $user = User::create(
            id: UserId::fromString(
                '00000000-0000-0000-0000-000000000001',
            ),
            email: 'test@example.com',
            name: 'Test User',
            avatar: null,
            provider: AuthProvider::GOOGLE,
            providerId: 'google-1',
            createdAt: new \DateTimeImmutable(),
        );

        $this->repository->save(
            $user,
        );

        self::assertTrue(
            true,
        );
    }

    public function test_find_by_id(): void
    {
        $id = UserId::fromString(
            '00000000-0000-0000-0000-000000000002',
        );

        $user = User::create(
            id: $id,
            email: 'find-id@example.com',
            name: 'Find By Id',
            avatar: null,
            provider: AuthProvider::GOOGLE,
            providerId: 'google-2',
            createdAt: new \DateTimeImmutable(),
        );

        $this->repository->save(
            $user,
        );

        $found = $this->repository->findById(
            $id,
        );

        self::assertNotNull(
            $found,
        );

        self::assertTrue(
            $found->id()->equals(
                $id,
            ),
        );
    }

    public function test_find_by_provider(): void
    {
        $user = User::create(
            id: UserId::fromString(
                '00000000-0000-0000-0000-000000000003',
            ),
            email: 'provider@example.com',
            name: 'Provider User',
            avatar: null,
            provider: AuthProvider::GOOGLE,
            providerId: 'google-provider-3',
            createdAt: new \DateTimeImmutable(),
        );

        $this->repository->save(
            $user,
        );

        $this->entityManager->flush();
        $this->entityManager->clear();

        $found = $this->repository->findByProvider(
            'google-provider-3',
        );

        self::assertNotNull(
            $found,
        );

        self::assertSame(
            'provider@example.com',
            $found->email(),
        );
    }
}
