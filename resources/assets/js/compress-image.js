import {
    uploadImage,
    imageValidator,
    getCsrfToken,
} from "./utils";

import {invalidResponseException} from "./utils/exceptions";

import Compressor from 'compressorjs';

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
    $maxWidth = 7000,
    $maxHeight = 7000,
    $width = null,
    $height = null,
    $maxFileSize = '8',
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
    },

    select() {
        this.uploadEl.click();
    },

    validateImage() {
        if (this.uploadEl.files.length === 0) {
            return;
        }

        [...this.uploadEl.files].forEach(file => {
            imageValidator(file, [
                {rule: "minWidth", value: $minWidth},
                {rule: "maxWidth", value: $maxWidth},
                {rule: "minHeight", value: $minHeight},
                {rule: "maxHeight", value: $maxHeight},
                {rule: "maxFileSize", value: parseInt($maxFileSize)},
            ])
                .then(() => {
                    this.loadCompressor(file);
                })
                .catch((errors) => {
                    Object.values(errors.getAll()).forEach(bags => {
                        [...bags].forEach(({value}) => Livewire.emit("toastMessage", [`${value} - ${file.name}`, "danger"]));
                    });
                });
        });
    },

    onSuccess(file) {
        uploadImage(file, $endpoint, getCsrfToken()).then(
            (response) => {
                if (!response.url) {
                    invalidResponseException();
                }

                this.model = response.url;
            }
        );
    },

    onError(error) {
        throw new Error(error.message);
    },

    loadCompressor(file) {
        new Compressor(file, {
            quality: $quality,
            checkOrientation: parseInt($maxFileSize) <= 10,
            convertSize: $disableConvertSize ? 'Infinity' : $convertSize,
            maxWidth: $maxWidth,
            maxHeight: $maxHeight,
            minWidth: $minWidth,
            minHeight: $minHeight,
            width: $width,
            height: $height,
            success: (file) => this.onSuccess(file),
            error: (error) => this.onError(error),
        });
    },
});

window.CompressImage = CompressImage;
