<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\Fortify\Components;

use ARKEcosystem\Foundation\Fortify\Components\Concerns\InteractsWithUser;
use Carbon\Carbon;
use Carbon\CarbonTimeZone;
use DateTimeZone;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class UpdateTimezoneForm extends Component
{
    use InteractsWithUser;

    public $timezone;

    /**
     * Mount the component.
     */
    public function mount()
    {
        $this->timezone = $this->currentTimezone;
    }

    /**
     * Render the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('ark-fortify::profile.update-timezone-form');
    }

    public function getFormattedTimezones(): array
    {
        $formattedTimezones  = [];
        $timezoneIdentifiers = DateTimeZone::listIdentifiers(DateTimeZone::ALL);

        foreach ($timezoneIdentifiers as $timezoneIdentifier) {
            $timezone = CarbonTimeZone::instance(new DateTimeZone($timezoneIdentifier));

            array_push($formattedTimezones, [
                'offset'            => $timezone->getOffset(Carbon::now()),
                'timezone'          => $timezoneIdentifier,
                'formattedTimezone' => "(UTC{$timezone->toOffsetName()}) ".str_replace('_', ' ', $timezoneIdentifier),
            ]);
        }

        array_multisort(array_column($formattedTimezones, 'offset'), SORT_ASC, $formattedTimezones);

        return $formattedTimezones;
    }

    public function getTimezonesProperty(): array
    {
        return Cache::rememberForever('timezones', fn () => $this->getFormattedTimezones());
    }

    public function getCurrentTimezoneProperty(): string
    {
        $index = array_search($this->user->timezone, array_column($this->timezones, 'timezone'), true);

        return $this->timezones[$index]['timezone'];
    }

    public function updateTimezone(): void
    {
        $this->user->timezone = $this->timezone;

        $this->user->save();

        $this->emit('toastMessage', [trans('ui::pages.user-settings.timezone_updated'), 'success']);
    }
}
