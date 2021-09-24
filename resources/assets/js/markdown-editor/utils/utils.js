export const escapeRegExp = (string) => {
    return string.replace(/[.*+?^${}()|[\]\\]/g, "\\$&");
};

export const createEditorPopup = (editor, content, title) => {
    return editor.getUI().createPopup({
        header: true,
        title: title,
        content: content,
        className: "tui-editor-popup",
        target: editor.getUI().el,
    });
};

export const createButtonWithIcon = (icon, className = "custom") => {
    const button = document.createElement("button");
    button.className = `tui-toolbar-icons ${className}`;
    button.innerHTML = icon.innerHTML;
    return button;
};

/**
 * Create popup
 * @param {object} editor - Editor instance
 * @param {String} name - name of the popup
 * @param {Number} MenuIndex - index inside the menu
 * @param {object} svgIcon - Svg template
 * @param {String} popupContent - content of the popup
 * @param {String} title - title of the popup
 * @param {String} tooltip - tooltip of the button
 * @ignore
 */
export const createPopup = (
    editor,
    name,
    menuIndex,
    svgIcon,
    popupContent,
    title,
    tooltip
) => {
    const className = `tui-${name}`;
    const event = `${name}ButtonClicked`;
    const toolbar = editor.getUI().getToolbar();

    editor.eventManager.addEventType(event);

    toolbar.insertItem(menuIndex, {
        type: "button",
        options: {
            el: createButtonWithIcon(svgIcon),
            name,
            className,
            event: event,
            tooltip: tooltip,
        },
    });

    const popup = createEditorPopup(editor, popupContent, title);

    popup.customEventManager.on("shown", () =>
        editor.eventManager.emit("popupShown")
    );
    popup.customEventManager.on("hidden", () =>
        editor.eventManager.emit("popupHidden")
    );

    editor.eventManager.listen("focus", () => {
        popup.hide();
    });

    editor.eventManager.listen(event, () => {
        if (popup.isShow()) {
            popup.hide();

            return;
        }

        editor.eventManager.emit("closeAllPopup");
        popup.show();
    });

    editor.eventManager.listen("closeAllPopup", () => {
        popup.hide();
    });

    editor.eventManager.listen("removeEditor", () => {
        popup.el.querySelector(".te-ok-button").removeEventListener("click");
        popup.el.querySelector(".te-close-button").removeEventListener("click");
        popup.remove();
    });
};

const handleFetchSuccessResponse = (response) => {
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
};

const handleFetchErrorResponse = (error) => {
    if (error.name === "AbortError") {
        return;
    }

    alert("Something went wrong!");
    console.error(error);
};

export const uploadImage = (blob, csrfToken) => {
    const formData = new FormData();
    formData.append("image", blob);

    return fetch(`/wysiwyg/upload-image`, {
        method: "POST",
        body: formData,
        headers: {
            "X-Requested-With": "XMLHttpRequest",
            "X-CSRF-TOKEN": csrfToken,
        },
    })
        .then((response) => handleFetchSuccessResponse(response))
        .catch((error) => handleFetchErrorResponse(error));
};

export const getWordsAndCharactersCount = (
    markdown,
    csrfToken,
    cancelSignal
) => {
    const formData = new FormData();
    formData.append("markdown", markdown);

    return fetch(`/wysiwyg/count-characters`, {
        method: "POST",
        body: formData,
        signal: cancelSignal,
        headers: {
            "X-Requested-With": "XMLHttpRequest",
            "X-CSRF-TOKEN": csrfToken,
        },
    })
        .then((response) => handleFetchSuccessResponse(response))
        .catch((error) => handleFetchErrorResponse(error));
};
