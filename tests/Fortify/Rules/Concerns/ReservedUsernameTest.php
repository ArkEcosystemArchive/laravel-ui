<?php

declare(strict_types=1);

use ARKEcosystem\Foundation\Fortify\Rules\Concerns\ReservedUsername;

beforeEach(function () {
    $this->subject = new ReservedUsername();
});

it('doesnt allow adding username that is blacklisted', function ($username) {
    expect($this->subject->passes('username', $username))->toBeFalse();

    expect($this->subject->message())->toBe(trans('ui::validation.messages.username.blacklisted'));
})->with([
    'admin',
    'root',
    'www',
    'president',
    'server',
    'staff',
    'Admin',
    'RoOt',
    'Www',
    'PresIDent',
    'ServEr',
    'StAfF',
]);

it('allows adding username that isn\'t blacklisted', function ($username) {
    expect($this->subject->passes('username', $username))->toBeTrue();
})->with([
    'johndoe',
    'john.doe',
    'aboutme',
    'about.you',
]);
