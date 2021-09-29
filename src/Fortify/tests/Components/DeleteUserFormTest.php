<?php

declare(strict_types=1);

namespace Tests\Components;

use ARKEcosystem\Fortify\Components\DeleteUserForm;
use ARKEcosystem\Fortify\Contracts\DeleteUser;
use ARKEcosystem\Fortify\Mail\SendFeedback;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
use Livewire\Livewire;
use function Tests\createUserModel;

it('can interact with the form', function () {
    Route::get('/', fn () => [])->name('home');

    $user = createUserModel();

    $this->mock(DeleteUser::class)
        ->shouldReceive('delete');

    Livewire::actingAs($user)
        ->test(DeleteUserForm::class)
        ->assertViewIs('ark-fortify::profile.delete-user-form')
        ->call('confirmUserDeletion')
        ->assertSee(trans('fortify::pages.user-settings.delete_account_description'))
        ->set('usernameConfirmation', $user->username)
        ->call('deleteUser')
        ->assertRedirect('/');
    $this->assertNull(Auth::user());
});

it('can interact with the form and leave a feedback', function () {
    Mail::fake();

    $user = createUserModel();

    $this->mock(DeleteUser::class)
        ->shouldReceive('delete');

    Livewire::actingAs($user)
        ->test(DeleteUserForm::class)
        ->assertViewIs('ark-fortify::profile.delete-user-form')
        ->call('confirmUserDeletion')
        ->assertSee(trans('fortify::pages.user-settings.delete_account_description'))
        ->set('usernameConfirmation', $user->username)
        ->set('feedback', 'my feedback here')
        ->call('deleteUser')
        ->assertRedirect(URL::temporarySignedRoute('profile.feedback.thank-you', now()->addMinutes(15)));
    $this->assertNull(Auth::user());

    Mail::assertQueued(SendFeedback::class, function ($mail) {
        return $mail->hasTo(config('fortify.mail.feedback.address')) &&
            $mail->message === 'my feedback here';
    });
});

it('cant delete user without filling in the username', function () {
    $user = createUserModel();

    $this->mock(DeleteUser::class)
        ->shouldReceive('delete');

    Livewire::actingAs($user)
        ->test(DeleteUserForm::class)
        ->assertViewIs('ark-fortify::profile.delete-user-form')
        ->call('confirmUserDeletion')
        ->assertSee(trans('fortify::pages.user-settings.delete_account_description'))
        ->call('deleteUser')
        ->set('usernameConfirmation', 'invalid-username')
        ->call('deleteUser');
    $this->assertNotNull(Auth::user());
});
