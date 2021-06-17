import {
    uploadImage,
    imageValidator,
    getCsrfToken,
    resetUploadInput,
} from "./utils";

import { invalidResponseException } from "./utils/exceptions";

import Compressor from "compressorjs";

/**
 * @param {String} $uploadID
 * @param {String} $model
 * @param {Number} $minWidth
 * @param {Number} $minHeight
 * @param {Number} $maxWidth
 * @param {Number} $maxHeight
 * @param {Number} $width
 * @param {Number} $height
 * @param {String} $maxFileSize
 * @param {Number} $quality
 * @param {string} $endpoint
 * @param {Number} $convertSize
 * @param {Boolean} $disableConvertSize
 * @return {Object}
 */
const CompressImage = (
    $uploadID,
    $model = null,
    $minWidth = 200,
    $minHeight = 200,
    $maxWidth = 4000,
    $maxHeight = 4000,
    $width = null,
    $height = null,
    $maxFileSize = "2",
    $quality = 0.8,
    $endpoint = "/cropper/upload-image",
    $convertSize = 5000000,
    $disableConvertSize = false
) => ({
    model: $model,
    isUploading: false,
    uploadEl: null,

    init() {
        this.uploadEl = document.getElementById($uploadID);

        // this.$watch(this.model, () => resetUploadInput(this.uploadEl));
    },

    select() {
        this.uploadEl.click();
    },

    validateImage() {
        if (this.uploadEl.files.length === 0) {
            return;
        }

        [...this.uploadEl.files].forEach((file) => {
            imageValidator(file, [
                { rule: "minWidth", value: $minWidth },
                { rule: "maxWidth", value: $maxWidth },
                { rule: "minHeight", value: $minHeight },
                { rule: "maxHeight", value: $maxHeight },
                { rule: "maxFileSize", value: parseInt($maxFileSize) },
            ])
                .then(() => this.loadCompressor())
                .catch((errors) => {
                    errors.getAll().forEach((bags) => {
                        bags[1].forEach(({ value }) =>
                            Livewire.emit("toastMessage", [value, "danger"])
                        );
                    });
                });
        });
    },

    loadCompressor() {
        if (this.uploadEl.files.length === 0) {
            return;
        }

        [...this.uploadEl.files].forEach((file) => {
            new Compressor(file, {
                /* https://github.com/fengyuanchen/compressorjs#quality */
                quality: $quality,

                /* https://github.com/fengyuanchen/compressorjs#checkorientation */
                checkOrientation: parseInt($maxFileSize) <= 10,

                /* https://github.com/fengyuanchen/compressorjs#convertsize */
                convertSize: $disableConvertSize ? "Infinity" : $convertSize,

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
                },

                error(err) {
                    throw new Error(err.message);
                },
            });
        });
    },
});

window.CompressImage = CompressImage;
