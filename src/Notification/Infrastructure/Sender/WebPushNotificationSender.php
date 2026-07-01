<?php

declare(strict_types=1);

namespace App\Notification\Infrastructure\Sender;

use App\Identity\Domain\ValueObject\UserId;
use App\Notification\Application\Contract\NotificationSenderInterface;
use App\Notification\Application\ValueObject\NotificationMessage;
use App\Notification\Domain\Repository\PushSubscriptionRepositoryInterface;
use Minishlink\WebPush\Subscription;
use Minishlink\WebPush\WebPush;
use Random\RandomException;

final readonly class WebPushNotificationSender implements NotificationSenderInterface
{
    public function __construct(
        private PushSubscriptionRepositoryInterface $subscriptions,
        private WebPush $webPush,
    ) {
    }

    /**
     * @throws RandomException
     * @throws \ErrorException
     * @throws \JsonException
     */
    public function send(
        UserId $userId,
        NotificationMessage $message,
    ): void {

        $subscriptions = $this->subscriptions->findByUser(
            $userId,
        );

        if ($subscriptions === []) {
            return;
        }

        $payload = json_encode(
            [
                'title' => $message->title(),
                'body' => $message->body(),
                'url' => $message->url(),
                'icon' => $message->icon(),
                'badge' => $message->badge(),
            ],
            JSON_THROW_ON_ERROR,
        );

        $map = [];


        foreach ($subscriptions as $subscription) {

            $map[$subscription->endpoint()] = $subscription;

            $this->webPush->queueNotification(
                Subscription::create(
                    [
                        'endpoint' => $subscription->endpoint(),
                        'publicKey' => $subscription->publicKey(),
                        'authToken' => $subscription->authToken(),
                    ],
                ),
                $payload,
            );
        }

        foreach ($this->webPush->flush() as $report) {

            if ($report->isSuccess()) {
                continue;
            }

            $subscription = $map[$report->getEndpoint()] ?? null;

            if ($subscription === null) {
                continue;
            }

            $this->subscriptions->remove($subscription);

        }
        $this->subscriptions->flush();
    }
}
