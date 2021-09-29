@props([
    'notification',
    'type' => '',
    'stateColor' => 'bg-white',
])

@php
    $relatable = $notification->relatable;
    $media = optional($relatable)->logo();
    $identifier = optional($relatable)->fallbackIdentifier();
    $defaultLogo =  $notification->logo();

    $hasRoute = $notification->route() !== null;
@endphp

@if($hasRoute)<a href="{{ $notification->route() }}" class="notification-avatar-link focus-visible:rounded">@endif
    <div class="relative inline-block pointer-events-none avatar-wrapper">
        <div class="relative w-11 h-11">
            @if($media)
                {{ $media->img('', ['class' => 'absolute object-cover w-full h-full rounded-xl']) }}
            @elseif($identifier)
                <x-ark-avatar :identifier="$identifier" class="absolute object-cover w-full h-full rounded-xl" />
            @elseif($defaultLogo)
                <img class="object-cover rounded-xl" src="{{ $defaultLogo }}" alt="" />
            @else
                <div class="border border-theme-secondary-200 w-11 h-11"></div>
            @endif

        <div
            class="absolute flex items-center justify-center text-transparent rounded-full avatar-circle shadow-solid"
            style="right: -0.8rem; top: -0.9rem;"
        >
            <div class="flex flex-shrink-0 items-center justify-center rounded-full {{ $stateColor }} h-7 w-7">
                @if ($type === ARKEcosystem\Hermes\Enums\NotificationTypeEnum::DANGER)
                    <div class="flex items-center justify-center flex-shrink-0 w-6 h-6 rounded-full bg-theme-danger-100">
                        <x-ark-icon name="notifications.danger" size="sm" class="text-theme-danger-400" />
                    </div>
                @elseif ($type === ARKEcosystem\Hermes\Enums\NotificationTypeEnum::SUCCESS)
                    <div class="flex items-center justify-center flex-shrink-0 w-6 h-6 rounded-full bg-theme-success-100">
                        <x-ark-icon name="notifications.success" size="sm" class="text-theme-success-600" />
                    </div>
                @elseif ($type === ARKEcosystem\Hermes\Enums\NotificationTypeEnum::WARNING)
                    <div class="flex items-center justify-center flex-shrink-0 w-6 h-6 rounded-full bg-theme-warning-100">
                        <x-ark-icon name="notifications.warning" size="sm" class="text-theme-warning-600" />
                    </div>
                @elseif ($type === ARKEcosystem\Hermes\Enums\NotificationTypeEnum::BLOCKED)
                    <div class="flex items-center justify-center flex-shrink-0 w-6 h-6 rounded-full bg-theme-secondary-200">
                        <x-ark-icon name="notifications.blocked" size="sm" class="text-theme-secondary-900" />
                    </div>
                @elseif ($type === ARKEcosystem\Hermes\Enums\NotificationTypeEnum::COMMENT)
                    <div class="flex items-center justify-center flex-shrink-0 w-6 h-6 rounded-full bg-theme-secondary-200">
                        <x-ark-icon name="notifications.comment" size="xs" class="text-theme-secondary-900" />
                    </div>
                @elseif ($type === ARKEcosystem\Hermes\Enums\NotificationTypeEnum::MENTION)
                    <div class="flex items-center justify-center flex-shrink-0 w-6 h-6 rounded-full bg-theme-secondary-200">
                        <x-ark-icon name="notifications.mention" size="sm" class="text-theme-secondary-900" />
                    </div>
                @elseif ($type === ARKEcosystem\Hermes\Enums\NotificationTypeEnum::ANNOUNCEMENT)
                    <div class="flex items-center justify-center flex-shrink-0 w-6 h-6 rounded-full bg-theme-warning-100">
                        <x-ark-icon name="notification" size="sm" class="text-theme-warning-600" />
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@if($hasRoute)</a>@endif
