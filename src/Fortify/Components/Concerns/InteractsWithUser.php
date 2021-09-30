<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\Fortify\Components\Concerns;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;

trait InteractsWithUser
{
    public function getUserProperty(): ?Authenticatable
    {
        return Auth::user();
    }
}
