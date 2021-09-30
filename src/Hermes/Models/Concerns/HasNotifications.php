<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\Hermes\Models\Concerns;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Query\Builder;
use Illuminate\Notifications\RoutesNotifications;
use Illuminate\Support\Collection;

/**
 * @property Collection $notifications
 */
trait HasNotifications
{
    use RoutesNotifications;

    public function notifications(): MorphMany
    {
        return $this
            ->morphMany(config('hermes.models.notification'), 'notifiable')
            ->with('relatable')
            ->orderBy('created_at', 'desc')
            ->orderBy('id');
    }

    public function readNotifications(): Builder
    {
        return $this->notifications()->whereNotNull('read_at');
    }

    public function unreadNotifications(): Builder
    {
        return $this->notifications()->whereNull('read_at');
    }

    public function starredNotifications(): Builder
    {
        return $this->notifications()->where('is_starred', true);
    }

    public function hasUnreadNotifications(): bool
    {
        $latestNotification = $this->notifications->first();

        if (! $latestNotification) {
            return false;
        }

        return $latestNotification->created_at->gte($this->seen_notifications_at);
    }
}
