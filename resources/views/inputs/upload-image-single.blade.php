@props([
    'id',
    'image'              => null,
    'dimensions'         => 'w-48 h-48',
    'uploadText'         => trans('ui::forms.upload-image.upload_image'),
    'deleteTooltip'      => trans('ui::forms.upload-image.delete_image'),
    'minWidth'           => 148,
    'minHeight'          => 148,
    'maxFilesize'        => '2MB',
    'readonly'           => false,
    'uploadErrorMessage' => null,

    'crop'               => false,
    'cropOptions'        => "{}",
    'cropTitle'          => '',
    'cropMessage'        => '',
    'cropModalWidth'     => 'max-w-xl',
    'cropCancelButton'   => trans('actions.back'),
    'cropSaveButton'     => trans('actions.save'),
    'cropCancelButtonClass' => 'button-secondary flex items-center',
    'cropSaveButtonClass'   => 'button-primary flex items-center',
    'cropSaveIcon'          => false,
])

<div
    x-data="{
        model: @entangle($attributes->wire('model')),
        cropper: null,
        isUploading: false,
        cropping: false,
        saveCropButton: null,
        cancelCropButton: null,
        select() { document.getElementById('image-single-upload-{{ $id }}').click(); },
        loadCropper() {
            const el = document.getElementById('image-single-upload-{{ $id }}');
            if (el.files.length) {
                const reader = new FileReader();

                reader.onload = (e) => {
                    if (e.target.result) {
                        const img = document.getElementById('image-single-crop-{{ $id }}');
                        img.src = e.target.result;

                        this.cropper = new Cropper(img, {{ $cropOptions }});
                        this.openCropModal();
                    }
                };

                reader.readAsDataURL(el.files[0]);
            }
        },
        saveCroppedImage() {
            this.cropper.getCroppedCanvas({
                width: {{ $minWidth }},
                height: {{ $minHeight }},
                fillColor: '#fff',
            }).toBlob((blob) => {
                const csrfToken = document.querySelector('meta[name=csrf-token]').content;

                window.uploadImage(blob, '/cropper/upload-image', csrfToken).then((response) => {
                    if (! response.url) {
                        throw new Error('Received invalid response');
                    }

                    this.model = response.url;
                });
            });

            this.discardImage();
        },
        discardImage() {
            this.closeCropModal();

            document.getElementById('image-single-upload-{{ $id }}').files[0] = null;
            document.getElementById('image-single-crop-{{ $id }}').src = null;

            this.cropper.destroy();
        },
        openCropModal() { this.cropping = true; },
        closeCropModal() { this.cropping = false; },
        initModalButtonListeners() {
            document.getElementById('save-crop-button-{{ $id }}').addEventListener('click', () => this.saveCroppedImage());
            document.getElementById('cancel-crop-button-{{ $id }}').addEventListener('click', () => this.discardImage());
        },
    }"
    x-init="initModalButtonListeners"
    x-on:livewire-upload-start="isUploading = true"
    x-on:livewire-upload-finish="isUploading = false"
    x-on:livewire-upload-error="isUploading = false; livewire.emit('uploadError', '{{ $uploadErrorMessage }}');"
    x-on:cancel-crop-image="discardImage()"
    x-on:save-crop-image="saveCroppedImage()"
    class="relative {{ $dimensions }}"
>
    <div class="rounded-xl w-full h-full @unless ($image) p-2 border-2 border-dashed border-theme-primary-100 @endif">
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
                    id="image-single-upload-{{ $id }}"
                    type="file"
                    class="block absolute top-0 opacity-0 cursor-pointer sr-only"
{{--                    wire:model="imageSingle"--}}
                    accept="image/jpg,image/jpeg,image/bmp,image/png"
                    @change="loadCropper()"
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
        @endif


        @unless($readonly)
            <div
                wire:key="delete-button-{{ $id }}"
                class="rounded-xl absolute top-0 opacity-0 hover:opacity-100 transition-default w-full h-full
                    @unless ($image) hidden @endunless"

            >
                <div class="absolute top-0 w-full h-full rounded-xl opacity-70 pointer-events-none border-6 border-theme-secondary-900 transition-default"></div>

                <div
                    class="absolute top-0 right-0 p-1 -mt-2 -mr-2 rounded cursor-pointer bg-theme-danger-100 text-theme-danger-500"
                    wire:click="deleteImageSingle"
                    data-tippy-hover="{{ $deleteTooltip }}"
                >
                    <x-ark-icon name="close" size="sm" />
                </div>
            </div>

            <div x-show="isUploading" x-cloak>
                <x-ark-loading-spinner class="right-0 bottom-0 left-0 rounded-xl" :dimensions="$dimensions" />
            </div>
        @endunless
    </div>

    <div x-show="cropping">
        <x-ark-modal title-class="header-2" :width-class="$cropModalWidth">
            @slot('title')
                {{ $cropTitle }}
            @endslot

            @slot('description')
                @if($cropMessage)
                    <div class="mt-3">
                        {!!$cropMessage !!}
                    </div>
                @endif

                <div class="mt-8 sm:mt-10 -mx-8 sm:-mx-10" style="margin-left: -2.5rem; margin-right: -2.5rem;">
                    <img id="image-single-crop-{{ $id }}" src="" alt="">
                </div>
            @endslot

            @slot('buttons')
                <button class="{{ $cropCancelButtonClass }}" id="cancel-crop-button-{{ $id }}">
                    {{ $cropCancelButton }}
                </button>

                <button class="{{ $cropSaveButtonClass }}" id="save-crop-button-{{ $id }}">
                    @if($cropSaveIcon)
                        <x-ark-icon :name="$cropSaveIcon" size="sm" class="inline my-auto mr-2" />
                    @endif

                    {{ $cropSaveButton }}
                </button>
            @endslot
        </x-ark-modal>
    </div>
</div>
