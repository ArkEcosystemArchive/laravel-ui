import { escapeRegExp, createPopup } from "../utils/utils";

// Based on `https://github.com/ArkEcosystem/ark.dev/blob/develop/resources/views/livewire/embed-link.blade.php`
const getEmbedLinkHtml = (url) => {
    const parser = document.createElement("a");
    parser.href = url;

    return `<div class="embed-link flex flex-col sm:flex-row overflow-hidden rounded-xl border-2 border-theme-primary-100 bg-white transition-default hover:size-increase hover:shadow-lg hover:border-0 cursor-pointer">
    <div class="flex flex-col justify-between flex-1 p-8">
        <div class="flex flex-col">
            <span class="text-sm border-b border-dashed border-theme-primary-100 pb-2">
                <a href="javascript:;" class="link font-semibold flex items-center space-x-2 whitespace-nowrap" target="_blank" rel="noopener nofollow noreferrer">
                    <span>${parser.hostname}</span>
                    <svg class="fill-current h-3 w-3 flex-shrink-0 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M23.251 7.498V.748h-6.75m6.75 0l-15 15m3-10.5h-9a1.5 1.5 0 00-1.5 1.5v15a1.5 1.5 0 001.5 1.5h15a1.5 1.5 0 001.5-1.5v-9" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                </a>
            </span>
            <a href="javascript:;" target="_blank" rel="noopener nofollow noreferrer" class="block">
                <h3 class="mt-2 text-xl font-semibold text-theme-secondary-900">
                    ${parser.pathname}
                </h3>
                <div class="mt-3 text-theme-secondary-700">
                    Text of the embed
                </div>
            </a>
        </div>
    </div>
    <div class="flex-shrink-0 border-l-2 border-theme-primary-100 w-full sm:w-1/4 max-h-32 sm:max-h-full">
        <img class="object-cover w-full h-full" src="https://via.placeholder.com/230?text=Image%20Placeholder" alt="">
    </div>
</div>`;
};

const getEmbedLinkTag = (url, caption) => {
    return `<livewire:embed-link url="${url}" caption="${caption}" />`;
};

const createPopupContent = (editor) => {
    const { i18n } = editor;

    const popupContent = document.createElement("div");

    popupContent.innerHTML = `
        <label for="url">URL</label>
        <input id="url" name="url" type="text" class="te-alt-text-input" />
        <label for="caption">Caption</label>
        <input id="caption" name="caption" type="text" class="te-alt-text-input" />
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
            const url = popupContent.querySelector('[name="url"]');
            const caption = popupContent.querySelector('[name="caption"]');
            editor.exec("embedlink", url.value, caption.value);

            url.value = "";
            caption.value = "";

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
    const name = "embedlink";
    const title = "Add Embed Link";
    const tooltip = "Embed Link";

    const popupContent = createPopupContent(editor);

    createPopup(editor, name, menuIndex, svgIcon, popupContent, title, tooltip);
};

const convertMarkdownToHtml = (html) => {
    const regex = new RegExp(
        `&lt;livewire:embed-link[^&gt;]*url="([^"]*)".*&gt;`,
        "gm"
    );

    // Used to ensure that the root element is a DIV so its produce valid HTML
    // This avoid some strange behaviours on the preview
    const wrapInDivRegex = new RegExp(
        `<([A-Z][A-Z0-9]*)[^>]*data-nodeid="([^"]*)"[^>]*>(((?!<\\1)[\\s\\S])*&lt;livewire:embed-link[^&gt;]*url="([^"]*)".*&gt;.*?(<\/\\1|))<\/\\1>`,
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
            const url = matches[1];
            const regexToReplace = new RegExp(
                `&lt;livewire:embed-link[^&gt;]*url="(${escapeRegExp(
                    url
                )})".*&gt;`,
                "gm"
            );
            const embed = getEmbedLinkHtml(url);

            replacemenent = replacemenent.replace(regexToReplace, embed);
        }
    }

    return replacemenent;
};

const addEmbedLinkMarkdownCommand = (markdownEditor, url, caption = "") => {
    if (!url) {
        return;
    }

    const codeMirrorEditor = markdownEditor.getEditor();
    const rangeFrom = codeMirrorEditor.getCursor("from");
    const rangeTo = codeMirrorEditor.getCursor("to");
    const text = getEmbedLinkTag(url, caption);

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

const embedLinkPlugin = (editor, menuIndex, svgIcon) => {
    editor.eventManager.listen(
        "convertorAfterMarkdownToHtmlConverted",
        convertMarkdownToHtml
    );

    if (!editor.isViewer() && editor.getUI().name === "default") {
        editor.addCommand("markdown", {
            name: "embedlink",
            exec: addEmbedLinkMarkdownCommand,
        });
    }

    initPopup(editor, menuIndex, svgIcon);
};

export default embedLinkPlugin;
