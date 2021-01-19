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
            name: "undo",
            className: "tui-undo",
            command: "undo",
            tooltip: "Undo",
        },
    });
};

const undoPlugin = (editor, menuIndex, svgIcon) => {
    editor.addCommand("markdown", {
        name: "undo",
        exec: (wysiwygEditor) => wysiwygEditor.getEditor().undo(),
    });

    addToolbarButton(editor, menuIndex, svgIcon);
};

export default undoPlugin;
