<div>
    @if($this->notificationsUnread ?? false)
        <div class="absolute right-0 flex items-center justify-center w-3 h-3 mr-3 -mt-3 bg-white border-white rounded-full">
            <div class="w-2 h-2 rounded-full bg-theme-danger-500"></div>
        </div>
    @endif
</div>
