<div>
    <div class="flex flex-col space-y-4">
        <span class="header-4">@lang('ui::pages.user-settings.update_timezone_title')</span>
        <span>@lang('ui::pages.user-settings.update_timezone_description')</span>
        <div>
            <x-ark-flash />
        </div>
    </div>
    <div class="relative mt-8 space-y-4">
        <x-ark-select :label="trans('ui::actions.select_timezone')" :errors="$errors" name="timezone">
            @foreach ($this->timezones as $timezone)
                @if ($timezone['timezone'] === $this->currentTimezone)
                    <option value="{{ $timezone['timezone'] }}" selected>{{ $timezone['formattedTimezone'] }}</option>
                @else
                    <option value="{{ $timezone['timezone'] }}">{{ $timezone['formattedTimezone'] }}</option>
                @endif
            @endforeach
        </x-ark-select>
    </div>
    <div class="flex justify-end mt-8">
        <button type="submit" class="w-full sm:w-auto button-secondary" wire:click="updateTimezone">@lang('ui::actions.update')</button>
    </div>
</div>
