<?php

declare(strict_types=1);

use ARKEcosystem\Foundation\Fortify\Actions\EnableTwoFactorAuthentication;
use function Tests\createUserModel;

it('should enable two factor authentication', function () {
    $user = createUserModel();

    expect($user->two_factor_secret)->toBeNull();
    expect($user->two_factor_recovery_codes)->toBeNull();

    resolve(EnableTwoFactorAuthentication::class)($user, 'secretKey');

    expect($user->two_factor_secret)->not()->toBeNull();
    expect($user->two_factor_recovery_codes)->not()->toBeNull();
});
