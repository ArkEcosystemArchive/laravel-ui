/**
 * Upload Image
 *
 * @param blob  The upload file in binary mode.
 * @param url  The endpoint where to send the file.
 * @param csrfToken  The CSRF token.
 * @param fieldName  (optional) The request file name.
 * @returns {Promise<Response>}
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
        .then((response) => {
            const { status } = response;
            if (status === 200) {
                return response.json();
            } else if (status === 419) {
                // Means the CSRF Token is no longer valid
                alert(
                    "Session expired. You will need to refresh the browser to continue uploading images."
                );
            } else {
                throw new Error(response);
            }
        })
        .catch((error) => {
            alert("Something went wrong!");

            console.error(error);
        });
};

/**
 * Image Validator
 *
 * @param inputFile  The input file.
 * @param rules  It must be an array of objects with 'rule', 'value' keys.
 */
export const imageValidator = (inputFile, rules = []) => {
    const
        errorBag = [],
        image = new Image(),
        ruleset = [
            'minWidth', 'maxWidth',
            'minHeight', 'maxHeight',
            'minFileSize', 'maxFileSize',
        ];

    const minWidth = (image, target) => {
        if (image.width < target) {
            pushError(getCallerName(), `Image width is less than ${target}px. Given ${image.width}px.`);
        }
    };

    const minHeight = (image, target) => {
        if (image.height < target) {
            pushError(getCallerName(), `Image height is less than ${target}px. Given ${image.height}px.`);
        }
    };

    const maxWidth = (image, target) => {
        if (image.width > target) {
            pushError(getCallerName(), `Image width is greater than ${target}px. Given ${image.width}px.`);
        }
    };

    const maxHeight = (image, target) => {
        if (image.height > target) {
            pushError(getCallerName(), `Image height is greater than ${target}px. Given ${image.height}px.`);
        }
    };

    const minFileSize = (image, target) => {
        let size = bytesToMegabytes(image.size);

        if (size < target) {
            pushError(getCallerName(), `Image file size is less than ${target}Mb. Given ${size}Mb.`);
        }
    };

    const maxFileSize = (image, target) => {
        let size = bytesToMegabytes(image.size);

        if (size > target) {
            pushError(getCallerName(), `Image file size is greater than ${target}Mb. Given ${size}Mb.`);
        }
    };

    const pushError = (err, message) => {
        errorBag.push(errorBagItem(err, message));
    };

    const errorBagItem = (err, message) => {
        return { 'error': err, 'message': message };
    };

    image.src = URL.createObjectURL(inputFile);
    image.size = inputFile.size;

    return new Promise((resolve, reject) => {
        image.onload = (e) => {
            rules.forEach((item) => {
                if (item.hasOwnProperty('rule') && ruleset.includes(item.rule)) {
                    eval(item.rule)(e.target, parseInt(item.value));
                }
            });

            if (errorBag.length) {
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
    return (new Error()).stack.split('\n')[2].replace(/^\s+at\s+(.+?)\s.+/g, '$1');
}

/**
 * Convert bytes to megabytes.
 *
 * @param bytes
 * @returns {string}
 */
export const bytesToMegabytes = (bytes) => {
    return parseFloat(`${parseInt(bytes) / 1000 / 1000}`).toFixed(2);
};
