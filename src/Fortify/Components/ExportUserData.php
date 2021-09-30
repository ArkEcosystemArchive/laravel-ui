<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\Fortify\Components;

use ARKEcosystem\Foundation\Fortify\Components\Concerns\InteractsWithUser;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Component;
use Spatie\PersonalDataExport\Jobs\CreatePersonalDataExportJob;

class ExportUserData extends Component
{
    use InteractsWithUser;
    use WithRateLimiting;

    /**
     * Queue the export of the personal data for the authenticated user.
     *
     * @return void
     */
    public function export(): void
    {
        try {
            $this->rateLimit(1, 15 * 60);
        } catch (TooManyRequestsException $exception) {
            return;
        }

        dispatch(new CreatePersonalDataExportJob($this->user));

        $this->emit('toastMessage', [trans('ui::pages.user-settings.data_exported'), 'success']);
    }

    public function rateLimitReached(): bool
    {
        return RateLimiter::tooManyAttempts($this->getRateLimitKey('export'), 1);
    }

    /**
     * Render the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('ark-fortify::profile.export-user-data');
    }
}
