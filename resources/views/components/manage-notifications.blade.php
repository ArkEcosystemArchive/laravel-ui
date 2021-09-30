<div>
    <h1 class="px-6 text-2xl font-bold md:text-4xl">@lang('hermes::pages.notifications.page_title')</h1>

    <div class="flex flex-col">
        <div class="flex flex-row justify-between w-full mt-4 mb-2 text-base font-semibold sm:px-6">
            <div class="relative flex flex-row space-x-2 sm:static">
                <div class="relative">
                    <button type="button" class="flex items-center justify-center w-10 h-10 border border-solid rounded cursor-pointer text-theme-secondary-400 border-theme-secondary-200 hover:text-theme-primary-500 focus:outline-none" wire:click="{{ $this->hasAllSelected ? 'deselectAllNotifications' : 'selectAllNotifications' }}">
                        @if($this->hasAllSelected)
                            <div class="flex items-center justify-center w-5 h-5 text-white rounded bg-theme-success-500">
                                <x-ark-icon name="checkmark" size="2xs" />
                            </div>
                        @else
                            <span class="block w-5 h-5 text-white border-2 rounded border-theme-secondary-300"></span>
                        @endif
                    </button>
                </div>

                <div class="relative">
                    <x-ark-dropdown wrapper-class="inline-block" dropdown-classes="mt-3" button-class="flex items-center justify-center h-10 p-4 dropdown-button-outline">
                        @slot('button')
                            <div class="inline-flex items-center justify-center w-full space-x-2">
                                <span class="w-full font-semibold text-left text-theme-secondary-900">
                                    {{ ucfirst($this->activeFilter) }}
                                </span>

                                <span :class="{ 'rotate-180': dropdownOpen }" class="transition duration-150 ease-in-out text-theme-primary-600">
                                    <x-ark-icon name="chevron-down" size="xs" />
                                </span>
                            </div>
                        @endslot
                        <div class="py-3">
                            @foreach ($this->getAvailableFilters() as $filter)
                                <button type="button" class="cursor-pointer dropdown-entry focus-visible:ring-inset" wire:click="$set('activeFilter', '{{ $filter }}')">
                                    @lang("hermes::menus.notifications-dropdown.{$filter}")
                                </button>
                            @endforeach
                        </div>
                    </x-ark-dropdown>
                </div>

                <div class="w-10 sm:relative">
                    <x-ark-dropdown wrapper-class="top-0 right-0 inline-block text-left sm:absolute" dropdown-classes="left-0 w-64 mt-3" button-class="flex justify-center w-10 h-10 rounded bg-theme-primary-100 text-theme-primary-600">
                        <div class="py-3">
                            <button
                                type="button"
                                class="cursor-pointer dropdown-entry focus-visible:ring-inset"
                                wire:click="markSelectedAsRead"
                            >
                                @lang('hermes::menus.notifications-dropdown.mark_selected_as_read')
                            </button>

                            <button
                                type="button"
                                class="cursor-pointer dropdown-entry focus-visible:ring-inset"
                                wire:click="markSelectedAsUnread"
                            >
                                @lang('hermes::menus.notifications-dropdown.mark_selected_as_unread')
                            </button>

                            <button
                                type="button"
                                class="cursor-pointer dropdown-entry focus-visible:ring-inset"
                                wire:click="markSelectedAsStarred"
                            >
                                @lang('hermes::menus.notifications-dropdown.mark_selected_as_starred')
                            </button>

                            <button
                                type="button"
                                class="cursor-pointer dropdown-entry focus-visible:ring-inset"
                                wire:click="markSelectedAsUnstarred"
                            >
                                @lang('hermes::menus.notifications-dropdown.unstar_selected')
                            </button>

                            <button
                                type="button"
                                class="cursor-pointer dropdown-entry focus-visible:ring-inset"
                                wire:click="deleteSelected"
                            >
                                @lang('hermes::menus.notifications-dropdown.mark_selected_as_delete')
                            </button>
                        </div>
                    </x-ark-dropdown>
                </div>
            </div>
            @if($notificationCount > 0)
                <button
                    type="button"
                    class="items-center justify-end hidden cursor-pointer sm:flex link"
                    wire:click="markAllAsRead"
                >
                    @lang('hermes::actions.mark_all_as_read')
                </button>
            @endif
        </div>

        @if($notificationCount > 0)
            <button
                type="button"
                class="flex items-center mt-2 sm:hidden link"
                wire:click="markAllAsRead"
            >
                @lang('hermes::actions.mark_all_as_read')
            </button>
        @endif

        @if ($notificationCount > 0 && $this->notifications->count() > 0)
            @foreach($this->notifications as $notification)
                <div class="pt-2 -mx-4 sm:mx-0">
                    <div
                        role="button"
                        class="flex flex-col sm:flex-row rounded-xl space-y-4 sm:space-y-0 sm:space-x-4 {{ $this->getStateColor($notification) }} px-6 py-5 cursor-pointer"
                        wire:click="$emit('markAsRead', '{{ $notification->id }}')"
                    >
                        <div class="flex justify-between flex-shrink-0">
                            @if ($this->isNotificationSelected($notification->id))
                                <button
                                    type="button"
                                    wire:click.stop="$emit('setNotification', '{{ $notification->id }}')"
                                    class="box-border flex items-center justify-center w-5 h-5 text-white rounded cursor-pointer bg-theme-success-500"
                                >
                                    <x-ark-icon name="checkmark" size="2xs" />
                                </button>
                            @else
                                <button
                                    type="button"
                                    class="block w-5 h-5 text-white border-2 rounded border-theme-secondary-300"
                                    wire:click.stop="$emit('setNotification', '{{ $notification->id }}')"
                                ></button>
                            @endif

                            <div class="space-x-2 flex sm:hidden items-center">
                                <span class="text-xs whitespace-nowrap text-theme-secondary-400">
                                    {{ $notification->created_at_local->diffForHumans() }}
                                </span>

                                <button
                                    type="button"
                                    wire:click.stop="deleteNotification('{{ $notification->id }}')"
                                    class="cursor-pointer text-theme-secondary-300 hover:text-theme-primary-500 focus-visible:rounded"
                                >
                                    <x-ark-icon name="trash" size="sm" />
                                </button>
                            </div>
                        </div>
                        <div class="flex justify-between w-full">
                            <div class="flex flex-row w-full space-x-4">
                                <div class="flex">
                                    <x-hermes-notification-icon
                                        :notification="$notification"
                                        :type="$notification->data['type']"
                                        :state-color="$this->getStateColor($notification)"
                                    />
                                </div>

                                <div class="flex-col w-full space-y-1 min-w-0">
                                    <div class="flex justify-between space-x-3">
                                        <div class="block space-x-3">
                                            <h3 class="mb-0 text-xl font-semibold">{{ $notification->name() }}</span>
                                            @if ($notification->is_starred)
                                                <button
                                                    type="button"
                                                    class="transition-default sm:mr-2 focus-visible:rounded"
                                                    wire:click.stop="$emit('markAsUnstarred', '{{ $notification->id }}')"
                                                >
                                                    <x-ark-icon name="star" size="sm" class="text-theme-warning-200" />
                                                </button>
                                            @else
                                                <button
                                                    type="button"
                                                    class="transition-default sm:mr-2 focus-visible:rounded"
                                                    wire:click.stop="$emit('markAsStarred', '{{ $notification->id }}')"
                                                >
                                                    <x-ark-icon name="star-outline" size="sm" class="text-theme-secondary-400" />
                                                </button>
                                            @endif
                                        </div>

                                        <div class="items-start hidden space-x-2 sm:flex">
                                            <span class="text-xs whitespace-nowrap text-theme-secondary-400">
                                                {{ $notification->created_at_local->diffForHumans() }}
                                            </span>

                                            <button
                                                type="button"
                                                wire:click.stop="deleteNotification('{{ $notification->id }}')"
                                                class="cursor-pointer text-theme-secondary-300 hover:text-theme-primary-500 focus-visible:rounded"
                                            >
                                                <x-ark-icon name="trash" size="sm" />
                                            </button>
                                        </div>
                                    </div>
                                    <div class="leading-5 text-theme-secondary-600">
                                        <div class="flex flex-col sm:block">
                                            <span class="break-words">{{ $notification->excerpt() }}</span>

                                            @if($notification->hasAction())
                                                <a href="{{ $notification->link() }}" class="font-semibold link">
                                                    {{ $notification->linkTitle() }}
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @if (! $loop->last)
                    <div class="sm:px-10">
                        <hr class="mt-2 border-b border-dashed border-theme-secondary-200" />
                    </div>
                @endif
            @endforeach

            @if ($notificationCount > $this->notifications->perPage())
                <div class="flex justify-center mt-5">
                    {{ $this->notifications->links('vendor.ark.pagination') }}
                </div>
            @endif
        @else
            <div class="flex flex-col items-center justify-between p-4 mt-5 space-y-2 border-2 rounded cursor-pointer border-theme-secondary-200 sm:flex-row sm:space-y-0">
                <span class="p-3">
                    @if (ARKEcosystem\Foundation\Hermes\Enums\NotificationFilterEnum::isAll($this->activeFilter))
                        @lang('hermes::menus.notifications.no_notifications')
                    @else
                        @lang('hermes::menus.notifications.no_filtered_notifications', ['filter' => $this->activeFilter])
                    @endif
                </span>

                @if (! ARKEcosystem\Foundation\Hermes\Enums\NotificationFilterEnum::isAll($this->activeFilter))
                    <button
                        type="button"
                        wire:click="applyFilter('')"
                        class="flex items-center space-x-2 button-secondary whitespace-nowrap"
                    >
                        <x-ark-icon name="reset" />

                        <span>@lang('hermes::actions.reset_filters')</span>
                    </button>
                @endif
            </div>
        @endif
    </div>
</div>
