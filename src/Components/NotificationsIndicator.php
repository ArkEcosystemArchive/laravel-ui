<?php

namespace ARKEcosystem\UserInterface\Components;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class NotificationsIndicator extends Component
{
    public $notificationsUnread;

    protected $listeners = ['markNotificationsAsSeen'];

    public function mount()
    {
        $this->notificationsUnread = Auth::user() ? Auth::user()->hasNewNotifications() : false;
    }

    public function markNotificationsAsSeen()
    {
        Auth::user()->update(['seen_notifications_at' => Carbon::now()]);

        $this->notificationsUnread = false;
    }

    public function render()
    {
        return view('livewire.notifications-indicator');
    }
}
