<?php

declare(strict_types=1);

namespace Tests\Models\Concerns;

use ARKEcosystem\Fortify\Models;
use Illuminate\Support\Facades\Config;

it('returns the users model from config', function () {
    Config::set('fortify.models.user', 'users');
    expect(Models::user())->toBe('users');
});

it('returns the invitations model from config', function () {
    Config::set('fortify.models.invitation', 'invites');
    expect(Models::invitation())->toBe('invites');
});
