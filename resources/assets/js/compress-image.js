import {
    uploadImage,
    imageValidator,
    getCsrfToken,
    resetUploadInput,
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
    files: [],

    init() {
        this.uploadEl = document.getElementById($uploadID);

        this.$watch(this.files, (value) => this.loadCompressor(value));
    },

    select() {
        this.uploadEl.click();
    },

    validateImage() {
        if (this.uploadEl.files.length === 0) {
            return;
        }

        [...this.uploadEl.files].forEach(file => {
            console.log('validate', file);

            imageValidator(file, [
                {rule: "minWidth", value: $minWidth},
                {rule: "maxWidth", value: $maxWidth},
                {rule: "minHeight", value: $minHeight},
                {rule: "maxHeight", value: $maxHeight},
                {rule: "maxFileSize", value: parseInt($maxFileSize)},
            ])
                .then(() => {
                    this.files.push(file);
                })
                .catch((errors) => {
                    errors.getAll().forEach(bags => {
                        [...bags].forEach(({value}) => Livewire.emit("toastMessage", [`${value} - ${file.name}`, "danger"]));
                    });
                });
        });
    },

    onSuccess(file) {

        // Remove file from the list to avoid concurrency call.
        // this.files.slice(this.files.findIndex(obj => obj === file), 1);

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

    loadCompressor(collection) {
        console.log('compress - collection', collection);
        console.log('compress - this.files', this.files);

        collection.forEach(file => {
            new Compressor(file, {
                /* https://github.com/fengyuanchen/compressorjs#quality */
                quality: $quality,

                /* https://github.com/fengyuanchen/compressorjs#checkorientation */
                checkOrientation: parseInt($maxFileSize) <= 10,

                /* https://github.com/fengyuanchen/compressorjs#convertsize */
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
        });
    },
});

window.CompressImage = CompressImage;
