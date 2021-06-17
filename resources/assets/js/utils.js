import ErrorBag from "./utils/error-bag";

/**
 * Upload Image.
 *
 * @param {string|Blob} blob  The upload file in binary mode.
 * @param {string} url  The endpoint where to send the file.
 * @param {string} csrfToken  The CSRF token.
 * @param {string} fieldName  (optional) The request file name.
 * @returns {Promise.<any>}  A Promise that resolves to a JavaScript object. This object could be anything that can be represented by JSON — an object, an array, a string, a number...
 * @throws {Error}
 */
export const uploadImage = (blob, url, csrfToken, fieldName = "image") => {
    const formData = new FormData();
    formData.append(fieldName, blob);

    return fetch(url, {
        method: "POST",
        body: formData,
        headers: {
            "X-Requested-With": "XMLHttpRequest",
            "X-CSRF-TOKEN": csrfToken,
        },
    })
        .then(response => {
            const {status} = response;
            if (status === 200) {
                return response.json();
            } else if (status === 419) {
                // Means the CSRF Token is no longer valid
                throw new Error("Session expired. You will need to refresh the browser to continue uploading images.");
            } else {
                response.text().then(text => {
                    throw new Error(text);
                });
            }
        })
        .catch(error => {
            throw new Error(error);
        });
};

/**
 * Image Validator.
 *
 * @param {Object} inputFile  The input file.
 * @param {Object[]} rules  The array of objects with 'rule', 'value' keys.
 * @return {Promise.<void>|<ErrorBag>}
 */
export const imageValidator = (inputFile, rules = []) => {
    const errorBag = new ErrorBag(inputFile.name),
        image = new Image(),
        ruleset = [
            "minWidth",
            "maxWidth",
            "minHeight",
            "maxHeight",
            "minFileSize",
            "maxFileSize",
        ];

    const minWidth = (image, target) => {
        if (image.width < target) {
            errorBag.add(
                getCallerName(),
                `The image should be at least ${target}x${target}px`
            )
        }
    };

    const minHeight = (image, target) => {
        if (image.height < target) {
            errorBag.add(
                getCallerName(),
                `The image should be at least ${target}x${target}px`
            );
        }
    };

    const maxWidth = (image, target) => {
        if (image.width > target) {
            errorBag.add(
                getCallerName(),
                `The image should be no bigger than ${target}x${target}px`
            );
        }
    };

    const maxHeight = (image, target) => {
        if (image.height > target) {
            errorBag.add(
                getCallerName(),
                `The image should be no bigger than ${target}x${target}px`
            );
        }
    };

    const minFileSize = (image, target) => {
        let size = bytesToMegabytes(image.size);

        if (size < target) {
            errorBag.add(
                getCallerName(),
                `The image should be at least ${target}MB`
            );
        }
    };

    const maxFileSize = (image, target) => {
        let size = bytesToMegabytes(image.size);

        if (size > target) {
            errorBag.add(
                getCallerName(),
                `The image should be no bigger than ${target}MB`
            );
        }
    };

    image.src = URL.createObjectURL(inputFile);
    image.size = inputFile.size;

    return new Promise((resolve, reject) => {
        image.onload = (e) => {
            rules.forEach((item) => {
                if (
                    item.hasOwnProperty("rule") &&
                    ruleset.includes(item.rule)
                ) {
                    eval(item.rule)(e.target, parseInt(item.value));
                }
            });

            if (errorBag.hasErrors()) {
                reject(errorBag);
            }

            resolve();
        };
    });
};

/**
 * Get the name of the called function.
 *
 * @returns {string}
 */
export const getCallerName = () => {
    return new Error().stack
        .split("\n")[2]
        .replace(/^\s+at\s+(.+?)\s.+/g, "$1");
};

/**
 * Convert bytes to megabytes.
 *
 * @param bytes
 * @returns {string}
 */
export const bytesToMegabytes = (bytes) => parseFloat(`${parseInt(bytes) / 1000 / 1000}`).toFixed(2);

/**
 * Get CSRF token from DOM.
 *
 * @returns {string}
 */
export const getCsrfToken = () => document.querySelector("meta[name=csrf-token]").content;

/**
 * Reset an input file field.
 *
 * @param {Object} uploadEl
 */
export const resetUploadInput = (uploadEl) => {
    uploadEl.value = "";
    uploadEl.type = "";
    uploadEl.type = "file";
};
