<?php

declare(strict_types=1);

namespace App\Notification\Presentation\Controller;

use App\Identity\Domain\ValueObject\UserId;
use App\Notification\Application\Command\SubscribePushNotificationCommand;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\Exception\ExceptionInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
final class PushSubscriptionController extends AbstractController
{
    /**
     * @throws ExceptionInterface
     */
    #[Route(
        '/notification/push/subscribe',
        name: 'notification_push_subscribe',
        methods: ['POST'],
    )]
    public function __invoke(
        Request $request,
        MessageBusInterface $bus,
    ): JsonResponse {

        $payload = json_decode(
            $request->getContent(),
            true,
            JSON_THROW_ON_ERROR,
        );

        $bus->dispatch(
            new SubscribePushNotificationCommand(
                userId: UserId::fromString($this->getUser()->getUserIdentifier()),
                endpoint: $payload['endpoint'],
                publicKey: $payload['keys']['p256dh'],
                authToken: $payload['keys']['auth'],
            ),
        );

        return new JsonResponse([
            'success' => true,
        ]);
    }
}
