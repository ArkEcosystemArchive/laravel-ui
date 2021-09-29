<div class="relative flex flex-col {{ $alignment }}">
    <form class="{{ $formClass }}">
        <x-ark-upload-image-single
            id="profile-image"
            :dimensions="$dimensions"
            :readonly="$readonly"
            :image="$this->user->photo"
            wire:model="imageSingle"
            :upload-text="__('fortify::forms.upload-avatar.upload_avatar')"
            :delete-tooltip="__('fortify::forms.upload-avatar.delete_avatar')"
            :with-crop="$withCrop"
            :crop-options="$cropOptions"
        />
    </form>
</div>
