<div @click="livewire.emit('markNotificationsAsSeen')">
    <x-ark-dropdown wrapper-class="ml-3 sm:relative" dropdown-classes="mt-6 md:mt-8 {{ $dropdownClasses ?? '' }}">
        @slot('button')
            @svg('notification', 'h-6 w-6 transition-default')

            {{ $indicator }}
        @endslot

        {{ $slot }}
    </x-ark-dropdown>
</div>
