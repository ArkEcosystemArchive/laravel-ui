const uploadImage = (blob, url, csrfToken) => {
    const formData = new FormData();
    formData.append("image", blob);

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
                // Means the CSRF Token is no longer valid
            } else if (status === 419) {
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

window.uploadImage = uploadImage;
