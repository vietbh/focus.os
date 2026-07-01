<?php

namespace App\Focus\Application\Handler;

use App\Focus\Application\Message\FocusDurationReachedMessage;
use App\Focus\Domain\Exception\FocusSessionException;
use App\Focus\Domain\Repository\FocusSessionRepositoryInterface;
use App\Notification\Application\ValueObject\NotificationMessage;
use App\Notification\Infrastructure\Sender\WebPushNotificationSender;
use Random\RandomException;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

#[AsMessageHandler]
final readonly class FocusDurationReachedHandler
{

    public function __construct(
        private FocusSessionRepositoryInterface $focusSessionRepository,
        private WebPushNotificationSender $webPushNotificationSender,
        public UrlGeneratorInterface $urlGenerator,
    )
    {
    }

    /**
     * @throws RandomException
     * @throws \JsonException
     * @throws \ErrorException
     */
    public function __invoke(
        FocusDurationReachedMessage $message,
    ): void {
        $session = $this->focusSessionRepository->ofId($message->sessionId);

        if ($session === null) {
            throw FocusSessionException::notFound();
        }

        if ($session->isCompleted()) {
            return;
        }
        $this->webPushNotificationSender->send(
            $session->userId(),
            new NotificationMessage(
                title: '⏰ Focus time completed',
                body: 'Your planned focus time has ended, but the task is not completed yet.',
                url: $this->urlGenerator->generate('task_detail', [
                    'taskId' => $session->taskId()->value(),
                ]),
                icon: '/images/pwa/icon-192.png',
                badge: '/images/pwa/badge-72.png',
            ),
        );
    }
}
