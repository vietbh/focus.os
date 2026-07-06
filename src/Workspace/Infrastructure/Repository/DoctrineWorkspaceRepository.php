<?php

namespace App\Workspace\Infrastructure\Repository;

use App\Identity\Domain\ValueObject\UserId;
use App\Workspace\Domain\Entity\Workspace;
use App\Workspace\Domain\Exception\WorkspaceException;
use App\Workspace\Domain\Repository\WorkspaceRepositoryInterface;
use App\Workspace\Domain\ValueObject\WorkspaceId;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class DoctrineWorkspaceRepository  extends ServiceEntityRepository implements WorkspaceRepositoryInterface
{
    public function __construct(
        ManagerRegistry $registry,
    )
    {
        parent::__construct(
            $registry,
            Workspace::class,
        );
    }

    public function save(
        Workspace $workspace,
    ): void {
        $this->getEntityManager()->persist($workspace);
        $this->getEntityManager()->flush();
    }

    public function remove(
        Workspace $workspace,
    ): void {
        $this->getEntityManager()->remove($workspace);
        $this->getEntityManager()->flush();
    }

    public function findByOwner(
        UserId $ownerId,
    ): array {
        return $this->createQueryBuilder('w')
            ->andWhere('w.ownerId = :ownerId')
            ->setParameter('ownerId', $ownerId)
            ->orderBy('w.name.value', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function existsByOwnerAndName(
        UserId $ownerId,
        string $name,
    ): bool {
        return null !== $this->createQueryBuilder('w')
                ->select('w.id')
                ->andWhere('w.ownerId = :ownerId')
                ->andWhere('w.name = :name')
                ->setParameter('ownerId', $ownerId)
                ->setParameter('name', $name)
                ->setMaxResults(1)
                ->getQuery()
                ->getOneOrNullResult();
    }

    public function get(
        WorkspaceId $id,
    ): Workspace {
        $workspace = $this->find($id);

        if ($workspace === null) {
            throw WorkspaceException::notFound();
        }

        return $workspace;
    }

}
