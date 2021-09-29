<?php

declare(strict_types=1);

namespace ARKEcosystem\Fortify\Actions;

use Laravel\Fortify\Contracts\TwoFactorAuthenticationProvider;

class GenerateTwoFactorAuthenticationSecretKey
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
     * Generate a Two-Factor Authentication Secret Key.
     *
     * @return string
     */
    public function __invoke(): string
    {
        return $this->provider->generateSecretKey();
    }
}
