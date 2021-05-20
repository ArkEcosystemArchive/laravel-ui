/**
 * Upload Image
 *
 * @param blob  The upload file in binary mode.
 * @param url  The endpoint where to send the file.
 * @param csrfToken  The CSRF token.
 * @param fieldName  (optional) The request file name.
 * @returns {Promise<Response>}
 */
export const uploadImage = (blob, url, csrfToken, fieldName = 'image') => {
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
            const {status} = response;
            if (status === 200) {
                return response.json();
            } else if (status === 419) {
                // Means the CSRF Token is no longer valid
                alert("Session expired. You will need to refresh the browser to continue uploading images.");
            } else {
                throw new Error(response);
            }
        })
        .catch((error) => {
            alert("Something went wrong!");

            console.error(error);
        });
};
