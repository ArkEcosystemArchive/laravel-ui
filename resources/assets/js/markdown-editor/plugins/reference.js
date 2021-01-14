import { escapeRegExp, createPopup } from "../utils/utils";

// Based on `https://github.com/ArkEcosystem/ark.dev/blob/develop/resources/views/livewire/page-reference.blade.php`
const getPageReferenceHtml = (path) => {
    return `<div class="flex flex-col overflow-hidden bg-white border-2 rounded-lg page-ref sm:flex-row border-theme-primary-100">
    <div class="flex flex-col justify-between flex-1 p-8">
        <div class="flex flex-col">
            <div class="pb-2 border-b border-dashed border-theme-secondary-200">
                <a href="javascript:;" class="pb-2 font-semibold link">${path}</a>
            </div>
            <div>
                <h3 class="mt-2 text-xl font-semibold text-theme-secondary-900">Name of the reference placeholder</h3>
            </div>
        </div>
    </div>
    <a href="javascript:;" class="block rounded-l-none button-secondary">
        <div class="flex items-center justify-center h-full px-4">
            <svg class="fill-current h-6 w-6" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" x="0" y="0" viewBox="0 0 13 24" xml:space="preserve"><path d="M12.2 12.5H1m7.5-3.8l3.7 3.8-3.7 3.7" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg>
        </div>
    </a>
</div>`;
};

const getPageReferenceComponentTag = (path) => {
    return `<livewire:page-reference page="${path}" />`;
};

const extractPathIfUrl = (urlOfPah) => {
    const urlRegex = /(https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s]{2,}|www\.[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s]{2,}|https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9]+\.[^\s]{2,}|www\.[a-zA-Z0-9]+\.[^\s]{2,})/gi;
    const match = urlOfPah.match(urlRegex);

    // Return only the Path
    if (match && match.length === 1) {
        return "/" + match[0].split("://")[1];
    }

    return urlOfPah;
};

const createPopupContent = (editor) => {
    const { i18n } = editor;

    const popupContent = document.createElement("div");

    popupContent.innerHTML = `
        <label for="value">Reference path or URL</label>
        <input id="value" name="value" type="text" class="te-alt-text-input" />
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
            const pageReferencePath = extractPathIfUrl(input.value);
            editor.exec("reference", pageReferencePath);
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
    const name = "reference";
    const title = "Add page reference";
    const tooltip = "reference";

    const popupContent = createPopupContent(editor);

    createPopup(editor, name, menuIndex, svgIcon, popupContent, title, tooltip);
};

const convertMarkdownToHtml = (html) => {
    const regex = new RegExp(
        `&lt;livewire:page-reference\\s+[^&gt;]*page="([^"]*)"[^&gt;]*&gt;`,
        "gm"
    );

    // Used to ensure that the root element is a DIV so its produce valid HTML
    // This avoid some strange behaviours on the preview
    const wrapInDivRegex = new RegExp(
        `<([A-Z][A-Z0-9]*)[^>]*data-nodeid="([^"]*)"[^>]*>(((?!<\\1)[\\s\\S])*&lt;livewire:page-reference\\s+[^&gt;]*page="([^"]*)"[^&gt;]*&gt;.*?(<\/\\1|))<\/\\1>`,
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
            const pageReferencePath = matches[1];
            const regexToReplace = new RegExp(
                `&lt;livewire:page-reference\\s+[^&gt;]*page="(${escapeRegExp(
                    pageReferencePath
                )})"[^&gt;]*&gt;`,
                "gm"
            );
            const embed = getPageReferenceHtml(pageReferencePath);

            replacemenent = replacemenent.replace(regexToReplace, embed);
        }
    }

    return replacemenent;
};

const addPageReferenceMarkdownCommand = (markdownEditor, code) => {
    if (!code) {
        return;
    }

    const codeMirrorEditor = markdownEditor.getEditor();
    const rangeFrom = codeMirrorEditor.getCursor("from");
    const rangeTo = codeMirrorEditor.getCursor("to");
    const text = getPageReferenceComponentTag(code);

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

const referencePlugin = (editor, menuIndex, svgIcon) => {
    editor.eventManager.listen(
        "convertorAfterMarkdownToHtmlConverted",
        convertMarkdownToHtml
    );

    if (!editor.isViewer() && editor.getUI().name === "default") {
        editor.addCommand("markdown", {
            name: "reference",
            exec: addPageReferenceMarkdownCommand,
        });
    }

    initPopup(editor, menuIndex, svgIcon);
};

export default referencePlugin;
