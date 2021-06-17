@props([
    'id',
    'images'             => [],
    'dimensions'         => 'w-full h-48',
    'imageHeight'        => 'h-28',
    'uploadText'         => trans('ui::forms.upload-image-collection.drag_drop_browse'),
    'deleteTooltip'      => trans('ui::forms.upload-image-collection.delete_image'),
    'minWidth'           => 148,
    'minHeight'          => 148,
    'maxWidth'           => 7000,
    'maxHeight'          => 7000,
    'width'              => null,
    'height'             => null,
    'maxFilesize'        => '8MB',
    'quality'            => 0.8,
    'acceptMime'         => 'image/jpg,image/jpeg,image/bmp,image/png',
    'uploadErrorMessage' => null,
    'sortable'           => false,
])

<div
    x-data="CompressImage(
        'image-collection-upload-{{ $id }}',
        @entangle($attributes->wire('model')),
        {{ $minWidth }},
        {{ $minHeight }},
        {{ $maxWidth }},
        {{ $maxHeight }},
        '{{ $width }}',
        '{{ $height }}',
        '{{ $maxFilesize }}',
        {{ $quality }}
    )"
    x-init="init"
    x-on:livewire-upload-start="isUploading = true"
    x-on:livewire-upload-finish="isUploading = false"
    x-on:livewire-upload-error="isUploading = false; livewire.emit('uploadError', '{{ $uploadErrorMessage }}');"
    class="relative z-0 space-y-8"
>
    <div class="rounded-xl p-2 border-2 border-dashed border-theme-primary-100 relative {{ $dimensions }}">
        <input
            id="image-collection-upload-{{ $id }}"
            type="file"
            class="absolute w-full h-full opacity-0 cursor-pointer"
            @change="validateImage"
            accept="{{ $acceptMime }}"
            multiple
        />

        <div class="flex flex-col justify-center items-center space-y-2 w-full h-full rounded-xl bg-theme-primary-50">
            <div class="text-theme-primary-500">
                <x-ark-icon name="upload-cloud" size="lg"/>
            </div>

            <div class="font-semibold text-theme-secondary-900">{!! $uploadText !!}</div>

            <div
                class="flex flex-col space-y-1 text-xs font-semibold text-center sm:flex-row sm:space-y-0 sm:space-x-1 text-theme-secondary-500 chunk-header">
                @lang('ui::forms.upload-image-collection.requirements', [
                    'width'    => $minWidth,
                    'height'   => $minHeight,
                    'filesize' => $maxFilesize,
                    'quantity' => $this->getImageCollectionMaxQuantity(),
                ])
            </div>
        </div>

        <div x-show="isUploading" x-cloak>
            <x-ark-loading-spinner class="right-0 bottom-0 left-0 rounded-xl" :dimensions="$dimensions"/>
        </div>
    </div>

    @if (count($images) > 0)
        <div class="flex flex-wrap -m-3" @if($sortable)wire:sortable="updateImageOrder"@endif>
            @foreach ($images as $index => $image)
                <div class="p-3 w-1/2 sm:w-1/3 md:w-1/4 lg:w-1/5 xl:w-1/6" wire:sortable.item="{{ $index }}" wire:key="image-{{ $index }}">
                    <div class="aspect-w-16 aspect-h-9">
                        <div>
                            <img src="{{ $image['url'] }}" class="object-cover w-full h-full rounded-xl border border-theme-secondary-300" alt="">
                        </div>

                        <div class="absolute inset-0 opacity-0 hover:opacity-100 transition-default">
                            <div class="select-none rounded-xl flex flex-col items-center justify-center opacity-70 @if($sortable) bg-theme-secondary-900 @else border-6 border-theme-secondary-900 @endif w-full h-full">
                                @if($sortable)
                                    <x-ark-icon name="drag" size="lg" class="text-white"/>
                                    <p class="mt-3 text-xs font-semibold text-theme-secondary-500">Drag to
                                        reposition</p>
                                @endif
                            </div>

                            <button type="button" data-action
                                    class="absolute top-0 right-0 p-1 -mt-2 -mr-2 rounded cursor-pointer bg-theme-danger-100 text-theme-danger-500"
                                    wire:click="deleteImage({{ $index }})"
                                    data-tippy-hover="{{ $deleteTooltip }}"
                            >
                                <x-ark-icon name="close" size="sm"/>
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
