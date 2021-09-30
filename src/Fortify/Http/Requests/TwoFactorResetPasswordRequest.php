<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\Fortify\Http\Requests;

use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Http\Exceptions\HttpResponseException;
use Laravel\Fortify\Contracts\FailedTwoFactorLoginResponse;
use Laravel\Fortify\Http\Requests\TwoFactorLoginRequest;

class TwoFactorResetPasswordRequest extends TwoFactorLoginRequest
{
    /**
     * Determine if the reset token is valid.
     *
     * @return bool
     */
    public function hasValidToken()
    {
        $user = $this->challengedUser();

        return $user && app(PasswordBroker::class)->tokenExists($user, $this->route('token'));
    }

    /**
     * Determine if there is a challenged user in the current session.
     *
     * @return bool
     */
    public function hasChallengedUser()
    {
        $model = app(StatefulGuard::class)->getProvider()->getModel();

        return $this->has('email') &&
            $model::whereEmail($this->get('email'))->exists();
    }

    /**
     * Get the user that is attempting the two factor challenge.
     *
     * @return mixed
     */
    public function challengedUser()
    {
        if ($this->challengedUser) {
            return $this->challengedUser;
        }

        $model = app(StatefulGuard::class)->getProvider()->getModel();

        if (! $this->has('email') ||
            ! $user = $model::whereEmail($this->get('email'))->first()) {
            throw new HttpResponseException(
                app(FailedTwoFactorLoginResponse::class)->toResponse($this)
            );
        }

        return $this->challengedUser = $user;
    }
}
