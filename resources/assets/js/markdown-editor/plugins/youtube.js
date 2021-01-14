import { escapeRegExp, createPopup } from "../utils/utils";

const getYoutubeEmbedCode = (code) => {
    const attribs = {
        width: "100%",
        height: 480,
        src: `https://www.youtube.com/embed/${code}`,
        frameborder: 0,
        allowfullscreen: 1,
        showinfo: 0,
        controls: 0,
        autoplay: 0,
        modestbranding: 1,
        autohide: 1,
    };

    return `<iframe ${Object.keys(attribs)
        .map((a) => `${a}="${attribs[a]}"`)
        .join(" ")}></iframe>`;
};

const getYoutubeMarkdown = (code) => {
    return `![](youtube:${code})`;
};

const extractYoutubeId = (urlOrCode) => {
    const regExp = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#&?]*).*/;
    const match = urlOrCode.match(regExp);
    return match && match[7].length == 11 ? match[7] : urlOrCode;
};

const createPopupContent = (editor) => {
    const { i18n } = editor;

    const popupContent = document.createElement("div");

    popupContent.innerHTML = `
        <label for="value">Youtube URL or Video ID</label>
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
            const youtubeCode = extractYoutubeId(input.value);
            editor.exec("youtube", youtubeCode);
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
    const name = "youtube";
    const title = "Embed YouTube video";
    const tooltip = "YouTube";

    const popupContent = createPopupContent(editor);

    createPopup(editor, name, menuIndex, svgIcon, popupContent, title, tooltip);
};

const convertHtmlToMarkdown = (html) => {
    const regex = new RegExp(`<img\\s+[^>]*src="youtube:([^"]*)"[^>]*>`, "gm");

    // Used to ensure that the root element is a DIV so its produce valid HTML
    // This avoid some strange behaviours on the preview
    const wrapInDivRegex = new RegExp(
        `<([A-Z][A-Z0-9]*)[^>]*data-nodeid="([^"]*)"[^>]*>(((?!<\\1)[\\s\\S])*<img\\s+[^>]*src="youtube:[^"]*"[^>]*>.*?(<\/\\1|))<\/\\1>`,
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
            const youtubeCode = matches[1];
            const regexToReplace = new RegExp(
                `<img\\s+[^>]*src="youtube:(${escapeRegExp(
                    youtubeCode
                )})"[^>]*>`,
                "gm"
            );
            const embed = getYoutubeEmbedCode(youtubeCode);

            replacemenent = replacemenent.replace(regexToReplace, embed);
        }
    }

    return replacemenent;
};

const convertMarkdownToHtml = (markdown) => {
    const regex = new RegExp(
        `<iframe[^>]*src\\s*=\\s*"?https?:\/\/[^\\s"\/]*youtube.com\/embed\/((?:[^\\s"]*)?)"?[^>]*>.*?<\/iframe>`,
        "gm"
    );
    let matches;

    let replacemenent = markdown;
    while ((matches = regex.exec(markdown)) !== null) {
        if (matches.length && matches.length >= 1) {
            const youtubeCode = matches[1];
            const regexToReplace = new RegExp(
                `<iframe[^>]*src\\s*=\\s*"?https?:\/\/[^\\s"\/]*youtube.com\/embed\/(${escapeRegExp(
                    youtubeCode
                )})"?[^>]*>.*?<\/iframe>`,
                "gm"
            );
            const code = getYoutubeMarkdown(youtubeCode);

            replacemenent = replacemenent.replace(regexToReplace, code);
        }
    }

    return replacemenent;
};

const addYoutubeMarkdownCommand = (markdownEditor, code) => {
    if (!code) {
        return;
    }

    const codeMirrorEditor = markdownEditor.getEditor();

    const rangeFrom = codeMirrorEditor.getCursor("from");
    const rangeTo = codeMirrorEditor.getCursor("to");
    const text = getYoutubeMarkdown(code);

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

const addYoutubeHtmlCommand = (wysiwygEditor, code) => {
    if (!code) {
        return;
    }

    const squireExtension = wysiwygEditor.getEditor();
    squireExtension.insertHTML(getYoutubeEmbedCode(code));
};

const youtubePlugin = (editor, menuIndex, svgIcon) => {
    editor.eventManager.listen(
        "convertorAfterMarkdownToHtmlConverted",
        convertHtmlToMarkdown
    );

    editor.eventManager.listen(
        "convertorAfterHtmlToMarkdownConverted",
        convertMarkdownToHtml
    );

    if (!editor.isViewer() && editor.getUI().name === "default") {
        editor.addCommand("markdown", {
            name: "youtube",
            exec: addYoutubeMarkdownCommand,
        });

        editor.addCommand("wysiwyg", {
            name: "youtube",
            exec: addYoutubeHtmlCommand,
        });
    }

    initPopup(editor, menuIndex, svgIcon);
};

export default youtubePlugin;
