<?php

namespace App\Twig\Components\Focus;

use App\Focus\Application\DTO\FocusSessionDto;
use App\Focus\Application\Facade\FocusFacade;
use App\Identity\Domain\ValueObject\UserId;
use App\Task\Domain\ValueObject\TaskId;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveListener;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent]
final class FocusWidget
{
    use DefaultActionTrait;

    #[LiveProp(useSerializerForHydration: true)]
    public ?FocusSessionDto $session = null;

    #[LiveProp(updateFromParent: true)]
    public string $taskId;

    public function __construct(
        private readonly FocusFacade $focus,
        private readonly Security $security
    )
    {
    }

    public function mount(): void
    {
        $this->reload();
    }

    private function reload(): void
    {
        $this->session = $this->focus->current($this->userId());
    }

    private function userId(): UserId
    {
        $user = $this->security->getUser();

        return UserId::fromString($user->getUserIdentifier());
    }

    #[LiveListener('start')]
    public function start(): void
    {
        $this->focus->start(
            UserId::fromString($this->userId()),
            TaskId::fromString($this->taskId),
        );
        $this->reload();

    }

    #[LiveAction]
    public function pause(): void
    {
        $this->focus->pause(
            $this->session->id,
        );
            $this->reload();
    }

    #[LiveAction]
    public function resume(): void
    {
        $this->focus->resume(
            $this->session->id,
        );
        $this->reload();
    }

    #[LiveAction]
    public function stop(): void
    {
        $this->focus->stop(
            $this->session->id,
        );
        $this->reload();
    }

}
