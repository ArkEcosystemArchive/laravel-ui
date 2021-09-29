<?php

declare(strict_types=1);

use ARKEcosystem\Fortify\Rules\OneTimePassword;

it('can check for wrong OTP', function () {
    $rule = (new OneTimePassword('secret'));

    expect($rule->passes('password', 'no-secret'))->toBeFalse();
});

it('can provider feedback on what was wrong', function () {
    $rule = (new OneTimePassword('secret'));

    expect($rule->message())->toBe('We were not able to enable two-factor authentication with this one-time password.');
});
