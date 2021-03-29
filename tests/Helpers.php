<?php

namespace Tests;

use Illuminate\Support\ViewErrorBag;
use Illuminate\View\ComponentAttributeBag;

function createAttributes(array $attributes): array
{
    $defaults = [
        'name'   => 'username',
        'errors' => new ViewErrorBag(),
    ];

    return array_merge([
        'attributes' => new ComponentAttributeBag(array_merge($defaults, $attributes)),
    ], $defaults, $attributes);
}

function createViewAttributes(array $attributes): array
{
    return array_merge([
        'attributes' => new ComponentAttributeBag($attributes),
    ], $attributes);
}
