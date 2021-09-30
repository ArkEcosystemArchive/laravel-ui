<?php

declare(strict_types=1);

use ARKEcosystem\Foundation\Fortify\Components\TwoFactorAuthenticationForm;
use Illuminate\Support\Facades\Config;
use Livewire\Livewire;
use PragmaRX\Google2FALaravel\Google2FA;
use function Tests\createUserModel;

it('can interact with the form', function () {
    $user = createUserModel();

    $g2FA = $this->mock(Google2FA::class);
    $g2FA->shouldReceive('verifyKey')
        ->andReturnTrue();
    app()->instance('pragmarx.google2fa', $g2FA);

    $two_factor_secret = 'QHBRXHLWOT3B2T3L';
    Livewire::actingAs($user)
        ->test(TwoFactorAuthenticationForm::class)
        ->assertSee('You have not enabled two factor authentication.')
        ->set('state.two_factor_secret', $two_factor_secret)
        ->assertSet('enabled', false)
        ->assertSee($two_factor_secret)
        ->set('state.otp', '8437339')
        ->call('enableTwoFactorAuthentication')
        ->assertHasErrors(['state.otp' => 'digits'])
        ->set('state.otp', '843733')
        ->call('enableTwoFactorAuthentication')
        ->assertSee('Two-Factor Authentication Recovery Codes')
        ->assertSee('If you lose your two-factor authentication device')
        ->call('regenerateRecoveryCodes')
        ->assertSee('Two-Factor Authentication Recovery Codes')
        ->call('hideRecoveryCodes')
        ->assertSee('You have enabled two factor authentication')
        ->call('showConfirmPassword')
        ->assertSee('Input your password to show your emergency two-factor recovery codes.')
        ->set('confirmedPassword', 'password')
        ->call('showRecoveryCodesAfterPasswordConfirmation')
        ->assertSee('If you lose your two-factor authentication device')
        ->call('hideRecoveryCodes')
        ->call('showDisableConfirmPassword')
        ->assertSee('Input your password to disable the two-factor authentication method.')
        ->set('confirmedPassword', 'password')
        ->call('disableTwoFactorAuthentication')
        ->assertSee('You have not enabled two factor authentication');
});

it('should not show recovery codes if wrong password', function () {
    $user = createUserModel();

    $g2FA = $this->mock(Google2FA::class);
    $g2FA->shouldReceive('verifyKey')
        ->andReturnTrue();
    app()->instance('pragmarx.google2fa', $g2FA);

    $two_factor_secret = 'QHBRXHLWOT3B2T3L';
    Livewire::actingAs($user)
        ->test(TwoFactorAuthenticationForm::class)
        ->assertSee('You have not enabled two factor authentication.')
        ->set('state.two_factor_secret', $two_factor_secret)
        ->assertSet('enabled', false)
        ->assertSee($two_factor_secret)
        ->set('state.otp', '843733')
        ->call('enableTwoFactorAuthentication')
        ->assertSee('Two-Factor Authentication Recovery Codes')
        ->call('hideRecoveryCodes')
        ->call('showConfirmPassword')
        ->assertSee('Input your password to show your emergency two-factor recovery codes.')
        ->set('confirmedPassword', 'wrong-password')
        ->call('showRecoveryCodesAfterPasswordConfirmation')
        ->assertDontSee('If you lose your two-factor authentication device');
});

it('should not disable if wrong password', function () {
    $user = createUserModel();

    $g2FA = $this->mock(Google2FA::class);
    $g2FA->shouldReceive('verifyKey')
        ->andReturnTrue();
    app()->instance('pragmarx.google2fa', $g2FA);

    $two_factor_secret = 'QHBRXHLWOT3B2T3L';
    Livewire::actingAs($user)
        ->test(TwoFactorAuthenticationForm::class)
        ->assertSee('You have not enabled two factor authentication.')
        ->set('state.two_factor_secret', $two_factor_secret)
        ->assertSet('enabled', false)
        ->assertSee($two_factor_secret)
        ->set('state.otp', '843733')
        ->call('enableTwoFactorAuthentication')
        ->assertSee('Two-Factor Authentication Recovery Codes')
        ->call('hideRecoveryCodes')
        ->call('showDisableConfirmPassword')
        ->assertSee('Input your password to disable the two-factor authentication method.')
        ->set('confirmedPassword', 'wrong password')
        ->call('disableTwoFactorAuthentication')
        ->assertDontSee('You have not enabled two factor authentication');
});

it('shows email after scanning qr-code on mobile device', function (): void {
    $user = createUserModel();

    $instance = Livewire::actingAs($user)
        ->test(TwoFactorAuthenticationForm::class)
        ->instance();

    expect($instance->twoFactorQrCodeUrl)->toContain(urlencode($user->email));
});

it('shows username after scanning qr-code on mobile device', function (): void {
    Config::set('fortify.username', 'username');

    $user = createUserModel();

    $instance = Livewire::actingAs($user)
        ->test(TwoFactorAuthenticationForm::class)
        ->instance();

    expect($instance->twoFactorQrCodeUrl)->toContain(urlencode($user->username));
});
