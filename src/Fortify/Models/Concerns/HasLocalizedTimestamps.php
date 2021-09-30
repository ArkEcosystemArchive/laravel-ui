<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\Fortify\Models\Concerns;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

trait HasLocalizedTimestamps
{
    public function getCreatedAtLocalAttribute(): Carbon
    {
        $timezone = Auth::check() ? Auth::user()->timezone : Config::get('app.timezone');

        return Carbon::parse($this->created_at)->timezone($timezone);
    }

    public function getUpdatedAtLocalAttribute(): Carbon
    {
        $timezone = Auth::check() ? Auth::user()->timezone : Config::get('app.timezone');

        return Carbon::parse($this->updated_at)->timezone($timezone);
    }
}
