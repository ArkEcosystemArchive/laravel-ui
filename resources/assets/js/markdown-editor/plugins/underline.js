import { createButtonWithIcon } from "../utils/utils";

/**
 * Adds the menu button
 * @param {object} editor - Editor instance
 * @param {int} MenuIndex - index inside the menu
 * @param {object} svgIcon - Svg template
 * @ignore
 */
const addToolbarButton = (editor, menuIndex, svgIcon) => {
    const toolbar = editor.getUI().getToolbar();

    toolbar.insertItem(menuIndex, {
        type: "button",
        options: {
            el: createButtonWithIcon(svgIcon),
            name: "underline",
            className: "tui-underline",
            command: "underline",
            tooltip: "underline",
        },
    });

    return toolbar.getItem(menuIndex);
};

const isUnderlineSelected = (editor) => {
    const selectedText = editor.getSelectedText();

    if (editor.currentMode === "wysiwyg") {
        const parentNode = editor.getRange().startContainer.parentNode;
        return parentNode.tagName === "U" || parentNode.closest("U") !== null;
    }

    if (selectedText.startsWith("<ins>") && selectedText.endsWith("</ins>")) {
        return true;
    }

    const range = editor.getRange();
    const markdown = editor.getMarkdown();
    const markdownArr = markdown.split("\n");
    const line = markdownArr[range.start.line];

    const openingTagPosition = line.indexOf("<ins>") + 5;
    const closingTagPosition = line.indexOf("</ins>");

    if (openingTagPosition < 0 || closingTagPosition < 0) {
        return false;
    }

    if (
        range.start.ch >= openingTagPosition &&
        range.end.ch <= closingTagPosition
    ) {
        return true;
    }

    return false;
};

const markIconAsActiveIfNeccesary = (editor, toolbarButton) => {
    const isSelected = isUnderlineSelected(editor);

    if (isSelected) {
        if (!toolbarButton.el.className.includes("current")) {
            toolbarButton.el.className = `${toolbarButton.el.className} current`;
        }
    } else {
        toolbarButton.el.className = toolbarButton.el.className.replace(
            "current",
            ""
        );
    }
};

const underlinePlugin = (editor, menuIndex, svgIcon) => {
    editor.addCommand("markdown", {
        name: "underline",
        exec: (markdownEditor) => {
            const codeMirrorEditor = markdownEditor.getEditor();
            const rangeFrom = codeMirrorEditor.getCursor("from");

            const selectedText = codeMirrorEditor.getSelection();
            let text;

            if (
                selectedText.startsWith("<ins>") &&
                selectedText.endsWith("</ins>")
            ) {
                text = selectedText
                    .substr(5)
                    .substr(0, selectedText.length - 11);
            } else {
                text = `<ins>${selectedText}</ins>`;
            }

            codeMirrorEditor.replaceSelection(text, "start", 0);

            codeMirrorEditor.setSelection(
                {
                    line: rangeFrom.line,
                    ch: rangeFrom.ch,
                },
                {
                    line: rangeFrom.line,
                    ch: rangeFrom.ch + text.length,
                }
            );

            markdownEditor.focus();
        },
    });

    editor.addCommand("wysiwyg", {
        name: "underline",
        exec: (wysiwygEditor) => wysiwygEditor.getEditor().underline(),
    });

    const toolbarButton = addToolbarButton(editor, menuIndex, svgIcon);

    editor.eventManager.listen("click", () =>
        markIconAsActiveIfNeccesary(editor, toolbarButton)
    );
    editor.eventManager.listen("keyup", () =>
        markIconAsActiveIfNeccesary(editor, toolbarButton)
    );
    editor.eventManager.listen("focus", () =>
        markIconAsActiveIfNeccesary(editor, toolbarButton)
    );
};

export default underlinePlugin;
