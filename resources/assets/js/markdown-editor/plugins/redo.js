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
            name: "redo",
            className: "tui-redo",
            command: "redo",
            tooltip: "Redo",
        },
    });
};

const redoPlugin = (editor, menuIndex, svgIcon) => {
    editor.addCommand("markdown", {
        name: "redo",
        exec: (wysiwygEditor) => wysiwygEditor.getEditor().redo(),
    });

    editor.addCommand("wysiwyg", {
        name: "redo",
        exec: (markdownEditor) => markdownEditor.getEditor().redo(),
    });

    addToolbarButton(editor, menuIndex, svgIcon);
};

export default redoPlugin;
