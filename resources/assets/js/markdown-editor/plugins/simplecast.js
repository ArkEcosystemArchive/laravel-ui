import { escapeRegExp, createPopup } from "../utils/utils";

const getSimpleCastEmbedCode = (code) => {
    const attribs = {
        class: "w-full",
        frameborder: "no",
        scrolling: "no",
        src: `https://player.simplecast.com/${code}?dark=false`,
    };

    return `<iframe ${Object.keys(attribs)
        .map((a) => `${a}="${attribs[a]}"`)
        .join(" ")}></iframe>`;
};

const getSimplecastMarkdown = (code) => {
    return `![](simplecast:${code})`;
};

const extractSimplecastID = (urlOrCode) => {
    const regExp = /^.*simplecast.com\/(\b[0-9a-f]{8}\b-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-\b[0-9a-f]{12}\b)/;
    const match = urlOrCode.match(regExp);
    return match && match.length === 2 ? match[1] : urlOrCode;
};

const createPopupContent = (editor) => {
    const { i18n } = editor;

    const popupContent = document.createElement("div");

    popupContent.innerHTML = `
        <label for="value">Simplecast URL or ID</label>
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
            const simplecastCode = extractSimplecastID(input.value);
            editor.exec("simplecast", simplecastCode);
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
    const name = "simplecast";
    const title = "Embed Simplecast Podcast";
    const tooltip = "Simplecast";

    const popupContent = createPopupContent(editor);

    createPopup(editor, name, menuIndex, svgIcon, popupContent, title, tooltip);
};

const convertHtmlToMarkdown = (html) => {
    const regex = new RegExp(
        `<img\\s+[^>]*src="simplecast:([^"]*)"[^>]*>`,
        "gm"
    );

    // Used to ensure that the root element is a DIV so its produce valid HTML
    // This avoid some strange behaviours on the preview
    const wrapInDivRegex = new RegExp(
        `<([A-Z][A-Z0-9]*)[^>]*data-nodeid="([^"]*)"[^>]*>(((?!<\\1)[\\s\\S])*<img\\s+[^>]*src="simplecast:[^"]*"[^>]*>.*?(<\/\\1|))<\/\\1>`,
        "gmsi"
    );
    const validHTML = html.replace(
        wrapInDivRegex,
        '<div data-nodeid="$2">$3</div>'
    );

    let replacemenent = validHTML;
    let matches;
    while ((matches = regex.exec(validHTML)) !== null) {
        // This is necessary to avoid infinite loops with zero-width matches
        if (matches.index === regex.lastIndex) {
            regex.lastIndex++;
        }

        if (matches.length && matches.length >= 1) {
            const simplecastCode = matches[1];
            const regexToReplace = new RegExp(
                `<img\\s+[^>]*src="simplecast:(${escapeRegExp(
                    simplecastCode
                )})"[^>]*>`,
                "gm"
            );
            const embed = getSimpleCastEmbedCode(simplecastCode);

            replacemenent = replacemenent.replace(regexToReplace, embed);
        }
    }

    return replacemenent;
};

const convertMarkdownToHtml = (markdown) => {
    const regex = new RegExp(
        `<iframe[^>]*src="https?:\/\/player\.simplecast\.com\/(\\b[0-9a-f]{8}\\b-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-\\b[0-9a-f]{12}\\b)"?[^>]*>.*?<\/iframe>`,
        "gm"
    );
    let matches;

    let replacemenent = markdown;
    while ((matches = regex.exec(markdown)) !== null) {
        // This is necessary to avoid infinite loops with zero-width matches
        if (matches.index === regex.lastIndex) {
            regex.lastIndex++;
        }

        if (matches.length && matches.length >= 1) {
            const simplecastCode = matches[1];
            const regexToReplace = new RegExp(
                `<iframe[^>]*src="https?:\/\/player\.simplecast\.com\/(${escapeRegExp(
                    simplecastCode
                )})"?[^>]*>.*?<\/iframe>`,
                "gm"
            );
            const code = getSimplecastMarkdown(simplecastCode);

            replacemenent = replacemenent.replace(regexToReplace, code);
        }
    }

    return replacemenent;
};

const addSimplecastMarkdownCommand = (mde, code) => {
    if (!code) {
        return;
    }

    const cm = mde.getEditor();

    const rangeFrom = cm.getCursor("from");
    const rangeTo = cm.getCursor("to");
    const text = getSimplecastMarkdown(code);

    cm.replaceSelection(text, "start", 0);

    cm.setSelection(
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

    mde.focus();
};

const addSimmplecastHtmlCommand = (wwe, code) => {
    if (!code) {
        return;
    }

    const sq = wwe.getEditor();
    sq.insertHTML(getSimpleCastEmbedCode(code));
};

const simplecastPlugin = (editor, menuIndex, svgIcon) => {
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
            name: "simplecast",
            exec: addSimplecastMarkdownCommand,
        });

        editor.addCommand("wysiwyg", {
            name: "simplecast",
            exec: addSimmplecastHtmlCommand,
        });
    }

    initPopup(editor, menuIndex, svgIcon);
};

export default simplecastPlugin;
