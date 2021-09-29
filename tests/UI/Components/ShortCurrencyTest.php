<?php

declare(strict_types=1);

use ARKEcosystem\UserInterface\Components\ShortCurrency;
use Illuminate\Support\Facades\View;
use function Spatie\Snapshots\assertMatchesSnapshot;

it('should format the given value', function (): void {
    assertMatchesSnapshot((new ShortCurrency('USD'))->render()(['slot' => 10]));
    assertMatchesSnapshot((new ShortCurrency('USD'))->render()(['slot' => 100]));
    assertMatchesSnapshot((new ShortCurrency('USD'))->render()(['slot' => 1000]));
    assertMatchesSnapshot((new ShortCurrency('USD'))->render()(['slot' => 10000]));
    assertMatchesSnapshot((new ShortCurrency('USD'))->render()(['slot' => 100000]));
    assertMatchesSnapshot((new ShortCurrency('USD'))->render()(['slot' => 1000000]));
    assertMatchesSnapshot((new ShortCurrency('USD'))->render()(['slot' => 10000000]));
    assertMatchesSnapshot((new ShortCurrency('USD'))->render()(['slot' => 100000000]));
    assertMatchesSnapshot((new ShortCurrency('USD'))->render()(['slot' => 1000000000]));
    assertMatchesSnapshot((new ShortCurrency('USD'))->render()(['slot' => 10000000000]));
    assertMatchesSnapshot((new ShortCurrency('USD'))->render()(['slot' => 100000000000]));
    assertMatchesSnapshot((new ShortCurrency('USD'))->render()(['slot' => 1000000000000]));
});

it('should render when included in a blade view', function (): void {
    View::addLocation(realpath(__DIR__.'/../../blade-views'));

    $this->assertView('short-currency', ['slot' => 10])->contains('10 USD');
    $this->assertView('short-currency', ['slot' => 100])->contains('100 USD');
    $this->assertView('short-currency', ['slot' => 1000])->contains('1K USD');
    $this->assertView('short-currency', ['slot' => 10000])->contains('10K USD');
    $this->assertView('short-currency', ['slot' => 100000])->contains('100K USD');
    $this->assertView('short-currency', ['slot' => 1000000])->contains('1M USD');
    $this->assertView('short-currency', ['slot' => 10000000])->contains('10M USD');
    $this->assertView('short-currency', ['slot' => 100000000])->contains('100M USD');
    $this->assertView('short-currency', ['slot' => 1000000000])->contains('1B USD');
    $this->assertView('short-currency', ['slot' => 10000000000])->contains('10B USD');
    $this->assertView('short-currency', ['slot' => 100000000000])->contains('100B USD');
    $this->assertView('short-currency', ['slot' => 1000000000000])->contains('1T USD');
});
