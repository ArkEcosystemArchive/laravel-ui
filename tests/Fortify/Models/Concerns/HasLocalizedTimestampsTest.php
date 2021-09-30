<?php

declare(strict_types=1);

namespace Tests\Models\Concerns;

use ARKEcosystem\Foundation\Fortify\Models\Concerns\HasLocalizedTimestamps;
use ARKEcosystem\Foundation\Fortify\Models\Concerns\HasPhoto;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
use Spatie\MediaLibrary\HasMedia;
use Tests\Fortify\MediaUser;

/**
 * @coversNothing
 */
class HasLocalizedTimestampsTest implements HasMedia
{
    use HasPhoto;
}

it('can access created at with timezone with guest user', function () {
    Config::set('app.timezone', 'Africa/Brazzaville');
    $subject = $this->getMockForTrait(HasLocalizedTimestamps::class, [], '', true, true, true, ['getFirstMediaUrl']);
    $subject->created_at = Carbon::parse('2021-01-26T19:00:00-0000');

    $value = $subject->getCreatedAtLocalAttribute();

    expect($value)->toBeInstanceOf(Carbon::class);
    expect($value->format(Carbon::ISO8601))->toBe('2021-01-26T20:00:00+0100');
    expect($value->timezone->getName())->toBe('Africa/Brazzaville');
});

it('can access created at with timezone with authenticated user', function () {
    $user = MediaUser::fake();
    $user->timezone = 'America/Argentina/Buenos_Aires';
    $this->actingAs($user);

    $subject = $this->getMockForTrait(HasLocalizedTimestamps::class, [], '', true, true, true, ['getFirstMediaUrl']);
    $subject->created_at = Carbon::parse('2021-01-26T19:00:00-0000');

    $value = $subject->getCreatedAtLocalAttribute();

    expect($value)->toBeInstanceOf(Carbon::class);
    expect($value->format(Carbon::ISO8601))->toBe('2021-01-26T16:00:00-0300');
    expect($value->timezone->getName())->toBe('America/Argentina/Buenos_Aires');
});

it('can access updated at with timezone with guest user', function () {
    Config::set('app.timezone', 'Africa/Brazzaville');
    $subject = $this->getMockForTrait(HasLocalizedTimestamps::class, [], '', true, true, true, ['getFirstMediaUrl']);
    $subject->updated_at = Carbon::parse('2021-01-26T19:00:00-0000');

    $value = $subject->getUpdatedAtLocalAttribute();

    expect($value)->toBeInstanceOf(Carbon::class);
    expect($value->format(Carbon::ISO8601))->toBe('2021-01-26T20:00:00+0100');
    expect($value->timezone->getName())->toBe('Africa/Brazzaville');
});

it('can access updated at with timezone with authenticated user', function () {
    $user = MediaUser::fake();
    $user->timezone = 'America/Argentina/Buenos_Aires';
    $this->actingAs($user);

    $subject = $this->getMockForTrait(HasLocalizedTimestamps::class, [], '', true, true, true, ['getFirstMediaUrl']);
    $subject->updated_at = Carbon::parse('2021-01-26T19:00:00-0000');

    $value = $subject->getUpdatedAtLocalAttribute();

    expect($value)->toBeInstanceOf(Carbon::class);
    expect($value->format(Carbon::ISO8601))->toBe('2021-01-26T16:00:00-0300');
    expect($value->timezone->getName())->toBe('America/Argentina/Buenos_Aires');
});
