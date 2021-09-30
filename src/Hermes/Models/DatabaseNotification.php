<?php

declare(strict_types=1);

namespace ARKEcosystem\Hermes\Models;

use ARKEcosystem\Foundation\Fortify\Models\Concerns\HasLocalizedTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Notifications\DatabaseNotification as BaseNotification;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

/**
 * @property string $relatable_type
 * @property int $relatable_id
 * @property string $relatable_logo_type
 * @property int $relatable_logo_id
 * @property array $data
 */
abstract class DatabaseNotification extends BaseNotification
{
    use HasFactory;
    use HasLocalizedTimestamps;

    /**
     * Register any events for your application.
     *
     * @return void
     */
    protected static function booted()
    {
        // When creating a new DatabaseNotification, we are only allowed to fill
        // the `data` attribute so there is no easy way to assign the relatable
        // model. As a workaorund to avoid the need to add more steps that may
        // complicate the notification creation the lines here take the relatable
        // info from the data and move it to the proper columns before storing the
        // model in the database.
        static::creating(function (self $notification) {
            $data = Arr::get($notification, 'data');
            $notification->relatable_id = Arr::get($data, 'relatable_id');
            $notification->relatable_type = Arr::get($data, 'relatable_type');
            $notification->relatable_logo_id = Arr::get($data, 'relatable_logo_id');
            $notification->relatable_logo_type = Arr::get($data, 'relatable_logo_type');
            unset($data['relatable_type'], $data['relatable_id'], $data['relatable_logo_type'], $data['relatable_logo_id']);

            $notification->data = $data;
        });
    }

    public function relatable(): MorphTo
    {
        return $this->morphTo('relatable', 'relatable_type', 'relatable_id');
    }

    public function relatableLogo(): MorphTo
    {
        if ($this->relatable_logo_type && $this->relatable_logo_id) {
            return $this->morphTo('relatable', 'relatable_logo_type', 'relatable_logo_id');
        }

        return $this->relatable();
    }

    abstract public function name(): string;

    abstract public function logo(): string;

    public function title(): ?string
    {
        /* @phpstan-ignore-next-line  */
        return data_get($this->relatable, 'title')
            ?? data_get($this->data, 'name');
    }

    public function content(): ?string
    {
        /* @phpstan-ignore-next-line  */
        return data_get($this->relatable, 'body')
            ?? data_get($this->data, 'content');
    }

    public function link(): ?string
    {
        /* @phpstan-ignore-next-line  */
        return data_get($this->relatable, 'link')
            ?? data_get($this->data, 'action.url');
    }

    public function linkTitle(): ?string
    {
        return data_get($this->data, 'action.title', trans('hermes::actions.view'));
    }

    public function hasAction(): bool
    {
        return (bool) data_get($this->data, 'action');
    }

    public function excerpt(?int $length = null): string
    {
        /* @phpstan-ignore-next-line  */
        return Str::limit(strip_tags($this->content()), $length ?? 200);
    }
}
