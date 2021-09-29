<?php

declare(strict_types=1);

namespace ARKEcosystem\Fortify\Responses;

use ARKEcosystem\Fortify\Models;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Http\JsonResponse;
use Laravel\Fortify\Contracts\RegisterResponse as RegisterResponseContract;

final class RegisterResponse implements RegisterResponseContract
{
    /**
     * Create an HTTP response that represents the object.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function toResponse($request)
    {
        if ($request->wantsJson()) {
            return new JsonResponse('', 201);
        }

        if (config('fortify.accept_invitation_route')) {
            $invitationId = $request->get('invitation');
            if ($invitationId) {
                $invitation = Models::invitation()::findByUuid($invitationId);
                if ($invitation->user()->is($request->user())) {
                    $urlGenerator = app(UrlGenerator::class);
                    $url          = $urlGenerator->route(config('fortify.accept_invitation_route'), $invitation);

                    return redirect()->to($url);
                }
            }
        }

        if ($request->user() instanceof MustVerifyEmail) {
            return redirect()->route('verification.notice');
        }

        return redirect('/');
    }
}
