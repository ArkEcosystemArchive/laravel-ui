@props([
    'image' => null,
    'dimensions' => 'w-48 h-48',
    'uploadText' => trans('ui::forms.upload-image.upload_image'),
    'deleteTooltip' => trans('ui::forms.upload-image.delete_image'),
    'minWidth' => 148,
    'minHeight' => 148,
    'maxFilesize' => '2Mb',
])

<div class="relative">
    <div
        class="rounded-xl {{ $dimensions }}
            @unless ($image) p-2 border-2 border-dashed border-theme-primary-100 @endif"
    >
        <div
            @if ($image)
                style="background-image: url('{{ $image }}')"
            @endif
            class="cursor-pointer bg-theme-primary-50 inline-block bg-cover bg-center bg-no-repeat rounded-xl w-full h-full hover:bg-theme-primary-100 transition-default"
            @click="select()"
            role="button"
        >
            <input
                id="photo"
                type="file"
                class="absolute top-0 hidden block opacity-0 cursor-pointer"
                wire:model="photo"
                accept="image/jpg,image/jpeg,image/bmp,image/png"
            />
        </div>

        @unless ($image)
            <div
                class="cursor-pointer flex flex-col space-y-2 items-center justify-center rounded-xl absolute top-2 right-2 bottom-2 left-2 pointer-events-none"
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
        @else
            <div
                class="rounded-xl absolute top-0 opacity-0 hover:opacity-100 transition-default {{ $dimensions }}"
            >
                <div class="pointer-events-none rounded-xl absolute top-0 opacity-70 border-6 border-theme-secondary-900 transition-default {{ $dimensions }}"></div>

                <div
                    class="cursor-pointer absolute top-0 right-0 -mt-2 -mr-2 rounded bg-theme-danger-100 text-theme-danger-500 p-1"
                    wire:click="delete"
                    data-tippy-content="{{ $deleteTooltip }}"
                >
                    <x-ark-icon name="close" size="sm" />
                </div>
            </div>
        @endunless

        <div x-show="isUploading" x-cloak>
            <x-ark-loading-spinner class="left-0 right-0 bottom-0 rounded-xl" :dimensions="$dimensions" />
        </div>
    </div>
</div>
