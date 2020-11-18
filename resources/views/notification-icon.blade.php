<div class="inline-block pointer-events-none">
    <div class="w-12 h-12">
        @php
            $notificationSettings = [
                'danger'  => [
                    'backgroundColor' => 'bg-theme-danger-100',
                    'textColor'       => 'text-theme-danger-600',
                    'icon'            => 'notification',
                ],
                'success' => [
                    'backgroundColor' => 'bg-theme-primary-100',
                    'textColor'       => 'text-theme-primary-600',
                    'icon'            => 'notification',
                ],
                'warning' => [
                    'backgroundColor' => 'bg-theme-warning-100',
                    'textColor'       => 'text-theme-warning-600',
                    'icon'            => 'notification',
                ],
            ][$type];
        @endphp

        <div class="flex {{ $notificationSettings['backgroundColor'] }} w-11 h-11 rounded-md">
            <span class="flex items-center justify-center w-full">
                @svg("{$notificationSettings['icon']}", "w-5 h-5 text-center {$notificationSettings['textColor']}")
            </span>
        </div>
    </div>
</div>