<?php

declare(strict_types=1);

namespace ARKEcosystem\Hermes\Components;

use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View as Facade;
use Livewire\Component;

final class NotificationsIndicator extends Component
{
    public $notificationsUnread;

    protected $listeners = ['markNotificationsAsSeen'];

    public function mount(): void
    {
        $this->notificationsUnread = Auth::user() ? Auth::user()->hasUnreadNotifications() : false;
    }

    public function markNotificationsAsSeen(): void
    {
        Auth::user()->update(['seen_notifications_at' => Carbon::now()]);

        $this->notificationsUnread = false;

        $this->emit('notificationsCountUpdated');
    }

    public function render(): View
    {
        return Facade::make('hermes::components.notifications-indicator');
    }
}
