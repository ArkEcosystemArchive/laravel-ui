import { uploadImage, imageValidator } from "./utils";

const CropImage = (
    $cropOptions = {},
    $model = null,
    $uploadID = null,
    $cropID = null,
    $modalID = null,
    $minWidth = 148,
    $minHeight = 148,
    $maxWidth = 1000,
    $maxHeight = 1000,
    $width = 800,
    $height = 800,
    $maxFileSize = 2,
    $fillColor = "#fff",
    $imageSmoothingEnabled = true,
    $imageSmoothingQuality = "high",
    $endpoint = "/cropper/upload-image"
) => ({
    model: $model,
    cropper: null,
    isUploading: false,
    isCropping: false,
    uploadEl: null,
    cropEl: null,
    modalCancelButton: null,
    modalSaveButton: null,

    init() {
        this.uploadEl = document.getElementById($uploadID);

        Livewire.on('discardCroppedImage', () => {
            this.discardImage();
        });

        Livewire.on('saveCroppedImage', () => {
            Livewire.emit('closeModal', $modalID);

            this.saveCroppedImage();
        });
    },

    destroyCropper() {
        if (! this.cropper) {
            return;
        }

        this.cropper.destroy();
        this.cropper = null;
    },

    select() {
        this.uploadEl.click();
    },

    validateImage() {
        if (this.uploadEl.files.length) {
            imageValidator(this.uploadEl.files[0], [
                { rule: 'minWidth', value: $minWidth },
                { rule: 'maxWidth', value: $maxWidth },
                { rule: 'minHeight', value: $minHeight },
                { rule: 'maxHeight', value: $maxHeight },
                { rule: 'maxFileSize', value: $maxFileSize },
            ]).then(() => {
                this.loadCropper();
            }).catch((err) => {
                err.forEach((err) => {
                    Livewire.emit('toastMessage', [err.message, 'danger']);
                });
            });
        }
    },

    loadCropper() {
        if (this.uploadEl.files.length) {
            const reader = new FileReader();
            reader.onload = (e) => {
                if (e.target.result) {
                    this.cropEl = document.getElementById($cropID);
                    this.cropEl.src = e.target.result;

                    this.cropper = new Cropper(this.cropEl, $cropOptions);

                    this.$nextTick(() => {
                        this.destroyCropper();
                        this.cropper = new Cropper(this.cropEl, $cropOptions);
                    });

                    this.openCropModal();
                }
            };

            reader.readAsDataURL(this.uploadEl.files[0]);
        }
    },

    saveCroppedImage() {
        if (! this.cropper) {
            return;
        }

        let croppedCanvas = this.cropper.getCroppedCanvas({
            minWidth: $minWidth,
            minHeight: $minHeight,
            maxWidth: $maxWidth,
            maxHeight: $maxHeight,
            width: $width,
            height: $height,
            fillColor: $fillColor,
            imageSmoothingEnabled: $imageSmoothingEnabled,
            imageSmoothingQuality: $imageSmoothingQuality,
        });

        if (! croppedCanvas) {
            return;
        }

        croppedCanvas.toBlob((blob) => {
            uploadImage(blob, $endpoint, this.getCsrfToken())
                .then((response) => {
                    if (!response.url) {
                        throw new Error("Received invalid response");
                    }

                    this.model = response.url;
                });
        });

        this.discardImage();
    },

    discardImage() {
        this.destroyCropper();

        this.resetUploadInput();
    },

    resetUploadInput() {
        this.uploadEl.value = "";
        this.uploadEl.type = "";
        this.uploadEl.type = "file";
    },

    openCropModal() {
        Livewire.emit('openModal', $modalID);
    },

    getCsrfToken() {
        return document.querySelector("meta[name=csrf-token]").content;
    },
});

window.CropImage = CropImage;
