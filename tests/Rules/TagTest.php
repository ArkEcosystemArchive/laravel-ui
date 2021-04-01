<?php

declare(strict_types=1);

use ARKEcosystem\UserInterface\Rules\Tag;

it('accepts a simple word', function () {
    $rule = new Tag();
    $tag = 'hello';
    $this->assertTrue($rule->passes('tag', $tag));
});

it('accepts a simple word with uppercase letters', function () {
    $rule = new Tag();
    $tag = 'Hello';
    $this->assertTrue($rule->passes('tag', $tag));
});

it('accepts a word with numbers', function () {
    $rule = new Tag();
    $tag = 'hello123';
    $this->assertTrue($rule->passes('tag', $tag));
});

it('does not accept a word that starts with a number', function () {
    $rule = new Tag();
    $tag = '2hello';
    $this->assertFalse($rule->passes('tag', $tag));
});

it('does not accept a word with a space', function () {
    $rule = new Tag();
    $tag = 'hello world';
    $this->assertFalse($rule->passes('tag', $tag));
});

it('does not accept a word with a special char', function () {
    $rule = new Tag();
    $tag = '#hello';
    $this->assertFalse($rule->passes('tag', $tag));
});

it('accepts a 3 character word', function () {
    $rule = new Tag();
    $tag = 'hel';
    $this->assertTrue($rule->passes('tag', $tag));
});

it('does not accept a 2 character word', function () {
    $rule = new Tag();
    $tag = 'he';
    $this->assertFalse($rule->passes('tag', $tag));
});

it('accepts a 30 character word', function () {
    $rule = new Tag();
    $tag = str_repeat('a', 30);
    $this->assertTrue($rule->passes('tag', $tag));
});

it('does not accept a 31 character word', function () {
    $rule = new Tag();
    $tag = str_repeat('a', 31);
    $this->assertFalse($rule->passes('tag', $tag));
});

it('has an error message', function () {
    $rule = new Tag();
    expect($rule->message())->toBe(trans('ui::validation.custom.invalid_tag'));
});


