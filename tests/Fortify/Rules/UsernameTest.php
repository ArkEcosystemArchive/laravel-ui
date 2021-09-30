<?php

declare(strict_types=1);

use ARKEcosystem\Foundation\Fortify\Rules\Username;
use ARKEcosystem\Foundation\Fortify\Support\Enums\Constants;

beforeEach(function () {
    $this->subject = new Username();
});

it('handle null values', function () {
    expect($this->subject->passes('username', null))->toBeFalse();
});

it('will reject if the value starts with a special character', function () {
    expect($this->subject->passes('username', '_foo'))->toBeFalse();
    expect($this->subject->passes('username', '.foo'))->toBeFalse();

    expect($this->subject->message())->toBe(trans('ui::validation.messages.username.special_character_start'));
});

it('will reject if the value ends with a special character', function () {
    expect($this->subject->passes('username', 'foo_'))->toBeFalse();
    expect($this->subject->passes('username', 'foo.'))->toBeFalse();

    expect($this->subject->message())->toBe(trans('ui::validation.messages.username.special_character_end'));
});

it('will reject if the value contains consecutive special chars', function () {
    expect($this->subject->passes('username', 'foo__bar'))->toBeFalse();
    expect($this->subject->passes('username', 'foo..bar'))->toBeFalse();
    expect($this->subject->passes('username', 'foo_bar__baz'))->toBeFalse();
    expect($this->subject->passes('username', 'foo.bar..baz'))->toBeFalse();
    expect($this->subject->passes('username', 'consecutive._special_.chars'))->toBeFalse();

    expect($this->subject->message())->toBe(trans('ui::validation.messages.username.consecutive_special_characters'));
});

it('will reject if the value contains any forbidden special chars', function () {
    expect($this->subject->passes('username', 'foo!bar'))->toBeFalse();
    expect($this->subject->passes('username', 'foo=bar'))->toBeFalse();
    expect($this->subject->passes('username', 'foo?bar'))->toBeFalse();
    expect($this->subject->passes('username', 'foo&baz'))->toBeFalse();
    expect($this->subject->passes('username', 'foo,baz'))->toBeFalse();
    expect($this->subject->passes('username', 'foo;baz'))->toBeFalse();

    expect($this->subject->passes('username', 'foo¡baz'))->toBeFalse(); // inverted exclamation mark
    expect($this->subject->passes('username', 'foo¿baz'))->toBeFalse(); // inverted question mark
    expect($this->subject->passes('username', 'foo⸘baz'))->toBeFalse(); // inverted interrobang
    expect($this->subject->passes('username', 'foo‽baz'))->toBeFalse(); // interrobang
    expect($this->subject->passes('username', 'foo“baz'))->toBeFalse(); // letf double quotation mark
    expect($this->subject->passes('username', 'foo–baz'))->toBeFalse(); // en dash
    expect($this->subject->passes('username', 'foo—baz'))->toBeFalse(); // em dash
    expect($this->subject->passes('username', 'foo‑baz'))->toBeFalse(); // non-breaking hyphen
    expect($this->subject->passes('username', 'f😱😱baz'))->toBeFalse(); // emoji
    expect($this->subject->passes('username', 'f(oo)baz'))->toBeFalse(); // parentheses
    expect($this->subject->passes('username', 'f[oo]baz'))->toBeFalse();
    expect($this->subject->passes('username', 'f{oo}baz'))->toBeFalse();
    expect($this->subject->passes('username', 'f<oo>baz'))->toBeFalse();

    expect($this->subject->message())->toBe(trans('ui::validation.messages.username.forbidden_special_characters'));
});

it('will reject if the value is too short', function () {
    expect($this->subject->passes('username', 'a'))->toBeFalse();

    expect($this->subject->message())
        ->toBe(trans('ui::validation.messages.username.min_length', [
            'length'    => Constants::MIN_USERNAME_CHARACTERS,
        ]));
});

it('will reject if the value is too long', function () {
    expect($this->subject->passes('username', str_repeat('a', 31)))->toBeFalse();

    expect($this->subject->message())
        ->toBe(trans('ui::validation.messages.username.max_length', [
            'length'    => Constants::MAX_USERNAME_CHARACTERS,
        ]));
});

it('would not reject if value is using allowed characters', function () {
    expect($this->subject->passes('username', 'foo_bar'))->toBeTrue();
    expect($this->subject->passes('username', 'foo.bar'))->toBeTrue();
    expect($this->subject->passes('username', 'foo_bar.baz'))->toBeTrue();
    expect($this->subject->passes('username', 'foo.bar_baz'))->toBeTrue();
    expect($this->subject->passes('username', 'foo_123'))->toBeTrue();
    expect($this->subject->passes('username', 'foo.123'))->toBeTrue();
    expect($this->subject->passes('username', 'foo_123.baz'))->toBeTrue();
    expect($this->subject->passes('username', 'foo.123_baz'))->toBeTrue();
});

it('will reject if the value contains any uppercase character', function () {
    expect($this->subject->passes('username', 'Foo'))->toBeFalse();
    expect($this->subject->passes('username', 'fOo'))->toBeFalse();
    expect($this->subject->passes('username', 'foO'))->toBeFalse();
    expect($this->subject->passes('username', 'Foo_bar'))->toBeFalse();
    expect($this->subject->passes('username', 'foo_Bar'))->toBeFalse();
    expect($this->subject->passes('username', 'Foo_Bar'))->toBeFalse();
    expect($this->subject->passes('username', 'Foo.bar'))->toBeFalse();
    expect($this->subject->passes('username', 'foo.Bar'))->toBeFalse();
    expect($this->subject->passes('username', 'Foo.Bar'))->toBeFalse();

    expect($this->subject->message())->toBe(trans('ui::validation.messages.username.lowercase_only'));
});

it('will not reject if the value contains only lowercase character', function () {
    expect($this->subject->passes('username', 'foo'))->tobeTrue();
    expect($this->subject->passes('username', 'foo_bar'))->tobeTrue();
    expect($this->subject->passes('username', 'foo.bar'))->tobeTrue();
});

it('will reject if the value contains any blacklisted name', function ($username) {
    expect($this->subject->passes('username', $username))->toBeFalse();

    expect($this->subject->message())->toBe(trans('ui::validation.messages.username.blacklisted'));
})->with([
    'admin',
    'root',
    'www',
    'president',
    'server',
    'staff',
]);

it('will not reject if the value not contains blacklisted name', function ($username) {
    expect($this->subject->passes('username', $username))->toBeTrue();
})->with([
    'johndoe',
    'john.doe',
    'aboutme',
    'about.you',
]);
