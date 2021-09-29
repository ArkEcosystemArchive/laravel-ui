<?php

declare(strict_types=1);

use ARKEcosystem\UserInterface\Components\Percentage;
use Illuminate\Support\Facades\View;
use function Spatie\Snapshots\assertMatchesSnapshot;

it('should format the given value', function (): void {
    assertMatchesSnapshot((new Percentage())->render()(['slot' => 10]));
    assertMatchesSnapshot((new Percentage())->render()(['slot' => 100]));
    assertMatchesSnapshot((new Percentage())->render()(['slot' => 1000]));
    assertMatchesSnapshot((new Percentage())->render()(['slot' => 10000]));
    assertMatchesSnapshot((new Percentage())->render()(['slot' => 100000]));
    assertMatchesSnapshot((new Percentage())->render()(['slot' => 1000000]));
});

it('should render when included in a blade view', function (): void {
    View::addLocation(realpath(__DIR__.'/../../blade-views'));

    $this->assertView('percentage', ['slot' => 10])->contains('10.00%');
    $this->assertView('percentage', ['slot' => 100])->contains('100.00%');
    $this->assertView('percentage', ['slot' => 1000])->contains('1000.00%');
    $this->assertView('percentage', ['slot' => 10000])->contains('10000.00%');
    $this->assertView('percentage', ['slot' => 100000])->contains('100000.00%');
    $this->assertView('percentage', ['slot' => 1000000])->contains('1000000.00%');
});
