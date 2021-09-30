<?php

declare(strict_types=1);

namespace Tests\Components;

use ARKEcosystem\Foundation\Fortify\Components\UpdatePasswordForm;
use Illuminate\Contracts\Validation\UncompromisedVerifier;
use Livewire\Livewire;
use function Tests\createUserModel;

beforeEach(function () {
    $this->mock(UncompromisedVerifier::class)->shouldReceive('verify')->andReturn(true);
});

it('can interact with the form', function () {
    $user = createUserModel();

    Livewire::actingAs($user)
        ->test(UpdatePasswordForm::class)
        ->assertSet('currentPassword', '')
        ->assertSet('password', '')
        ->assertSet('password_confirmation', '')
        ->assertViewIs('ark-fortify::profile.update-password-form')
        ->set('currentPassword', 'password')
        ->set('password', 'abcd1234ABCD%')
        ->set('password_confirmation', 'abcd1234ABCD%')
        ->call('updatePassword')
        ->assertDispatchedBrowserEvent('updated-password')
        ->assertEmitted('toastMessage', [trans('fortify::pages.user-settings.password_updated'), 'success']);
});

it('clears password rules on update', function () {
    $user = createUserModel();

    Livewire::actingAs($user)
        ->test(UpdatePasswordForm::class)
        ->set('currentPassword', 'password')
        ->set('password', 'abcd1234ABCD%')
        ->set('password_confirmation', 'abcd1234ABCD%')
        ->assertSet('passwordRules', [
            'lowercase'  => true,
            'uppercase'  => true,
            'numbers'    => true,
            'symbols'    => true,
            'min'        => true,
            'leak'       => true,
        ])
        ->call('updatePassword')
        ->assertSet('passwordRules', [
            'lowercase'  => false,
            'uppercase'  => false,
            'numbers'    => false,
            'symbols'    => false,
            'min'        => false,
            'leak'       => false,
        ]);
});

it('handles password being null', function () {
    $user = createUserModel();

    Livewire::actingAs($user)
        ->test(UpdatePasswordForm::class)
        ->assertSet('currentPassword', '')
        ->assertSet('password', '')
        ->assertSet('password_confirmation', '')
        ->assertViewIs('ark-fortify::profile.update-password-form')
        ->set('currentPassword', 'password')
        ->set('password', null)
        ->set('password_confirmation', null)
        ->call('updatePassword')
        ->assertSet('passwordRules', [
            'lowercase'  => false,
            'uppercase'  => false,
            'numbers'    => false,
            'symbols'    => false,
            'min'        => false,
            'leak'       => false,
        ]);
});

it('handles password being empty string', function () {
    $user = createUserModel();

    Livewire::actingAs($user)
        ->test(UpdatePasswordForm::class)
        ->assertSet('currentPassword', '')
        ->assertSet('password', '')
        ->assertSet('password_confirmation', '')
        ->assertViewIs('ark-fortify::profile.update-password-form')
        ->set('currentPassword', 'password')
        ->set('password', '')
        ->set('password_confirmation', '')
        ->call('updatePassword')
        ->assertSet('passwordRules', [
            'lowercase'  => false,
            'uppercase'  => false,
            'numbers'    => false,
            'symbols'    => false,
            'min'        => false,
            'leak'       => false,
        ]);
});

it('handles password being leaked', function () {
    $user = createUserModel();

    Livewire::actingAs($user)
        ->test(UpdatePasswordForm::class)
        ->assertSet('currentPassword', '')
        ->assertSet('password', '')
        ->assertSet('password_confirmation', '')
        ->assertViewIs('ark-fortify::profile.update-password-form')
        ->set('currentPassword', 'password')
        ->set('password', 'password')
        ->set('password_confirmation', 'password')
        ->assertSet('passwordRules', [
            'lowercase'  => true,
            'uppercase'  => false,
            'numbers'    => false,
            'symbols'    => false,
            'min'        => false,
            'leak'       => false,
        ]);
});

it('clears password values', function () {
    $user = createUserModel();

    Livewire::actingAs($user)
        ->test(UpdatePasswordForm::class)
        ->set('currentPassword', 'password')
        ->set('password', 'abcd1234ABCD%')
        ->set('password_confirmation', 'abcd1234ABCD%')
        ->call('updatePassword')
        ->assertSet('currentPassword', '')
        ->assertSet('password', '')
        ->assertSet('password_confirmation', '');
});
