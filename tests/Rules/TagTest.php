<?php

declare(strict_types=1);

use ARKEcosystem\UserInterface\Rules\Tag;
use ARKEcosystem\UserInterface\Support\Enums\Constants;

beforeEach(function () {
    $this->subject = new Tag();
});

it('handle null values', function () {
    expect($this->subject->passes('tag', null))->toBeFalse();
});

it('accepts a word', function () {
    expect($this->subject->passes('tag', 'hello'))->toBeTrue();
});

it('accepts a word with uppercase letters', function () {
    expect($this->subject->passes('tag', 'Hello'))->toBeTrue();
    expect($this->subject->passes('tag', 'hellO'))->toBeTrue();
});

it('accepts a word with -', function () {
    expect($this->subject->passes('tag', 'hello-world'))->toBeTrue();
});

it('accepts a word with numbers', function () {
    expect($this->subject->passes('tag', 'hello123world'))->toBeTrue();
});

it('accepts a word with a space', function () {
    expect($this->subject->passes('tag', 'hello world'))->toBeTrue();
});

it('accepts a three character word', function () {
    expect($this->subject->passes('tag', 'foo'))->toBeTrue();
});

it('accepts a thirty character word', function () {
    expect($this->subject->passes('tag', str_repeat('a', Constants::MAX_TAG_LENGTH)))->toBeTrue();
});

it('does not accept a two characters word', function () {
    expect($this->subject->passes('tag', 'fo'))->toBeFalse();

    expect($this->subject->message())->toBe(trans('ui::validation.tag.min_length'));
});

it('does not accept a thirty one characters word', function () {
    expect($this->subject->passes('tag', str_repeat('a', Constants::MAX_TAG_LENGTH + 1)))->toBeFalse();

    expect($this->subject->message())->toBe(trans('ui::validation.tag.max_length'));
});

it('does not accept a word that starts with a number', function () {
    expect($this->subject->passes('tag', '2hello'))->toBeFalse();

    expect($this->subject->message())->toBe(trans('ui::validation.tag.special_character_start'));
});

it('does not accept a word that ends with a number', function () {
    expect($this->subject->passes('tag', 'hello2'))->toBeFalse();

    expect($this->subject->message())->toBe(trans('ui::validation.tag.special_character_end'));
});

it('does not accept a word with a special character other than -', function () {
    expect($this->subject->passes('tag', 'hello#world'))->toBeFalse();
    expect($this->subject->passes('tag', 'hello_world'))->toBeFalse();
    expect($this->subject->passes('tag', 'hello.world'))->toBeFalse();

    expect($this->subject->message())->toBe(trans('ui::validation.tag.forbidden_special_characters'));
});

it('has an error message', function () {
    $rule = new Tag();
    expect($rule->message())->toBe(trans('ui::validation.tag.min_length'));
});
