<?php

declare(strict_types=1);

namespace App\Shared\Presentation\Turbo;

use Symfony\Component\HttpFoundation\Request;

final class TurboResponder
{
    public static function isTurbo(
        Request $request,
    ): bool {
        return str_contains(
            (string) $request->headers->get(
                'Accept',
                '',
            ),
            'text/vnd.turbo-stream.html',
        );
    }
}
