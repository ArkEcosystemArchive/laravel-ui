<?php

declare(strict_types=1);

use ARKEcosystem\Foundation\Fortify\Rules\StartsWithLetterOrNumber;

it('accepts a name that starts with letter or number', function ($name) {
    $rule = new StartsWithLetterOrNumber();
    $this->assertTrue($rule->passes('name', $name));
})->with([
    'a.alfonso',
    'b-hello',
    '3&hello',
    '1\'Something',
]);

it('doesnt accept a name that doesnt start with letter or number', function ($name) {
    $rule = new StartsWithLetterOrNumber();
    $this->assertFalse($rule->passes('name', $name));
})->with([
    '.alfonso',
    '-hello',
    '&hello',
    '\'Something',
]);

it('has a message', function () {
    $rule = new StartsWithLetterOrNumber();
    $this->assertEquals(trans('ui::validation.messages.start_with_letter_or_number'), $rule->message());
});
