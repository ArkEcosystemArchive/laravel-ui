<?php

declare(strict_types=1);

use ARKEcosystem\Foundation\Fortify\Actions\CreateNewUser;
use ARKEcosystem\Foundation\Fortify\Models;
use Illuminate\Contracts\Validation\UncompromisedVerifier;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use function Tests\expectValidationError;
use Tests\Fortify\stubs\TestUser;

beforeEach(function () {
    $this->validPassword = 'Pas3w05d&123456';

    $this->mock(UncompromisedVerifier::class)->shouldReceive('verify')->andReturn(true);
});

it('should create a valid user with the create user action', function () {
    Config::set('fortify.models.user', \ARKEcosystem\Foundation\Fortify\Models\User::class);

    $user = (new CreateNewUser())->create([
        'name'                  => 'John Doe',
        'username'              => 'alfonsobries',
        'email'                 => 'john@doe.com',
        'password'              => $this->validPassword,
        'password_confirmation' => $this->validPassword,
        'terms'                 => true,
    ]);

    $this->assertSame('john@doe.com', $user->email);
    $this->assertSame('John Doe', $user->name);
    $this->assertTrue(Hash::check($this->validPassword, $user->password));
});

it('should create user and force lowercase email', function () {
    Config::set('fortify.models.user', \ARKEcosystem\Foundation\Fortify\Models\User::class);

    $user = (new CreateNewUser())->create([
        'name'                  => 'John Doe',
        'username'              => 'alfonsobries',
        'email'                 => 'JOHN@DOE.COM',
        'password'              => $this->validPassword,
        'password_confirmation' => $this->validPassword,
        'terms'                 => true,
    ]);

    $this->assertSame('john@doe.com', $user->email);
    $this->assertSame('John Doe', $user->name);
    $this->assertTrue(Hash::check($this->validPassword, $user->password));
});

it('should not create user with uppercase characters', function () {
    Config::set('fortify.models.user', \ARKEcosystem\Foundation\Fortify\Models\User::class);

    expectValidationError(fn () => (new CreateNewUser())->create([
        'name'                  => 'John Doe',
        'username'              => 'JOHNDOE',
        'email'                 => 'john@doe.com',
        'password'              => 'sec$r2t12345',
        'password_confirmation' => 'sec$r2t12345',
        'terms'                 => true,
    ]), 'username', trans('fortify::validation.messages.username.lowercase_only'));
});

it('should create a valid user with username if the username_alt setting is set', function () {
    Config::set('fortify.models.user', \ARKEcosystem\Foundation\Fortify\Models\User::class);
    Config::set('fortify.username_alt', 'username');

    $user = (new CreateNewUser())->create([
        'name'                  => 'John Doe',
        'username'              => 'alfonsobries',
        'email'                 => 'john@doe.com',
        'password'              => $this->validPassword,
        'password_confirmation' => $this->validPassword,
        'terms'                 => true,
    ]);

    $this->assertSame('john@doe.com', $user->email);
    $this->assertSame('alfonsobries', $user->username);
    $this->assertSame('John Doe', $user->name);
    $this->assertTrue(Hash::check($this->validPassword, $user->password));
});

it('should require a username if alt username is set', function () {
    Config::set('fortify.models.user', \ARKEcosystem\Foundation\Fortify\Models\User::class);

    Config::set('fortify.username_alt', 'username');

    expectValidationError(fn () => (new CreateNewUser())->create([
        'name'                  => 'John Doe',
        'email'                 => 'john@doe.com',
        'password'              => $this->validPassword,
        'password_confirmation' => $this->validPassword,
        'terms'                 => true,
    ]), 'username', 'The username field is required.');
});

it('should require an email', function () {
    Config::set('fortify.models.user', \ARKEcosystem\Foundation\Fortify\Models\User::class);

    expectValidationError(fn () => (new CreateNewUser())->create([
        'name'                  => 'John Doe',
        'username'              => 'alfonsobries',
        'email'                 => '',
        'password'              => $this->validPassword,
        'password_confirmation' => $this->validPassword,
        'terms'                 => true,
    ]), 'email', 'The email field is required.');
});

it('should require a valid email', function () {
    Config::set('fortify.models.user', \ARKEcosystem\Foundation\Fortify\Models\User::class);

    expectValidationError(fn () => (new CreateNewUser())->create([
        'name'                  => 'John Doe',
        'username'              => 'alfonsobries',
        'email'                 => 'alfonsobries',
        'password'              => $this->validPassword,
        'password_confirmation' => $this->validPassword,
        'terms'                 => true,
    ]), 'email', 'The email must be a valid email address.');
});

it('should require the terms to be accepted', function () {
    Config::set('fortify.models.user', \ARKEcosystem\Foundation\Fortify\Models\User::class);

    expectValidationError(fn () => (new CreateNewUser())->create([
        'name'                  => 'John Doe',
        'username'              => 'alfonsobries',
        'email'                 => 'john@doe.com',
        'password'              => $this->validPassword,
        'password_confirmation' => $this->validPassword,
        'terms'                 => false,
    ]), 'terms', 'The terms must be accepted.');
});

it('password should match the confirmation', function () {
    Config::set('fortify.models.user', \ARKEcosystem\Foundation\Fortify\Models\User::class);

    expectValidationError(fn () => (new CreateNewUser())->create([
        'name'                  => 'John Doe',
        'username'              => 'alfonsobries',
        'email'                 => 'john@doe.com',
        'password'              => $this->validPassword,
        'password_confirmation' => 'password',
        'terms'                 => false,
    ]), 'password', 'The password confirmation does not match.');
});

it('password should be equal to or longer than 12 characters', function () {
    Config::set('fortify.models.user', \ARKEcosystem\Foundation\Fortify\Models\User::class);

    expectValidationError(fn () => (new CreateNewUser())->create([
        'name'                  => 'John Doe',
        'username'              => 'alfonsobries',
        'email'                 => 'john@doe.com',
        'password'              => 'Sec$r2t',
        'password_confirmation' => 'Sec$r2t',
        'terms'                 => true,
    ]), 'password', 'The password must be at least 12 characters.');
});

it('password should require an uppercase letter', function () {
    Config::set('fortify.models.user', \ARKEcosystem\Foundation\Fortify\Models\User::class);

    expectValidationError(fn () => (new CreateNewUser())->create([
        'name'                  => 'John Doe',
        'username'              => 'alfonsobries',
        'email'                 => 'john@doe.com',
        'password'              => 'sec$r2t12345',
        'password_confirmation' => 'sec$r2t12345',
        'terms'                 => true,
    ]), 'password', 'The password must contain at least one uppercase and one lowercase letter.');
});

it('password should require one number', function () {
    Config::set('fortify.models.user', \ARKEcosystem\Foundation\Fortify\Models\User::class);

    expectValidationError(fn () => (new CreateNewUser())->create([
        'name'                  => 'John Doe',
        'username'              => 'alfonsobries',
        'email'                 => 'john@doe.com',
        'password'              => 'sec$%Asfhhdfhfdhgd',
        'password_confirmation' => 'sec$%Asfhhdfhfdhgd',
        'terms'                 => true,
    ]), 'password', 'The password must contain at least one number.');
});

it('password should require one special character', function () {
    Config::set('fortify.models.user', \ARKEcosystem\Foundation\Fortify\Models\User::class);

    expectValidationError(fn () => (new CreateNewUser())->create([
        'name'                  => 'John Doe',
        'username'              => 'alfonsobries',
        'email'                 => 'john@doe.com',
        'password'              => 'sec23Asfhhdfhfdhgd',
        'password_confirmation' => 'sec23Asfhhdfhfdhgd',
        'terms'                 => true,
    ]), 'password', 'The password must contain at least one symbol.');
});

it('handles the invitation parameter', function () {
    Config::set('fortify.models.user', \ARKEcosystem\Foundation\Fortify\Models\User::class);
    Config::set('fortify.models.invitation', TestUser::class);

    $user = (new CreateNewUser())->create([
        'name'                  => 'John Doe',
        'username'              => 'alfonsobries',
        'email'                 => 'john@doe.com',
        'password'              => $this->validPassword,
        'password_confirmation' => $this->validPassword,
        'terms'                 => true,
        'invitation'            => 'uuid-uuid-uuid-uuid',
    ]);

    $invitation = Models::invitation()::findByUuid('uuid-uuid-uuid-uuid');

    $this->assertSame($user->id, $invitation->user_id);
});

it('marks the user email as verified if has an invitation', function () {
    Config::set('fortify.models.user', \ARKEcosystem\Foundation\Fortify\Models\User::class);
    Config::set('fortify.models.invitation', TestUser::class);

    $user = (new CreateNewUser())->create([
        'name'                  => 'John Doe',
        'username'              => 'alfonsobries',
        'email'                 => 'john@doe.com',
        'password'              => $this->validPassword,
        'password_confirmation' => $this->validPassword,
        'terms'                 => true,
        'invitation'            => 'uuid-uuid-uuid-uuid',
    ]);

    $this->assertNotNull($user->email_verified_at);
});

it('doesnt mark the user email as verified if no ivitation ', function () {
    Config::set('fortify.models.user', \ARKEcosystem\Foundation\Fortify\Models\User::class);

    $user = (new CreateNewUser())->create([
        'name'                  => 'John Doe',
        'username'              => 'alfonsobries',
        'email'                 => 'john@doe.com',
        'password'              => $this->validPassword,
        'password_confirmation' => $this->validPassword,
        'terms'                 => true,
    ]);

    $this->assertNull($user->email_verified_at);
});

it('should require to have a properly formatted username', function () {
    Config::set('fortify.models.user', \ARKEcosystem\Foundation\Fortify\Models\User::class);

    expectValidationError(fn () => (new CreateNewUser())->create([
        'name'                  => 'John Doe',
        'username'              => '_johndoe',
        'email'                 => 'john@doe.com',
        'password'              => 'sec$r2t12345',
        'password_confirmation' => 'sec$r2t12345',
        'terms'                 => true,
    ]), 'username', trans('fortify::validation.messages.username.special_character_start'));
});

it('should work with username authentication', function () {
    Config::set('fortify.models.user', \ARKEcosystem\Foundation\Fortify\Models\User::class);
    Config::set('fortify.username_alt', 'username');

    $user = (new CreateNewUser())->create([
        'name'                  => 'John Doe',
        'username'              => 'alfonsobries',
        'email'                 => 'john@doe.com',
        'password'              => $this->validPassword,
        'password_confirmation' => $this->validPassword,
        'terms'                 => true,
    ]);

    $this->assertSame('john@doe.com', $user->email);
    $this->assertSame('John Doe', $user->name);
    $this->assertTrue(Hash::check($this->validPassword, $user->password));
});
