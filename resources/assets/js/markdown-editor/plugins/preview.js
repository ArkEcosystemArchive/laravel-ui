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
            el: createButtonWithIcon(svgIcon, "custom"),
            name: "preview",
            className: "tui-preview",
            command: "preview",
            tooltip: "Toggle Preview",
        },
    });

    return toolbar.getItem(menuIndex);
};

const previewPlugin = (editor, menuIndex, svgIcon, height = "600px") => {
    const button = addToolbarButton(editor, menuIndex, svgIcon);

    editor.addCommand("markdown", {
        name: "preview",
        exec: () => {
            if (editor.getCurrentPreviewStyle() === "vertical") {
                editor.changePreviewStyle("tab");
                button.el.className = button.el.className.replace(
                    "current",
                    ""
                );
                editor.height(height);
            } else {
                button.el.className = `${button.el.className} current`;
                editor.changePreviewStyle("vertical");

                const pageWidth = document.documentElement.clientWidth;

                if (pageWidth <= 768) {
                    editor.height(`${parseInt(height, 10) * 2}px`);
                } else {
                    editor.height(height);
                }
            }
        },
    });
};

export default previewPlugin;
