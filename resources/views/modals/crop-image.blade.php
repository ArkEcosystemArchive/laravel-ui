@props([
    'closeModalAction' => 'closeCropModal',
    'confirmModalAction' => 'confirmCropModal',
    'cancelButton' => trans('actions.back'),
    'cancelButtonClass' => 'button-secondary flex items-center',
    'confirmIcon' => false,
    'confirmButton' => trans('actions.save'),
    'confirmButtonClass' => 'button-primary flex items-center',
    'title' => trans('generic.crop-image'),
    'widthClass' => 'max-w-2xl',
    'message' => null,
    'allowTryAgain' => false,
    'image' => null,
    'cropOptions' => '{}',
])

<div>
    @if($showCropModal ?? $this->showCropModal ?? false)
        <x-ark-modal
            wire-close="{{ $closeModalAction }}"
            title-class="header-2"
            :width-class="$widthClass"
            x-data="{
                cropper: null,
                init() {
                    const image = document.getElementById('image-single-upload-{{ $image }}').files[0];
                    const reader = new FileReader(),
                    console.log(image);

                    reader.onload = (e) => {
                        if (e.target.result) {
                            const { crop } = this.$refs;
                            crop.src = e.target.result;
                            this.cropper = new Cropper(crop, {{ $cropOptions }});
                            console.log('init', this.cropper, crop);
                        }
                    };

                    reader.readAsDataURL(image);
                },
                onHidden() {
                    const image = this.cropper.getCroppedCanvas().toDataURL();
                    $dispatch('input', image);
                },
            }"
        >
            @slot('title')
                {{ $title }}
            @endslot

            @slot('description')
                @if($message)
                    <div>
                        {!! $message !!}
                    </div>
                @endif

                <img x-ref="crop" src="" alt="" crossorigin="anonymous">
            @endslot

            @slot('buttons')
                <button class="{{ $cancelButtonClass }}" wire:click="{{ $closeModalAction }}{{ $allowTryAgain ? '(true)' : '' }}">
                    {{ $cancelButton }}
                </button>

                <button class="{{ $confirmButtonClass }}" wire:click="{{ $confirmModalAction }}">
                    @if($confirmIcon)
                        <x-ark-icon :name="$confirmIcon" size="sm" class="inline my-auto mr-2" />
                    @endif

                    {{ $confirmButton }}
                </button>
            @endslot
        </x-ark-modal>
    @endif
</div>
