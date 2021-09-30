<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\Fortify\Responses;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Validation\ValidationException;

class FailedTwoFactorLoginResponse implements Responsable
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
        $message = trans('ui::messages.invalid_2fa_authentication_code');

        $params = collect($request->only(['code', 'recovery_code']))
            ->filter()
            ->map(fn () => $message)
            ->all();

        if ($request->wantsJson()) {
            throw ValidationException::withMessages($params);
        }

        $request->session()->put([
            'login.id' => $request->session()->get('login.idFailure'),
        ]);

        return back()->withErrors($params);
    }
}
