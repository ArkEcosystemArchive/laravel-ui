<?php

declare(strict_types=1);

namespace Tests\Components;

use ARKEcosystem\Foundation\Fortify\Components\ResetPasswordForm;
use Illuminate\Support\Facades\Config;
use Livewire\Livewire;
use function Tests\createUserModel;

it('can interact with the form', function () {
    $user = createUserModel();

    Livewire::actingAs($user)
        ->test(ResetPasswordForm::class)
        ->assertSet('email', null)
        ->assertSet('password', '')
        ->assertSet('password_confirmation', '')
        ->assertViewIs('ark-fortify::auth.reset-password-form');
});

it('gets the two factor code and the email', function () {
    Config::set('fortify.models.user', \ARKEcosystem\Foundation\Fortify\Models\User::class);

    $user = createUserModel();

    $user->two_factor_secret = 'secret';
    $user->save();

    Livewire::actingAs($user)
        ->test(ResetPasswordForm::class, ['email' => $user->email])
        ->assertSet('email', $user->email)
        ->assertSet('password', '')
        ->assertSet('password_confirmation', '')
        ->assertSet('twoFactorSecret', 'secret')
        ->assertViewIs('ark-fortify::auth.reset-password-form');
});
