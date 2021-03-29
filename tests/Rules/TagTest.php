<?php

declare(strict_types=1);

use ARKEcosystem\UserInterface\Rules\Tag;

it('accepts a simple word', function () {
    $rule = new Tag();
    $tag = 'hello';
    $this->assertTrue($rule->passes('tag', $tag));
});

it('accepts a word with numbers', function () {
    $rule = new Tag();
    $tag = 'hello123';
    $this->assertTrue($rule->passes('tag', $tag));
});

it('doesnt accepts a word that starts with a number', function () {
    $rule = new Tag();
    $tag = '2hello';
    $this->assertFalse($rule->passes('tag', $tag));
});

it('doesnt accepts a word with an space', function () {
    $rule = new Tag();
    $tag = 'hello world';
    $this->assertFalse($rule->passes('tag', $tag));
});

it('doesnt accepts a word with an special char', function () {
    $rule = new Tag();
    $tag = '#hello';
    $this->assertFalse($rule->passes('tag', $tag));
});

it('accepts a 3 chars word', function () {
    $rule = new Tag();
    $tag = 'hel';
    $this->assertTrue($rule->passes('tag', $tag));
});

it('doesnt accepts a 2 chars word', function () {
    $rule = new Tag();
    $tag = 'he';
    $this->assertFalse($rule->passes('tag', $tag));
});

it('accepts a 30 chars word', function () {
    $rule = new Tag();
    $tag = str_repeat('a', 30);
    $this->assertTrue($rule->passes('tag', $tag));
});

it('doesnt accepts a 31 chars word', function () {
    $rule = new Tag();
    $tag = str_repeat('a', 31);
    $this->assertFalse($rule->passes('tag', $tag));
});

it('has an error message', function () {
    $rule = new Tag();
    expect($rule->message())->toBe(trans('ui::validation.custom.invalid_tag'));
});


