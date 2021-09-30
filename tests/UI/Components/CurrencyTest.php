<?php

declare(strict_types=1);

use ARKEcosystem\Foundation\UserInterface\Components\Currency;
use Illuminate\Support\Facades\View;
use function Spatie\Snapshots\assertMatchesSnapshot;

it('should format the given value', function (): void {
    assertMatchesSnapshot((new Currency('USD'))->render()(['slot' => 10]));
    assertMatchesSnapshot((new Currency('USD'))->render()(['slot' => 100]));
    assertMatchesSnapshot((new Currency('USD'))->render()(['slot' => 1000]));
    assertMatchesSnapshot((new Currency('USD'))->render()(['slot' => 10000]));
    assertMatchesSnapshot((new Currency('USD'))->render()(['slot' => 100000]));
    assertMatchesSnapshot((new Currency('USD'))->render()(['slot' => 1000000]));

    assertMatchesSnapshot((new Currency('USD'))->render()(['slot' => 10, 'attributes' => ['decimals' => 0]]));
    assertMatchesSnapshot((new Currency('USD'))->render()(['slot' => 100, 'attributes' => ['decimals' => 0]]));
    assertMatchesSnapshot((new Currency('USD'))->render()(['slot' => 1000, 'attributes' => ['decimals' => 0]]));
    assertMatchesSnapshot((new Currency('USD'))->render()(['slot' => 10000, 'attributes' => ['decimals' => 0]]));
    assertMatchesSnapshot((new Currency('USD'))->render()(['slot' => 100000, 'attributes' => ['decimals' => 0]]));
    assertMatchesSnapshot((new Currency('USD'))->render()(['slot' => 1000000, 'attributes' => ['decimals' => 0]]));
});

it('should render when included in a blade view', function (): void {
    View::addLocation(realpath(__DIR__.'/../../blade-views'));

    $this->assertView('currency', ['slot' => 10])->contains('10 USD');
    $this->assertView('currency', ['slot' => 100])->contains('100 USD');
    $this->assertView('currency', ['slot' => 1000])->contains('1,000 USD');
    $this->assertView('currency', ['slot' => 10000])->contains('10,000 USD');
    $this->assertView('currency', ['slot' => 100000])->contains('100,000 USD');
    $this->assertView('currency', ['slot' => 1000000])->contains('1,000,000 USD');
});

it('should render with decimals when included in a blade view', function (): void {
    View::addLocation(realpath(__DIR__.'/../../blade-views'));

    $this->assertView('currency-with-decimals', ['slot' => 0.012])->contains('0.01 USD');
});
