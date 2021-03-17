import { escapeRegExp, createPopup } from "../utils/utils";

// Based on `laravel-ui/resources/views/alert.blade.php`
const getAlertHTML = (alertText, alertType) => {
    return `<div class="alert-wrapper alert-${alertType}">
    <div class="alert-icon-wrapper alert-${alertType}-icon ">
        <svg class="fill-current h-8 w-8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
            <g fill="none" stroke="currentColor" stroke-width="2" stroke-linejoin="round">
                <path d="M12.004.8C5.804.8.804 5.8.804 12s5 11.2 11.2 11.2 11.2-5 11.2-11.2-5-11.2-11.2-11.2z"></path>
                <path d="M12.004 17v-6m0-3.4c.2 0 .4-.2.4-.4s-.2-.4-.4-.4-.4.2-.4.4.2.4.4.4" stroke-linecap="round"></path>
            </g>
        </svg>
    </div>
    <div class="alert-content-wrapper alert-${alertType}-content ">
        <span class="block">${alertText}</span>
    </div>
</div>`;
};

const getAlertComponentTag = (alertText, alertType) => {
    return `<x-alert type="${alertType}">${alertText}</x-alert>`;
};

const createPopupContent = (editor) => {
    const { i18n } = editor;

    const popupContent = document.createElement("div");

    popupContent.innerHTML = `
        <label for="value">Alert type</label>
        <select id="type" name="type">
            <option value="info">Info</option>
            <option value="success">Success</option>
            <option value="warning">Warning</option>
            <option value="danger">Danger</option>
        </select>

        <label for="value">Alert text</label>
        <input id="value" name="value" type="text" />
        <div class="te-button-section">
            <button type="button" class="te-ok-button">${i18n.get(
                "OK"
            )}</button>
            <button type="button" class="te-close-button">${i18n.get(
                "Cancel"
            )}</button>
        </div>
    `;

    popupContent
        .querySelector("button.te-ok-button")
        .addEventListener("click", () => {
            const input = popupContent.querySelector('[name="value"]');
            const typeSelect = popupContent.querySelector('[name="type"]');
            const alertText = input.value;
            const alertType = typeSelect.value;
            editor.exec("alert", alertText, alertType);
            input.value = "";

            editor.eventManager.emit("closeAllPopup");
        });

    popupContent
        .querySelector("button.te-close-button")
        .addEventListener("click", () => {
            editor.eventManager.emit("closeAllPopup");
        });

    return popupContent;
};

/**
 * Initialize UI
 * @param {object} editor - Editor instance
 * @param {int} MenuIndex - index inside the menu
 * @param {object} svgIcon - Svg template
 * @ignore
 */
const initPopup = (editor, menuIndex, svgIcon) => {
    const name = "alert";
    const title = "Add Alert";
    const tooltip = "Alert";

    const popupContent = createPopupContent(editor);

    createPopup(editor, name, menuIndex, svgIcon, popupContent, title, tooltip);
};

const convertMarkdownToHtml = (html) => {
    const regex = new RegExp(
        `<x-alert[^>]*type="([^"]*)"[^>]*>(((?!<\/x-alert)[\\s\\S])*.*?(<\/x-alert|))<\/x-alert>`,
        "gm"
    );

    // Used to ensure that the root element is a DIV so its produce valid HTML
    // This avoid some strange behaviours on the preview
    const wrapInDivRegex = new RegExp(
        `<([A-Z][A-Z0-9]*)[^>]*data-nodeid="([^"]*)"[^>]*>(((?!<\\1)[\\s\\S])*<x-alert[^>]*type="([^"]*)"[^>]*>(((?!<\/x-alert)[\\s\\S])*.*?(<\/x-alert|))<\/x-alert>.*?(<\/\\1|))<\/\\1>`,
        "gmsi"
    );
    const validHTML = html.replace(
        wrapInDivRegex,
        '<div data-nodeid="$2">$3</div>'
    );

    let replacemenent = validHTML;
    let matches;
    while ((matches = regex.exec(validHTML)) !== null) {
        if (matches.length && matches.length >= 1) {
            const alertType = matches[1];
            const alertText = matches[2];
            const regexToReplace = new RegExp(
                `<x-alert[^>]*type="(${escapeRegExp(
                    alertType
                )})"[^>]*>(${escapeRegExp(alertText)})<\/x-alert>`,
                "gm"
            );
            const embed = getAlertHTML(alertText, alertType);

            replacemenent = replacemenent.replace(regexToReplace, embed);
        }
    }

    return replacemenent;
};

const addAlertCommand = (markdownEditor, alertText, alertType) => {
    const codeMirrorEditor = markdownEditor.getEditor();
    const rangeFrom = codeMirrorEditor.getCursor("from");
    const rangeTo = codeMirrorEditor.getCursor("to");

    const text = getAlertComponentTag(alertText, alertType);

    codeMirrorEditor.replaceSelection(text, "start", 0);

    codeMirrorEditor.setSelection(
        {
            line: rangeFrom.line,
            ch: rangeFrom.ch + text.length,
        },
        {
            line: rangeTo.line,
            ch:
                rangeFrom.line === rangeTo.line
                    ? rangeTo.ch + text.length
                    : rangeTo.ch,
        }
    );

    markdownEditor.focus();
};

const alertPlugin = (editor, menuIndex, svgIcon) => {
    editor.eventManager.listen(
        "convertorAfterMarkdownToHtmlConverted",
        convertMarkdownToHtml
    );

    if (!editor.isViewer() && editor.getUI().name === "default") {
        editor.addCommand("markdown", {
            name: "alert",
            exec: addAlertCommand,
        });
    }

    initPopup(editor, menuIndex, svgIcon);
};

export default alertPlugin;
