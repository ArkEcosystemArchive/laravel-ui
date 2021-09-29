<?php

declare(strict_types=1);

namespace ARKEcosystem\Fortify\Actions;

use Illuminate\Support\Collection;
use Laravel\Fortify\Contracts\TwoFactorAuthenticationProvider;
use Laravel\Fortify\RecoveryCode;

class EnableTwoFactorAuthentication
{
    /**
     * The two factor authentication provider.
     *
     * @var \Laravel\Fortify\Contracts\TwoFactorAuthenticationProvider
     */
    protected $provider;

    /**
     * Create a new action instance.
     *
     * @param \Laravel\Fortify\Contracts\TwoFactorAuthenticationProvider $provider
     *
     * @return void
     */
    public function __construct(TwoFactorAuthenticationProvider $provider)
    {
        $this->provider = $provider;
    }

    /**
     * Enable two factor authentication for the user.
     *
     * @param mixed  $user
     * @param string $secretKey
     *
     * @return void
     */
    public function __invoke($user, string $secretKey)
    {
        $user->forceFill([
            'two_factor_secret'         => encrypt($secretKey),
            'two_factor_recovery_codes' => encrypt(json_encode(Collection::times(8, function () {
                return RecoveryCode::generate();
            })->all())),
        ])->save();
    }
}
