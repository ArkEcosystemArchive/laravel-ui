import { uploadImage } from "./utils";

const CropImage = (
    $cropOptions = {},
    $model = null,
    $uploadID = null,
    $cropID = null,
    $saveCropButton = null,
    $cancelCropButton = null,
    $minWidth = 148,
    $minHeight = 148,
    $fillColor = "#fff",
    $imageSmoothingEnabled = true,
    $imageSmoothingQuality = "high",
    $endpoint = "/cropper/upload-image"
) => ({
    model: $model,
    cropper: null,
    isUploading: false,
    isCropping: false,
    select() {
        document.getElementById($uploadID).click();
    },
    loadCropper() {
        const el = document.getElementById($uploadID);
        if (el.files.length) {
            const reader = new FileReader();

            reader.onload = (e) => {
                if (e.target.result) {
                    const img = document.getElementById($cropID);
                    img.src = e.target.result;

                    this.cropper = new Cropper(img, $cropOptions);
                    this.openCropModal();
                }
            };

            reader.readAsDataURL(el.files[0]);
        }
    },
    saveCroppedImage() {
        this.cropper
            .getCroppedCanvas({
                width: $minWidth,
                height: $minHeight,
                fillColor: $fillColor,
                imageSmoothingEnabled: $imageSmoothingEnabled,
                imageSmoothingQuality: $imageSmoothingQuality,
            })
            .toBlob((blob) => {
                const csrfToken = this.getCsrfToken();

                uploadImage(blob, $endpoint, csrfToken).then((response) => {
                    if (!response.url) {
                        throw new Error("Received invalid response");
                    }

                    this.model = response.url;
                });
            });

        this.discardImage();
    },
    discardImage() {
        this.closeCropModal();

        document.getElementById($cropID).src = null;

        this.cropper.destroy();
    },
    openCropModal() {
        this.isCropping = true;

        document
            .getElementById($saveCropButton)
            .addEventListener("click", () => this.saveCroppedImage());

        document
            .getElementById($cancelCropButton)
            .addEventListener("click", () => this.discardImage());
    },
    closeCropModal() {
        this.isCropping = false;

        document
            .getElementById($saveCropButton)
            .removeEventListener("click", () => this.saveCroppedImage());

        document
            .getElementById($cancelCropButton)
            .removeEventListener("click", () => this.discardImage());
    },
    getCsrfToken() {
        return document.querySelector("meta[name=csrf-token]").content;
    },
    init() {
        document.body.style.removeProperty("overflow");
    },
});

window.CropImage = CropImage;
