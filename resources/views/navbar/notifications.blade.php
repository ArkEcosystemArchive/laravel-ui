<div class="{{ $class ?? ''}}" @click="livewire.emit('markNotificationsAsSeen')">
    <x-ark-dropdown
        wrapper-class="mx-1 md:relative"
        dropdown-classes="mt-8 md:px-0 px-8 {{ $dropdownClasses ?? '' }}"
        button-class="relative"
        dropdown-content-classes="bg-white dark:bg-theme-secondary-800 dark:text-theme-secondary-200 rounded-xl shadow-2xl"
    >
        <x-slot name="button">
            @svg('notification', 'h-5 w-5 transition-default text-theme-secondary-600 hover:text-theme-primary-700')

            @isset($notificationsIndicator)
                {{ $notificationsIndicator }}
            @else
                @livewire('notifications-indicator')
            @endif
        </x-slot>

        {{ $notifications  }}
    </x-ark-dropdown>
</div>
