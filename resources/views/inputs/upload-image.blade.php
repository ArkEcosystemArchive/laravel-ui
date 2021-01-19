@props([
    'image'         => null,
    'dimensions'    => 'w-48 h-48',
    'uploadText'    => trans('ui::forms.upload-image.upload_image'),
    'deleteTooltip' => trans('ui::forms.upload-image.delete_image'),
    'minWidth'      => 148,
    'minHeight'     => 148,
    'maxFilesize'   => '2MB',
    'readonly'      => false,
])

<div class="relative">
    <div class="rounded-xl {{ $dimensions }} @unless ($image) p-2 border-2 border-dashed border-theme-primary-100 @endif">
        <div
            @if ($image)
                style="background-image: url('{{ $image }}')"
            @endif
            class="inline-block w-full h-full bg-center bg-no-repeat bg-cover rounded-xl bg-theme-primary-50 @unless($readonly) cursor-pointer hover:bg-theme-primary-100 transition-default @endunless"
            @unless($readonly)
            @click="select()"
            role="button"
            @endunless
        >
            @unless($readonly)
            <input
                id="photo"
                type="file"
                class="absolute top-0 hidden block opacity-0 cursor-pointer"
                wire:model="photo"
                accept="image/jpg,image/jpeg,image/bmp,image/png"
            />
            @endunless
        </div>

        @if ($readonly)

        @else
            @unless ($image)
                <div
                    wire:key="upload-button"
                    class="absolute flex flex-col items-center justify-center space-y-2 cursor-pointer pointer-events-none top-2 right-2 bottom-2 left-2 rounded-xl"
                    role="button"
                >
                    <div class="text-theme-primary-500">
                        <x-ark-icon name="upload-cloud" size="lg" />
                    </div>

                    <div class="font-semibold text-theme-secondary-900">{{ $uploadText }}</div>

                    <div class="text-xs font-semibold text-theme-secondary-500">
                        @lang('ui::forms.upload-image.min_size', [$minWidth, $minHeight])
                    </div>
                    <div class="text-xs font-semibold text-theme-secondary-500">
                        @lang('ui::forms.upload-image.max_filesize', [$maxFilesize])
                    </div>
                </div>
            @endunless
        @endif


        @unless($readonly)
        <div
            wire:key="delete-button"
            class="rounded-xl absolute top-0 opacity-0 hover:opacity-100 transition-default {{ $dimensions }}
                @unless ($image) hidden @endunless"

        >
            <div class="pointer-events-none rounded-xl absolute top-0 opacity-70 border-6 border-theme-secondary-900 transition-default {{ $dimensions }}"></div>

            <div
                class="absolute top-0 right-0 p-1 -mt-2 -mr-2 rounded cursor-pointer bg-theme-danger-100 text-theme-danger-500"
                wire:click="delete"
                data-tippy-hover="{{ $deleteTooltip }}"
            >
                <x-ark-icon name="close" size="sm" />
            </div>
        </div>

        <div x-show="isUploading" x-cloak>
            <x-ark-loading-spinner class="bottom-0 left-0 right-0 rounded-xl" :dimensions="$dimensions" />
        </div>
        @endunless
    </div>
</div>
