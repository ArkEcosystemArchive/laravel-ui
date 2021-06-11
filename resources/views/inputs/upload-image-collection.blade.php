@props([
    'id',
    'images'             => [],
    'dimensions'         => 'w-full h-48',
    'imageHeight'        => 'h-28',
    'uploadText'         => trans('ui::forms.upload-image-collection.drag_drop_browse'),
    'deleteTooltip'      => trans('ui::forms.upload-image-collection.delete_image'),
    'minWidth'           => 148,
    'minHeight'          => 148,
    'maxFilesize'        => '2MB',
    'uploadErrorMessage' => null,
    'sortable'           => false,
])

<div
    x-data="{ isUploading: false, select() { document.getElementById('image-collection-upload-{{ $id }}').click(); } }"
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
            wire:model="temporaryImages"
            accept="image/jpg,image/jpeg,image/bmp,image/png"
            multiple
        />

        <div class="flex flex-col justify-center items-center space-y-2 w-full h-full rounded-xl bg-theme-primary-50">
            <div class="text-theme-primary-500">
                <x-ark-icon name="upload-cloud" size="lg" />
            </div>

            <div class="font-semibold text-theme-secondary-900">{!! $uploadText !!}</div>

            <div class="flex flex-col space-y-1 text-xs font-semibold text-center sm:flex-row sm:space-y-0 sm:space-x-1 text-theme-secondary-500 chunk-header">
                @lang('ui::forms.upload-image-collection.requirements', [
                    'width'    => $minWidth,
                    'height'   => $minHeight,
                    'filesize' => $maxFilesize,
                    'quantity' => $this->getImageCollectionMaxQuantity(),
                ])
            </div>
        </div>

        <div x-show="isUploading" x-cloak>
            <x-ark-loading-spinner class="right-0 bottom-0 left-0 rounded-xl" :dimensions="$dimensions" />
        </div>
    </div>

    @if (count($images) > 0)
        <div class="grid grid-cols-2 gap-6 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6" @if($sortable)wire:sortable="updateImageOrder"@endif>
            @foreach ($images as $index => $image)
                <div class="relative {{ $imageHeight }}" wire:sortable.item="{{ $index }}" wire:key="image-{{ $index }}">
                    <div class="relative inline-block w-full h-full rounded-xl border border-theme-secondary-300 overflow-hidden">
                        <img src="{{ $image['url'] }}" class="object-cover w-full h-full" alt="">
                    </div>

                    <div class="absolute top-0 opacity-0 hover:opacity-100 transition-default w-full {{ $imageHeight }}">
                        <div class="select-none rounded-xl flex flex-col items-center justify-center opacity-80 bg-theme-secondary-900 w-full {{ $imageHeight }}">
                            <x-ark-icon name="drag" size="lg" class="text-white"/>
                            <p class="mt-3 font-semibold text-xs text-theme-secondary-500">Drag to reposition</p>
                        </div>

                        <button type="button" data-action
                            class="absolute top-0 right-0 p-1 -mt-2 -mr-2 rounded cursor-pointer bg-theme-danger-100 text-theme-danger-500"
                            wire:click="deleteImage({{ $index }})"
                            data-tippy-hover="{{ $deleteTooltip }}"
                        >
                            <x-ark-icon name="close" size="sm" />
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
