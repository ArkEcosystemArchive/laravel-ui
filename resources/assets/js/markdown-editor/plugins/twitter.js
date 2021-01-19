import { escapeRegExp, createPopup } from "../utils/utils";

const twitterEmbedCache = {};

const getTwitterEmbedCode = (twitterID) => {
    return twitterEmbedCache[twitterID];
};

const getAndCacheTwitterEmbedCode = (twitterID) => {
    return new Promise((resolve, reject) => {
        if (twitterEmbedCache[twitterID]) {
            resolve(twitterEmbedCache[twitterID]);
            return;
        }

        return fetch(`/wysiwyg/twitter-embed-code?id=${twitterID}`)
            .then((response) => {
                if (response.status === 200) {
                    return response.text();
                }

                throw new Error(response.statusText);
            })
            .then((html) => {
                const tempWrapper = document.createElement("div");
                tempWrapper.innerHTML = html;
                tempWrapper.setAttribute("data-tweet-id", twitterID);
                twitterEmbedCache[twitterID] = tempWrapper.outerHTML;
                resolve(html);
            })
            .catch((error) => {
                reject(error);
            });
    });
};

const getMarkdownTwitterId = (tweetID) => {
    return Object.keys(twitterEmbedCache).find((key) => key.endsWith(tweetID));
};

const replaceTwitterEmbedCodeCacheWithTheIframe = (tweetID, iframe) => {
    const cacheKey = getMarkdownTwitterId(tweetID);
    twitterEmbedCache[cacheKey] = iframe.outerHTML;
};

const getTwitterMarkdown = (code) => {
    return `![](twitter:${code})`;
};

const extractTwitterCode = (urlOrCode) => {
    if (urlOrCode.startsWith("https://twitter.com")) {
        return urlOrCode.split("https://twitter.com/")[1];
    }

    return urlOrCode;
};

const createPopupContent = (editor) => {
    const { i18n } = editor;

    const popupContent = document.createElement("div");

    popupContent.innerHTML = `
        <label for="value">Tweet URL or ID</label>
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
        .addEventListener("click", async () => {
            const input = popupContent.querySelector('[name="value"]');
            const twitterCode = extractTwitterCode(input.value);
            // This function will cache the html so we can get it on the replacer function
            getAndCacheTwitterEmbedCode(twitterCode)
                .then(() => {
                    input.setAttribute("disabled", "disabled");
                    editor.exec("twitter", twitterCode);
                })
                .catch((error) => {
                    alert(
                        "Something went wrong! Ensure you are using a valid Tweet URL"
                    );
                    console.error(error);
                })
                .then(() => {
                    input.removeAttribute("disabled");
                    input.value = "";
                    editor.eventManager.emit("closeAllPopup");
                });
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
    const name = "twitter";
    const title = "Embed Tweet";
    const tooltip = "Embed Tweet";

    const popupContent = createPopupContent(editor);

    createPopup(editor, name, menuIndex, svgIcon, popupContent, title, tooltip);
};

const convertMarkdownToHtml = (html) => {
    const regex = new RegExp(
        `<img\\s+[^>]*src="twitter:([^"]*)"[^>]*>`,
        "gmsi"
    );

    // Used to ensure that the root element is a DIV so its produce valid HTML
    // This avoid some strange behaviours on the preview
    const wrapInDivRegex = new RegExp(
        `<([A-Z][A-Z0-9]*)[^>]*data-nodeid="([^"]*)"[^>]*>(((?!<\\1)[\\s\\S])*<img\\s+[^>]*src="twitter:[^"]*"[^>]*>.*?(<\/\\1|))<\/\\1>`,
        "gmsi"
    );
    const validHTML = html.replace(
        wrapInDivRegex,
        '<div data-nodeid="$2">$3</div>'
    );

    let matches;
    let replacemenent = validHTML;

    while ((matches = regex.exec(validHTML)) !== null) {
        if (matches.length === 2) {
            const twitterCode = matches[1];
            const regexToReplace = new RegExp(
                `<img\\s+[^>]*src="twitter:(${escapeRegExp(
                    twitterCode
                )})"[^>]*>`,
                "gm"
            );
            const embed = getTwitterEmbedCode(twitterCode);
            replacemenent = replacemenent.replace(regexToReplace, embed);
        }
    }

    return replacemenent;
};

const addTwitterMarkdownCommand = (markdownEditor, code) => {
    if (!code) {
        return;
    }

    const codeMirrorEditor = markdownEditor.getEditor();

    const rangeFrom = codeMirrorEditor.getCursor("from");
    const rangeTo = codeMirrorEditor.getCursor("to");
    const text = getTwitterMarkdown(code);

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

const appendTwitterScript = () => {
    const twitterScript = document.createElement("script");

    twitterScript.setAttribute(
        "src",
        "https://platform.twitter.com/widgets.js"
    );
    twitterScript.setAttribute("async", "async");

    document.body.appendChild(twitterScript);
};

const twitterPlugin = (editor, menuIndex, svgIcon) => {
    editor.eventManager.listen(
        "convertorAfterMarkdownToHtmlConverted",
        convertMarkdownToHtml
    );

    editor.eventManager.listen("stateChange", () => {
        if (typeof twttr === "undefined") {
            return;
        }

        const itemsToCovert = document.querySelectorAll("div[data-tweet-id]");
        if (!itemsToCovert.length) {
            return;
        }

        twttr.widgets.load().then(() => {
            document
                .querySelectorAll("iframe[data-tweet-id]")
                .forEach((iframe) => {
                    const tweetID = iframe.getAttribute("data-tweet-id");
                    replaceTwitterEmbedCodeCacheWithTheIframe(tweetID, iframe);
                });
        });
    });

    if (!editor.isViewer() && editor.getUI().name === "default") {
        editor.addCommand("markdown", {
            name: "twitter",
            exec: addTwitterMarkdownCommand,
        });
    }

    initPopup(editor, menuIndex, svgIcon);

    appendTwitterScript();
};

export default twitterPlugin;
