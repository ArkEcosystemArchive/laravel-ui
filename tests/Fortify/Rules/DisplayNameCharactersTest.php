<?php

declare(strict_types=1);

use ARKEcosystem\Foundation\Fortify\Rules\DisplayNameCharacters;

beforeEach(function (): void {
    $this->subject = new DisplayNameCharacters();
});

it('accepts name with regular characters', function ($name) {
    $this->assertTrue($this->subject->passes('name', $name));
})->with([
    'Elon Tusk',
    'Rick Astley',
    'Los Pollos Hermanos',
    'Alix',
    'H4nn3 Andersen',
    'Hans',
    'Michel The 3rd',
    '3llo',
]);

it('accepts name with unicode characters', function ($name) {
    $this->assertTrue($this->subject->passes('name', $name));
})->with([
    'André Svenson',
    'John Elkjærd',
    'X Æ A-12',
    'Ñoño',
    'François Hollande',
    'Jean-François d\'Abiguäel',
    'Jean-François d’Abiguäel',
    'Père Noël',
    'Alfonso & sons',
    'Coca.Cola',
    'Procter, Cremin and Crist',
]);

it('accepts name with single quote', function () {
    $this->assertTrue($this->subject->passes('name', 'Marco d\'Almeida'));
});

it('doesnt accept other special characters', function ($name) {
    $this->assertFalse($this->subject->passes('name', $name));
})->with([
    'Martin Henriksen!',
    '@alfonsobries',
    'php=cool',
    '🤓', // EMOJI
    '¯', // MACRON
    '­', // SOFT HYPHEN
    '–', // EN DASH
    '‑', // NON-BREAKING HYPHEN
    '—', // EM DASH
    '_', // UNDERSCORE
]);

it('doesnt accept repetitive characters', function ($name) {
    expect($this->subject->passes('name', $name))->toBeFalse();

    expect($this->subject->message())->toBe(trans('fortify::validation.messages.some_special_characters'));
})->with([
    'Marco d\'\'Almeida',
    'Marco d’’Almeida',
    'Alfonso && sons',
    'Jean--François',
    'Coca..Cola',
    'Procter,, Cremin and Crist',
]);

it('has a message', function () {
    $this->assertEquals(trans('fortify::validation.messages.some_special_characters'), $this->subject->message());
});

it('will reject if the value contains any blacklisted name', function ($name) {
    expect($this->subject->passes('name', $name))->toBeFalse();

    expect($this->subject->message())->toBe(trans('fortify::validation.messages.username.blacklisted'));
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

it('will not reject if the value does not contain blacklisted name', function ($name) {
    expect($this->subject->passes('name', $name))->toBeTrue();
})->with([
    'johndoe',
    'john.doe',
    'aboutme',
    'about.you',
]);
