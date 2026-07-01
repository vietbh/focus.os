<?php

declare(strict_types=1);

namespace App\Notification\Application\Handler;

use App\Notification\Application\Command\SubscribePushNotificationCommand;
use App\Notification\Domain\Entity\PushSubscription;
use App\Notification\Domain\Repository\PushSubscriptionRepositoryInterface;
use App\Notification\Domain\ValueObject\PushSubscriptionId;
use App\Notification\Domain\ValueObject\PushSubscriptionKeys;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class SubscribePushNotificationHandler
{
    public function __construct(
        private PushSubscriptionRepositoryInterface $repository,
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function __invoke(
        SubscribePushNotificationCommand $command,
    ): void {
        $subscription = $this->repository->findByEndpoint(
            $command->endpoint,
        );

        if ($subscription !== null) {

            $subscription->update(
               new PushSubscriptionKeys(
                   endpoint: $command->endpoint,
                   publicKey: $command->publicKey,
                   authToken: $command->authToken,
               )
            );

            $this->entityManager->flush();

            return;
        }

        $this->repository->save(
            PushSubscription::subscribe(
                id: PushSubscriptionId::generate(),
                userId: $command->userId,
                keys: new PushSubscriptionKeys(
                    endpoint: $command->endpoint,
                    publicKey: $command->publicKey,
                    authToken: $command->authToken,
                )
            ),
        );

        $this->entityManager->flush();
    }
}
