<?php

declare(strict_types=1);

namespace Tests\Fortify\stubs;

use ARKEcosystem\Foundation\Fortify\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Spatie\MediaLibrary\MediaCollections\Models\Concerns\HasUuid;

/**
 * @coversNothing
 */
final class TestUser extends Model
{
    use HasUuid;

    public ?string $uuid = null;

    public ?int $user_id = null;

    protected $guarded = [];

    public static $model = null;

    public static function findByUuid(string $uuid): ?Model
    {
        if (self::$model) {
            return self::$model;
        }

        self::$model = new self(compact('uuid'));

        return self::$model;
    }

    public function update(array $attributes = [], array $options = [])
    {
        $this->user_id = Arr::get($attributes, 'user_id', $this->user_id);
        $this->uuid    = Arr::get($attributes, 'uuid', $this->uuid);
    }

    public function user()
    {
        if (! $this->user_id) {
            return;
        }

        return Models::user()::find($this->user_id);
    }
}
