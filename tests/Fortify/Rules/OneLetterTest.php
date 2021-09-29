<?php

declare(strict_types=1);

use ARKEcosystem\Fortify\Rules\OneLetter;

it('doesnt accept a name that doesnt include at least one letter', function ($name) {
    $rule = new OneLetter();
    $this->assertFalse($rule->passes('name', $name));
})->with([
    '134567',
    '....',
    '----',
    '#@$∞',
]);

it('accepts a name that include at least one letter', function ($name) {
    $rule = new OneLetter();
    $this->assertTrue($rule->passes('name', $name));
})->with([
    '134a567',
    'b....',
    '--c--',
    '#@$e∞',
]);

it('has a message', function () {
    $rule = new OneLetter();
    $this->assertEquals(trans('fortify::validation.messages.include_letters'), $rule->message());
});
