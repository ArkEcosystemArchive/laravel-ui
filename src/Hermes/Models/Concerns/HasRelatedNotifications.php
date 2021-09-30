<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\Hermes\Models\Concerns;

trait HasRelatedNotifications
{
    public function relatedNotifications()
    {
        return $this->morphMany(config('hermes.models.notification'), 'relatable');
    }

    public function relatedNotificationsByLogo()
    {
        return $this->morphMany(config('hermes.models.notification'), 'relatable_logo');
    }

    /**
     * Register any events for your application.
     *
     * @return void
     */
    protected static function bootHasRelatedNotifications()
    {
        static::deleting(function (self $model) {
            $model->relatedNotifications()->delete();
            $model->relatedNotificationsByLogo()->delete();
        });
    }
}
