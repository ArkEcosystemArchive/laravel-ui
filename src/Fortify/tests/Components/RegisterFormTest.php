<?php

declare(strict_types=1);

namespace Tests\Components;

use ARKEcosystem\Fortify\Components\RegisterForm;
use Faker\Provider\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;
use Livewire\Livewire;
use Spatie\MediaLibrary\MediaCollections\Models\Concerns\HasUuid;

it('can interact with the form', function () {
    Config::set('fortify.models.invitation', RegisterFormTest::class);
    Route::get('terms-of-service', function () {
        return view('');
    })->name('terms-of-service');
    Route::get('privacy-policy', function () {
        return view('');
    })->name('privacy-policy');

    $invitationUuid = Uuid::uuid();

    Livewire::withQueryParams(['invitation' => $invitationUuid])
        ->test(RegisterForm::class)
        ->set('name', 'John Doe')
        ->set('username', 'jdoe')
        ->set('email', 'jdoe@example.org')
        ->set('email', 'jdoe@example.org')
        ->assertViewIs('ark-fortify::auth.register-form')
        ->assertViewHas('invitation');
});

it('cannot submit if all required fields are not filled', function () {
    Config::set('fortify.models.invitation', RegisterFormTest::class);
    Route::get('terms-of-service', function () {
        return view('');
    })->name('terms-of-service');
    Route::get('privacy-policy', function () {
        return view('');
    })->name('privacy-policy');

    $invitationUuid = Uuid::uuid();

    $instance = Livewire::withQueryParams(['invitation' => $invitationUuid])
        ->test(RegisterForm::class);

    expect($instance->instance()->canSubmit())->toBeFalse();

    $instance->set('name', 'John Doe');
    expect($instance->instance()->canSubmit())->toBeFalse();

    $instance->set('username', 'jdoe');
    expect($instance->instance()->canSubmit())->toBeFalse();

    $instance->set('email', 'jdoe@example.org');
    expect($instance->instance()->canSubmit())->toBeFalse();

    $instance->set('password', 'Password420007!');
    expect($instance->instance()->canSubmit())->toBeFalse();

    $instance->set('password_confirmation', 'Password420007!');
    expect($instance->instance()->canSubmit())->toBeFalse();

    $instance->set('terms', true);
    expect($instance->instance()->canSubmit())->toBeTrue();
});

it('cannot submit if the password appears to have been leaked', function () {
    Config::set('fortify.models.invitation', RegisterFormTest::class);
    Route::get('terms-of-service', function () {
        return view('');
    })->name('terms-of-service');
    Route::get('privacy-policy', function () {
        return view('');
    })->name('privacy-policy');

    $invitationUuid = Uuid::uuid();

    $instance = Livewire::withQueryParams(['invitation' => $invitationUuid])
        ->test(RegisterForm::class);

    expect($instance->instance()->canSubmit())->toBeFalse();

    $instance->set('name', 'John Doe');
    expect($instance->instance()->canSubmit())->toBeFalse();

    $instance->set('username', 'jdoe');
    expect($instance->instance()->canSubmit())->toBeFalse();

    $instance->set('email', 'jdoe@example.org');
    expect($instance->instance()->canSubmit())->toBeFalse();

    $instance->set('password', 'Password!1234');
    expect($instance->instance()->canSubmit())->toBeFalse();

    $instance->set('password_confirmation', 'Password!1234');
    expect($instance->instance()->canSubmit())->toBeFalse();

    $instance->set('terms', true);
    expect($instance->instance()->canSubmit())->toBeFalse();

    expect($instance->assertHasErrors('password'));
    expect($instance->assertSee(trans('fortify::validation.password_leaked')));
});

/**
 * @coversNothing
 */
class RegisterFormTest extends Model
{
    use HasUuid;

    public static function findByUuid(string $uuid): ?Model
    {
        return new self();
    }
}
