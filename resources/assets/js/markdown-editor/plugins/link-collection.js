import { createPopup } from "../utils/utils";

// Based on `https://github.com/ArkEcosystem/ark.dev/blob/develop/resources/views/components/link-collection.blade.php`
const getLinkCollectionHtml = (links) => {
    return `<div class="link-collection grid gap-x-3 grid-cols-1 grid-flow-row sm:grid-cols-2 lg:grid-cols-3">
    ${links
        .map(
            (link) => `<div class="py-1">
        <a href="javascript:;" class="flex items-center justify-between px-2 py-3 w-full transition-default text-theme-primary-600 hover:bg-theme-primary-100 hover:text-theme-primary-700 rounded">
            <span>${link.name}</span>
            <svg class="fill-current h-6 w-6" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" x="0" y="0" viewBox="0 0 13 24" xml:space="preserve"><path d="M12.2 12.5H1m7.5-3.8l3.7 3.8-3.7 3.7" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg>
        </a>
    </div>`
        )
        .join("\n")}
</div>`;
};

const getLinkCollectionTag = (links) => {
    return `<x-link-collection
    :links="[
        ${links
            .map(
                (link) =>
                    `['path' => '${link.path}', 'name' => '${link.name}'],`
            )
            .join("\n        ")}
    ]"
/>`;
};

const initDynamicRows = (tbody, inputs, rowForm) => {
    inputs.forEach((input) => {
        const inputListener = () => {
            const allInputsHaveValue = Array.from(
                tbody.querySelectorAll("input")
            ).every((input) => !!input.value);

            if (allInputsHaveValue) {
                const row = document.createElement("tr");

                row.innerHTML = rowForm;

                tbody.append(row);

                const newInputs = Array.from(row.querySelectorAll("input"));

                initDynamicRows(tbody, newInputs, rowForm);
            }
        };

        const blurListener = (e) => {
            const parentRow = e.currentTarget.parentNode.parentNode;
            const lastRow = tbody.querySelector("tr:last-child");

            if (parentRow === lastRow) {
                return;
            }

            const rowInputs = Array.from(parentRow.querySelectorAll("input"));

            const anyOfTHeInputsOnTheRowHaveValue = rowInputs.every(
                (input) => !input.value
            );

            if (anyOfTHeInputsOnTheRowHaveValue) {
                parentRow.remove();
            }
        };

        input.addEventListener("input", inputListener);

        input.addEventListener("blur", blurListener);
    });
};

const initPopupForm = (editor, popupContent) => {
    const { i18n } = editor;

    const rowForm = `<td>
    <label for="name[]">Name</label>
    <input name="name[]" type="text" />
</td>
<td>
    <label for="path[]">Path</label>
    <input name="path[]" type="text" />
</td>`;

    const popupContentBody = `
    <table class="w-full">
        <tbody>
            ${rowForm}
        </tbody>
    </table>

    <div class="te-button-section">
        <button type="button" class="te-ok-button">${i18n.get("OK")}</button>
        <button type="button" class="te-close-button">${i18n.get(
            "Cancel"
        )}</button>
    </div>
`;

    popupContent.innerHTML = popupContentBody;

    const inputs = Array.from(popupContent.querySelectorAll("input"));
    const tbody = popupContent.querySelector("tbody");

    initDynamicRows(tbody, inputs, rowForm);

    popupContent
        .querySelector("button.te-ok-button")
        .addEventListener("click", () => {
            const rows = Array.from(popupContent.querySelectorAll("tr"));

            const values = rows
                .map((row) => {
                    const name = row.querySelector('input[name="name[]"]')
                        .value;
                    const path = row.querySelector('input[name="path[]"]')
                        .value;

                    return {
                        name,
                        path,
                    };
                })
                .filter((value) => value.name && value.path);

            editor.exec("linkcollection", values);

            initPopupForm(editor, popupContent);

            editor.eventManager.emit("closeAllPopup");
        });

    popupContent
        .querySelector("button.te-close-button")
        .addEventListener("click", () => {
            editor.eventManager.emit("closeAllPopup");
        });
};

const extractLinksFromPHPArray = (arr) => {
    const regex = /'path'[^=]*=>[^']*'([^']*)'[^']*'name'[^=]*=>[^']*'([^']*)'/g;

    let match;
    const links = [];

    while ((match = regex.exec(arr)) !== null) {
        links.push({
            name: match[2],
            path: match[1],
        });
    }

    return links;
};

const createPopupContent = (editor) => {
    const popupContent = document.createElement("div");

    initPopupForm(editor, popupContent);

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
    const name = "linkcollection";
    const title = "Link Collection";
    const tooltip = "Link Collection";

    const popupContent = createPopupContent(editor);

    createPopup(editor, name, menuIndex, svgIcon, popupContent, title, tooltip);
};

const convertMarkdownToHtml = (editor, html) => {
    // Since the plugin removes most of the data from the tag first I try to
    // extract the data directly from the markdown
    const markdown = editor.getMarkdown();
    const markdownRegex = new RegExp(
        `<x-link-collection(.+?)(:links="([^"]*)")(.+?)\\/>`,
        "gms"
    );

    const matchesInMarkdown = [];
    while ((matches = markdownRegex.exec(markdown)) !== null) {
        matchesInMarkdown.push(matches);
    }

    if (matchesInMarkdown.length === 0) {
        return;
    }

    // Used to ensure that the root element is a DIV so its produce valid HTML
    // This avoid some strange behaviours on the preview
    const wrapInDivRegex = new RegExp(
        `<([A-Z][A-Z0-9]*)[^>]*data-nodeid="([^"]*)"[^>]*>(((?!<\\1)[\\s\\S])*<x-link-collection.+?<\\/x-link-collection>.*?(<\/\\1|))<\/\\1>`,
        "gmsi"
    );
    const validHTML = html.replace(
        wrapInDivRegex,
        '<div data-nodeid="$2">$3</div>'
    );

    const regex = new RegExp(
        `<x-link-collection.+?<\\/x-link-collection>`,
        "gms"
    );

    let replacemenent = validHTML;
    let matches;
    let index = 0;
    while ((matches = regex.exec(replacemenent)) !== null) {
        if (matches.length && matches.length == 1) {
            const matchInMarkdown = matchesInMarkdown[index];
            const links = extractLinksFromPHPArray(matchInMarkdown[3]);

            const regexToReplace = new RegExp(
                `<x-link-collection.+?<\\/x-link-collection>`,
                "s"
            );

            const embed = getLinkCollectionHtml(links);
            replacemenent = replacemenent.replace(regexToReplace, embed);
        }
        index = index + 1;
    }

    return replacemenent;
};

const addLinkCollectionCommand = (markdownEditor, links) => {
    const codeMirrorEditor = markdownEditor.getEditor();
    const rangeFrom = codeMirrorEditor.getCursor("from");
    const rangeTo = codeMirrorEditor.getCursor("to");

    const text = getLinkCollectionTag(links);

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

const linkCollectionPlugin = (editor, menuIndex, svgIcon) => {
    editor.eventManager.listen(
        "convertorAfterMarkdownToHtmlConverted",
        (html) => convertMarkdownToHtml(editor, html)
    );

    if (!editor.isViewer() && editor.getUI().name === "default") {
        editor.addCommand("markdown", {
            name: "linkcollection",
            exec: addLinkCollectionCommand,
        });
    }

    initPopup(editor, menuIndex, svgIcon);
};

export default linkCollectionPlugin;
