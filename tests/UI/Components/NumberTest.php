<?php

declare(strict_types=1);

use ARKEcosystem\Foundation\UserInterface\Components\Number;
use Illuminate\Support\Facades\View;
use function Spatie\Snapshots\assertMatchesSnapshot;

it('should format the given value', function (): void {
    assertMatchesSnapshot((new Number())->render()(['slot' => 10]));
    assertMatchesSnapshot((new Number())->render()(['slot' => 100]));
    assertMatchesSnapshot((new Number())->render()(['slot' => 1000]));
    assertMatchesSnapshot((new Number())->render()(['slot' => 10000]));
    assertMatchesSnapshot((new Number())->render()(['slot' => 100000]));
    assertMatchesSnapshot((new Number())->render()(['slot' => 1000000]));
});

it('should render when included in a blade view', function (): void {
    View::addLocation(realpath(__DIR__.'/../../blade-views'));

    $this->assertView('number', ['slot' => 10])->contains('10');
    $this->assertView('number', ['slot' => 100])->contains('100');
    $this->assertView('number', ['slot' => 1000])->contains('1,000');
    $this->assertView('number', ['slot' => 10000])->contains('10,000');
    $this->assertView('number', ['slot' => 100000])->contains('100,000');
    $this->assertView('number', ['slot' => 1000000])->contains('1,000,000');
});
