<?php

declare(strict_types=1);

namespace ARKEcosystem\Hermes\Components;

use ARKEcosystem\Fortify\Components\Concerns\InteractsWithUser;
use ARKEcosystem\Hermes\Enums\NotificationFilterEnum;
use Illuminate\Contracts\View\View;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\View as Facade;
use Livewire\Component;
use Livewire\WithPagination;

final class ManageNotifications extends Component
{
    use InteractsWithUser;
    use WithPagination;

    public array $selectedNotifications = [];

    public int $paginationLength = 10;

    public string $activeFilter;

    protected $listeners = [
        'setNotification'  => 'selectNotification',
        'markAsStarred',
        'markAsUnstarred',
        'applyFilter',
        'markAsRead',
    ];

    public function mount(): void
    {
        $this->activeFilter = NotificationFilterEnum::ALL;
    }

    public function render(): View
    {
        return Facade::make('hermes::components.manage-notifications', [
            'notificationCount' => $this->user->notifications()->count(),
        ]);
    }

    public function updatingActiveFilter(): void
    {
        $this->selectedNotifications = [];

        $this->resetPage();
    }

    public function getHasAllSelectedProperty(): bool
    {
        return count($this->selectedNotifications) === $this->notifications->count() && $this->notifications->count() > 0;
    }

    public function getNotificationsProperty(): LengthAwarePaginator
    {
        return $this->applyFilter($this->activeFilter);
    }

    public function selectNotification(string $notificationId): void
    {
        if (! in_array($notificationId, array_values($this->selectedNotifications), true)) {
            $this->selectedNotifications[] = $notificationId;
        } else {
            $this->selectedNotifications = array_diff($this->selectedNotifications, [$notificationId]);
        }
    }

    public function selectAllNotifications(): void
    {
        $this->selectedNotifications = Arr::flatten($this->notifications->pluck('id'));

        $this->hasAllSelected = true;
    }

    public function deselectAllNotifications(): void
    {
        $this->selectedNotifications = [];

        $this->hasAllSelected = false;
    }

    public function isNotificationSelected(string $notificationId): bool
    {
        return in_array($notificationId, $this->selectedNotifications, true);
    }

    public function markAsRead(string $notificationId): void
    {
        $this->user->notifications()->findOrFail($notificationId)->markAsRead();
    }

    public function markSelectedAsRead(): void
    {
        foreach ($this->selectedNotifications as $notification) {
            $this->markAsRead($notification);
        }

        $this->batchActionPerformed();
    }

    public function markAllAsRead(): void
    {
        $this->user->notifications->each->markAsRead();
    }

    public function markAsUnread(string $notificationId): void
    {
        $this->user->notifications()->findOrFail($notificationId)->markAsUnread();
    }

    public function batchActionPerformed(): void
    {
        $this->selectedNotifications = [];
    }

    public function markSelectedAsUnread(): void
    {
        foreach ($this->selectedNotifications as $notification) {
            $this->markAsUnread($notification);
        }

        $this->batchActionPerformed();
    }

    public function markAsStarred(string $notificationId): void
    {
        $this->user->notifications()->findOrFail($notificationId)->update(['is_starred' => true]);
    }

    public function markSelectedAsStarred(): void
    {
        foreach ($this->selectedNotifications as $notification) {
            $this->markAsStarred($notification);
        }

        $this->batchActionPerformed();
    }

    public function markAsUnstarred(string $notificationId): void
    {
        $this->user->notifications()->findOrFail($notificationId)->update(['is_starred' => false]);
    }

    public function markSelectedAsUnstarred(): void
    {
        foreach ($this->selectedNotifications as $notification) {
            $this->markAsUnstarred($notification);
        }

        $this->batchActionPerformed();
    }

    public function deleteNotification(string $notificationId): void
    {
        $this->user->notifications()->find($notificationId)?->delete();
    }

    public function deleteSelected(): void
    {
        foreach ($this->selectedNotifications as $notification) {
            $this->deleteNotification($notification);
        }

        $this->batchActionPerformed();
    }

    public function getStateColor(DatabaseNotification $notification): string
    {
        if ($this->isNotificationSelected($notification->id)) {
            return 'bg-theme-success-50';
        } elseif (! $this->isNotificationSelected($notification->id) && $notification->unread()) {
            return 'bg-theme-secondary-100';
        }

        return 'bg-white';
    }

    public function applyFilter(string $filter): LengthAwarePaginator
    {
        if ($filter === NotificationFilterEnum::READ) {
            return $this->filterRead();
        }

        if ($filter === NotificationFilterEnum::UNREAD) {
            return $this->filterUnread();
        }

        if ($filter === NotificationFilterEnum::STARRED) {
            return $this->filterStarred();
        }

        if ($filter === NotificationFilterEnum::UNSTARRED) {
            return $this->filterUnstarred();
        }

        return $this->filterAll();
    }

    public function getAvailableFilters(): array
    {
        return [
            NotificationFilterEnum::ALL,
            NotificationFilterEnum::READ,
            NotificationFilterEnum::UNREAD,
            NotificationFilterEnum::STARRED,
            NotificationFilterEnum::UNSTARRED,
        ];
    }

    private function filterAll(): LengthAwarePaginator
    {
        $this->activeFilter = NotificationFilterEnum::ALL;

        return $this->user->notifications()->paginate($this->paginationLength);
    }

    private function filterRead(): LengthAwarePaginator
    {
        $this->activeFilter = NotificationFilterEnum::READ;

        return $this->user->notifications()->where('read_at', '!=', null)->paginate($this->paginationLength);
    }

    private function filterUnread(): LengthAwarePaginator
    {
        $this->activeFilter = NotificationFilterEnum::UNREAD;

        return $this->user->notifications()->where('read_at', null)->paginate($this->paginationLength);
    }

    private function filterStarred(): LengthAwarePaginator
    {
        $this->activeFilter = NotificationFilterEnum::STARRED;

        return $this->user->notifications()->where('is_starred', true)->paginate($this->paginationLength);
    }

    private function filterUnstarred(): LengthAwarePaginator
    {
        $this->activeFilter = NotificationFilterEnum::UNSTARRED;

        return $this->user->notifications()->where('is_starred', false)->paginate($this->paginationLength);
    }
}
