import {uploadImage, imageValidator, getCsrfToken, resetUploadInput} from "./utils";
import {invalidResponseException} from "./utils/exceptions";
import ErrorBag from "./utils/error-bag";

const CompressImage = (
    $uploadID,
    $model = null,
    $minWidth = 200,
    $minHeight = 200,
    $maxWidth = 4000,
    $maxHeight = 4000,
    $width = null,
    $height = null,
    $maxFileSize = 2,
    $quality = 0.8,
    $endpoint = "/cropper/upload-image",
    $convertSize = 5000000,
    $disableConvertSize = false
) => ({
    model: $model,
    compressors: [],
    errors: new ErrorBag(),
    isUploading: false,
    uploadEl: null,

    init() {
        this.uploadEl = document.getElementById($uploadID);
    },

    select() {
        this.uploadEl.click();
    },

    validateImage() {
        if (this.uploadEl.files.length === 0) {
            return;
        }

        this.errors.reset();

        this.uploadEl.files.forEach((file) => {
            imageValidator(this.uploadEl.files[0], [
                {rule: "minWidth", value: $minWidth},
                {rule: "maxWidth", value: $maxWidth},
                {rule: "minHeight", value: $minHeight},
                {rule: "maxHeight", value: $maxHeight},
                {rule: "maxFileSize", value: $maxFileSize},
            ])
                .then(() => {
                    this.loadCompressor();
                })
                .catch((errors) => {
                    errors.forEach((err) => {
                        this.errors.push(err.error, err.message)
                        // Livewire.emit("toastMessage", [err.message, "danger"]);
                    });
                });
        });

        this.errors.getAll().forEach((error) => {

        });
    },

    loadCompressor() {
        if (this.uploadEl.files.length === 0) {
            return;
        }

        this.uploadEl.files.forEach((file) => {
            new Compressor(file, {
                /* https://github.com/fengyuanchen/compressorjs#quality */
                quality: $quality,

                /* https://github.com/fengyuanchen/compressorjs#checkorientation */
                checkOrientation: $maxFileSize <= 10,

                /* https://github.com/fengyuanchen/compressorjs#convertsize */
                convertSize: $disableConvertSize ? 'Infinity' : $convertSize,

                maxWidth: $maxWidth,
                maxHeight: $maxHeight,
                minWidth: $minWidth,
                minHeight: $minHeight,
                width: $width,
                height: $height,

                success(result) {
                    uploadImage(result, $endpoint, getCsrfToken()).then(
                        (response) => {
                            if (!response.url) {
                                invalidResponseException();
                            }

                            this.model = response.url;
                        }
                    );

                    this.discardImage();
                },

                error(err) {
                    throw new Error(err.message);
                },
            });
        });
    },

    discardImage() {
        this.destroyCompressor();

        resetUploadInput(this.uploadEl);
    },
});

window.CompressImage = CompressImage;
