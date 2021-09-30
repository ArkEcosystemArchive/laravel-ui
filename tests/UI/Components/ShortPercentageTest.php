<?php

declare(strict_types=1);

use ARKEcosystem\Foundation\UserInterface\Components\ShortPercentage;
use Illuminate\Support\Facades\View;
use function Spatie\Snapshots\assertMatchesSnapshot;

it('should format the given value', function (): void {
    assertMatchesSnapshot((new ShortPercentage())->render()(['slot' => 10.12]));
    assertMatchesSnapshot((new ShortPercentage())->render()(['slot' => 100.12]));
    assertMatchesSnapshot((new ShortPercentage())->render()(['slot' => 1000.12]));
    assertMatchesSnapshot((new ShortPercentage())->render()(['slot' => 10000.12]));
    assertMatchesSnapshot((new ShortPercentage())->render()(['slot' => 100000.12]));
    assertMatchesSnapshot((new ShortPercentage())->render()(['slot' => 1000000.12]));
});

it('should render when included in a blade view', function (): void {
    View::addLocation(realpath(__DIR__.'/../../blade-views'));

    $this->assertView('short-percentage', ['slot' => 10.12])->contains('10%');
    $this->assertView('short-percentage', ['slot' => 100.12])->contains('100%');
    $this->assertView('short-percentage', ['slot' => 1000.12])->contains('1000%');
    $this->assertView('short-percentage', ['slot' => 10000.12])->contains('10000%');
    $this->assertView('short-percentage', ['slot' => 100000.12])->contains('100000%');
    $this->assertView('short-percentage', ['slot' => 1000000.12])->contains('1000000%');
});
