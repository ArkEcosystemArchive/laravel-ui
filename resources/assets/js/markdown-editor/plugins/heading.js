import { createButtonWithIcon } from "../utils/utils";

/**
 * Adds the menu button
 * @param {object} editor - Editor instance
 * @param {int} MenuIndex - index inside the menu
 * @param {object} svgIcon - Svg template
 * @param {Number} level - Heading level
 * @ignore
 */
const addToolbarButton = (editor, menuIndex, svgIcon, level) => {
    const event = `headingButton${level}Clicked`;

    const toolbar = editor.getUI().getToolbar();

    toolbar.insertItem(menuIndex, {
        type: "button",
        options: {
            el: createButtonWithIcon(svgIcon),
            name: `heading${level}`,
            className: "tui-heading",
            event: event,
            tooltip: `Heading ${level}`,
        },
    });

    editor.eventManager.addEventType(event);

    editor.eventManager.listen(event, () => {
        editor.exec("Heading", level);

        editor.focus();
    });

    return toolbar.getItem(menuIndex);
};

const guessCurrentHeadingLevel = (editor) => {
    const range = editor.getRange();
    const markdown = editor.getMarkdown();
    const markdownArr = markdown.split("\n");
    const line = markdownArr[range.start.line];

    if (line[0] !== "#") {
        return false;
    }

    let i = 0;
    let isAnchor = false;
    do {
        isAnchor = line[i] === "#";
        if (isAnchor) {
            i++;
        }
    } while (isAnchor && i < 6);

    return i || false;
};

const isHeadingSelected = (editor, level) => {
    if (editor.currentMode === "wysiwyg") {
        const parentNode = editor.getRange().startContainer.parentNode;
        return (
            parentNode.tagName === `H${level}` ||
            parentNode.closest(`H${level}`) !== null
        );
    }

    const currentLevel = guessCurrentHeadingLevel(editor);
    return currentLevel === level;
};

const markIconAsActiveIfNeccesary = (editor, toolbarButton, level) => {
    const isSelected = isHeadingSelected(editor, level);

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

const headingPlugin = (editor, menuIndex, svgIcon, level) => {
    const toolbarButton = addToolbarButton(editor, menuIndex, svgIcon, level);

    editor.eventManager.listen("click", () =>
        markIconAsActiveIfNeccesary(editor, toolbarButton, level)
    );
    editor.eventManager.listen("keyup", () =>
        markIconAsActiveIfNeccesary(editor, toolbarButton, level)
    );
    editor.eventManager.listen("focus", () =>
        markIconAsActiveIfNeccesary(editor, toolbarButton, level)
    );
};

export default headingPlugin;
