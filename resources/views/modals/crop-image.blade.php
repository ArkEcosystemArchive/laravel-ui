@props([
    'cancel' => 'cancelCropModal',
    'cancelButton' => trans('actions.back'),
    'cancelButtonClass' => 'button-secondary flex items-center',

    'confirm' => 'confirmCropModal',
    'confirmIcon' => false,
    'confirmButton' => trans('actions.save'),
    'confirmButtonClass' => 'button-primary flex items-center',

    'title' => trans('generic.crop-image'),
    'widthClass' => 'max-w-2xl',
    'message' => null,
    'allowTryAgain' => true,
    'image' => null,
    // https://github.com/fengyuanchen/cropperjs#options
    'cropOptions' => '{
        aspectRatio: 1 / 1,
        viewMode: 0,
        dragMode: "none",
        minCropBoxWidth: 148,
        minCropBoxHeight: 148,
    }",
])

<div>
    @if($showCropModal ?? $this->showCropModal ?? false)
        <x-ark-modal
            wire-close="{{ $cancel }}"
            title-class="header-2"
            :width-class="$widthClass"
            x-data="{
                Cropper: null,
                loadImage() {
                    const { crop } = this.$refs;

                    crop.src = {{ $image }};

                    this.Cropper = new Cropper(crop, {{ $cropOptions }});
                },
                getCroppedImage() {
                    return this.Cropper.getCroppedCanvas().toDataURL();
                }
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

                <img x-ref="crop" src="" alt="">
            @endslot

            @slot('buttons')
                <button class="{{ $cancelButtonClass }}" wire:click="{{ $cancel }}{{ $allowTryAgain ? '(true)' : '' }}">
                    {{ $cancelButton }}
                </button>

                <button class="{{ $confirmButtonClass }}" wire:click="{{ $confirm }}">
                    @if($confirmIcon)
                        <x-ark-icon :name="$confirmIcon" size="sm" class="inline my-auto mr-2" />
                    @endif

                    {{ $confirmButton }}
                </button>
            @endslot
        </x-ark-modal>
    @endif
</div>
