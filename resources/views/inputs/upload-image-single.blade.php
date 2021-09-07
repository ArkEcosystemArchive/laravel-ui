@props([
    'id',
    'acceptMime'                => (string) config('ui.upload.image-single.accept-mime'),
    'cropCancelButton'          => trans('ui::actions.back'),
    'cropCancelButtonClass'     => 'button-secondary flex items-center justify-center',
    'cropEndpoint'              => route('cropper.upload-image'),
    'cropFillColor'             => '#fff',
    'cropImageSmoothingEnabled' => true,
    'cropImageSmoothingQuality' => 'high',
    'cropMessage'               => trans('ui::modals.crop-image.message'),
    'cropModalWidth'            => 'max-w-xl',
    'cropOptions'               => "{}",
    'cropSaveButton'            => trans('ui::actions.save'),
    'cropSaveButtonClass'       => 'button-primary flex items-center justify-center',
    'cropSaveIcon'              => false,
    'cropTitle'                 => trans('ui::modals.crop-image.title'),
    'deleteTooltip'             => trans('ui::forms.upload-image.delete_image'),
    'dimensions'                => 'w-48 h-48',
    'height'                    => 740,
    'image'                     => null,
    'maxFilesize'               => '5MB',
    'maxHeight'                 => (int) config('ui.upload.image-single.dimensions.max-height'),
    'maxWidth'                  => (int) config('ui.upload.image-single.dimensions.max-width'),
    'minHeight'                 => (int) config('ui.upload.image-single.dimensions.min-height'),
    'minWidth'                  => (int) config('ui.upload.image-single.dimensions.min-width'),
    'quality'                   => 0.8,
    'readonly'                  => false,
    'uploadErrorMessage'        => null,
    'uploadText'                => trans('ui::forms.upload-image.upload_image'),
    'width'                     => 740,
    'withCrop'                  => false,
])

<div
    @if($withCrop)
    x-data="CropImage(
        {{ $cropOptions }},
        @entangle($attributes->wire('model')),
        'image-single-upload-{{ $id }}',
        'image-single-crop-{{ $id }}',
        'crop-modal-{{ $id }}',
        {{ $minWidth }},
        {{ $minHeight }},
        {{ $maxWidth }},
        {{ $maxHeight }},
        @if($width) {{ $width }} @else null @endif,
        @if($height) {{ $height }} @else null @endif,
        '{{ $maxFilesize }}',
        '{{ $cropFillColor }}',
        {{ $cropImageSmoothingEnabled }},
        '{{ $cropImageSmoothingQuality }}',
        '{{ $cropEndpoint }}',
    )"
    @else
    x-data="CompressImage(
        'image-single-upload-{{ $id }}',
        @entangle($attributes->wire('model')),
        {{ $minWidth }},
        {{ $minHeight }},
        {{ $maxWidth }},
        {{ $maxHeight }},
        @if($width) {{ $width }} @else null @endif,
        @if($height) {{ $height }} @else null @endif,
        '{{ $maxFilesize }}',
        {{ $quality }}
    )"
    @endif
    x-init="init"
    x-on:livewire-upload-start="isUploading = true"
    x-on:livewire-upload-finish="isUploading = false"
    x-on:livewire-upload-error="isUploading = false; livewire.emit('uploadError', '{{ $uploadErrorMessage }}');"
    class="relative {{ $dimensions }}"
>
    <div @class([
        'rounded-xl w-full h-full focus-within:border-theme-primary-500',
        'p-2 border-2 border-dashed border-theme-primary-100' => $image,
    ])>
        <div
            @if ($image)
            style="background-image: url('{{ $image }}')"
            @endif
            @class([
                'inline-block w-full h-full bg-center bg-no-repeat bg-cover rounded-xl bg-theme-primary-50',
                'cursor-pointer hover:bg-theme-primary-100 transition-default' => ! $readonly,
            ])
            @unless($readonly)
                @click.self="select"
                role="button"
            @endunless
        >
            @unless($readonly)
                <input
                    id="image-single-upload-{{ $id }}"
                    type="file"
                    class="sr-only"
                    accept="{{ $acceptMime }}"
                    @if($withCrop)
                    @change="validateImage"
                    @else
                    {{ $attributes->wire('model') }}
                    @endif
                />
            @endunless
        </div>

        @if (!$image && !$readonly)
            <div
                wire:key="upload-button"
                class="flex absolute top-2 right-2 bottom-2 left-2 flex-col justify-center items-center space-y-2 rounded-xl cursor-pointer pointer-events-none"
                role="button"
            >
                <div class="text-theme-primary-500">
                    <x-ark-icon name="upload-cloud" size="lg"/>
                </div>

                <div class="font-semibold text-theme-secondary-900">{{ $uploadText }}</div>

                <div class="text-xs font-semibold text-theme-secondary-500">
                    @lang('ui::forms.upload-image.min_size', [$minWidth, $minHeight])
                </div>
                <div class="text-xs font-semibold text-theme-secondary-500">
                    @lang('ui::forms.upload-image.max_filesize', [$maxFilesize])
                </div>
            </div>
        @endif


        @unless($readonly)
            <div
                wire:key="delete-button-{{ $id }}"
                class="rounded-xl absolute top-0 opacity-0 hover:opacity-100 transition-default w-full h-full
                    @unless ($image) hidden @endunless"

            >
                <div
                    class="absolute top-0 w-full h-full rounded-xl opacity-70 pointer-events-none border-6 border-theme-secondary-900 transition-default"></div>

                <button
                    wire:loading.attr="disabled"
                    type="button"
                    class="absolute top-0 right-0 p-1 -mt-2 -mr-2 rounded cursor-pointer bg-theme-danger-100 text-theme-danger-500"
                    wire:click="deleteImageSingle"
                    data-tippy-hover="{{ $deleteTooltip }}"
                >
                    <x-ark-icon name="close" size="sm"/>
                </button>
            </div>

            <div x-show="isUploading" x-cloak>
                <x-ark-loading-spinner class="right-0 bottom-0 left-0 rounded-xl" :dimensions="$dimensions"/>
            </div>
        @endunless
    </div>

    <x-ark-js-modal
        name="crop-modal-{{ $id }}"
        class="w-full max-w-2xl text-left"
        title-class="header-2"
        x-data="{
            onHidden: () => {
                Livewire.emit('discardCroppedImage');
            },
        }"
        close-button-only
        init
    >
        @slot('title')
            {{ $cropTitle }}
        @endslot

        @slot('description')
            @if($cropMessage)
                <div class="mt-3">
                    {!! $cropMessage !!}
                </div>
            @endif

            <div class="-mx-8 mt-8 sm:-mx-10 sm:mt-10 h-75">
                <img id="image-single-crop-{{ $id }}" src="" alt="">
            </div>
        @endslot

        @slot('buttons')
            <button type="button" class="{{ $cropCancelButtonClass }}" @click="hide" dusk="crop-cancel-button">
                {{ $cropCancelButton }}
            </button>

            <button type="button" class="{{ $cropSaveButtonClass }}" @click="Livewire.emit('saveCroppedImage')" dusk="crop-save-button">
                @if($cropSaveIcon)
                    <x-ark-icon :name="$cropSaveIcon" size="sm" class="inline my-auto mr-2"/>
                @endif

                {{ $cropSaveButton }}
            </button>
        @endslot
    </x-ark-js-modal>
</div>
