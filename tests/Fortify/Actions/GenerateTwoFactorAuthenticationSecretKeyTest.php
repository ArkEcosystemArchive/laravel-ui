<?php

declare(strict_types=1);

use ARKEcosystem\Foundation\Fortify\Actions\GenerateTwoFactorAuthenticationSecretKey;

it('should generate a two factor secret key', function () {
    $secretKey = resolve(GenerateTwoFactorAuthenticationSecretKey::class)();

    expect($secretKey)->toBeString();
});
