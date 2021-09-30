<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\Fortify\Http\Controllers;

use ARKEcosystem\Foundation\Fortify\Http\Requests\TwoFactorResetPasswordRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Routing\Controller;
use Laravel\Fortify\Contracts\FailedTwoFactorLoginResponse;

class TwoFactorAuthenticatedPasswordResetController extends Controller
{
    /**
     * Show the two factor authentication challenge view.
     *
     * @param TwoFactorResetPasswordRequest $request
     * @param string                        $token
     *
     * @return mixed
     */
    public function create(TwoFactorResetPasswordRequest $request, string $token)
    {
        if (! $request->hasChallengedUser()) {
            throw new HttpResponseException(redirect()->route('login'));
        }

        if (! $request->hasValidToken()) {
            throw new HttpResponseException(redirect()->route('login')->withErrors(['email' => trans('ui::validation.password_reset_link_invalid')]));
        }

        return view('ark-fortify::auth.two-factor-challenge', [
            'token'         => $token,
            'resetPassword' => true,
            'email'         => $request->challengedUser()->email,
        ]);
    }

    /**
     * Validates the 2fa code and shows the reset password form.
     *
     * @param TwoFactorResetPasswordRequest $request
     *
     * @return mixed
     */
    public function store(TwoFactorResetPasswordRequest $request)
    {
        $user = $request->challengedUser();

        if (! $request->hasValidToken()) {
            throw new HttpResponseException(redirect()->route('login')->withErrors(['email' => trans('ui::validation.password_reset_link_invalid')]));
        }

        if ($code = $request->validRecoveryCode()) {
            $user->replaceRecoveryCode($code);
        } elseif (! $request->hasValidCode()) {
            return app(FailedTwoFactorLoginResponse::class);
        }

        return view('ark-fortify::auth.reset-password');
    }
}
