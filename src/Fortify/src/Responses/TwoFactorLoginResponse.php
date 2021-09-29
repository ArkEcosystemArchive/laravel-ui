<?php

declare(strict_types=1);

namespace ARKEcosystem\Fortify\Responses;

use Illuminate\Http\JsonResponse;
use Laravel\Fortify\Http\Responses\TwoFactorLoginResponse as Fortify;

class TwoFactorLoginResponse extends Fortify
{
    /**
     * {@inheritdoc}
     */
    public function toResponse($request)
    {
        if ($request->wantsJson()) {
            return new JsonResponse('', 204);
        }

        if ($request->session()->has('url.intended')) {
            return redirect($request->session()->pull('url.intended'));
        }

        return redirect(config('fortify.home'));
    }
}
