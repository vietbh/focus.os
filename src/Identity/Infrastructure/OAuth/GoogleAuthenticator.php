<?php

declare(strict_types=1);

namespace App\Identity\Infrastructure\OAuth;

use App\Identity\Application\UseCase\FindOrCreateUserUseCase;
use App\Identity\Infrastructure\Security\SecurityUser;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;

final class GoogleAuthenticator extends AbstractAuthenticator
{
    public function __construct(
        private readonly GoogleOAuthProvider $googleOAuthProvider,
        private readonly FindOrCreateUserUseCase $findOrCreateUserUseCase,
        private readonly UrlGeneratorInterface $urlGenerator,
    ) {
    }

    public function supports(
        Request $request,
    ): ?bool {
        return $request->attributes->get('_route')
            === 'identity_google_callback';
    }

    public function authenticate(
        Request $request,
    ): Passport {
        $oauthUserData = $this->googleOAuthProvider
            ->getUserData(
                $request,
            );

        $user = $this->findOrCreateUserUseCase
            ->execute(
                $oauthUserData,
            );

        return new SelfValidatingPassport(
            new UserBadge(
                $user->id()->value(),
                fn (): SecurityUser => new SecurityUser(
                    $user,
                ),
            ),
        );
    }

    public function onAuthenticationSuccess(
        Request $request,
        TokenInterface $token,
        string $firewallName,
    ): ?Response {
        return new RedirectResponse(
            $this->urlGenerator->generate(
                'dashboard'
            ),
        );
    }

    public function onAuthenticationFailure(
        Request $request,
        AuthenticationException $exception,
    ): ?Response {
        return new RedirectResponse(
            $this->urlGenerator->generate(
                'identity_login',
            ),
        );
    }

}
