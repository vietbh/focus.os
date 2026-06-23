<?php

namespace App\Twig\Components\Task;

use App\SharedKernel\Presentation\LiveComponent\WithPagination;
use App\SharedKernel\Presentation\LiveComponent\WithSearch;
use App\SharedKernel\Presentation\LiveComponent\WithSorting;
use App\Task\Application\Query\TaskListCriteria;
use App\Task\Application\Query\TaskQueryInterface;
use App\Task\Application\UseCase\GetCurrentTaskUseCase;
use App\Task\Application\UseCase\GetTaskListUseCase;
use App\Task\Domain\Entity\Task;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\ComponentToolsTrait;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\TwigComponent\Attribute\ExposeInTemplate;

#[AsLiveComponent]
final class ListTasks extends AbstractController
{
    use DefaultActionTrait;
    use ComponentToolsTrait;

    use WithPagination;
    use WithSearch;
    use WithSorting;



    public function __construct(
        private readonly GetCurrentTaskUseCase $getCurrentTaskUseCase,
        private readonly TaskQueryInterface $taskQuery,
    )
    {
    }

    #[ExposeInTemplate]
    public function pagination(): PaginationInterface
    {
        return $this->taskQuery->paginate(
            new TaskListCriteria(
                userId: $this->userId(),
                search: $this->search,
                sort: $this->sort,
                direction: $this->direction,
                page: $this->page,
                perPage: $this->perPage,
            )
        );
    }

    #[ExposeInTemplate]
    public function currentTask(): ?Task
    {
        return $this->getCurrentTaskUseCase->execute(
            $this->userId(),
        );
    }

    public function userId(): string
    {
        $user = $this->getUser();

        if ($user === null) {
            throw $this->createAccessDeniedException();
        }
        return $user->getUserIdentifier();
    }
}
