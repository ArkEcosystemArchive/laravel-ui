import "./css/style.css"; // Editor's Style

import Editor from "@toast-ui/editor";

import {
    simplecastPlugin,
    youtubePlugin,
    twitterPlugin,
    undoPlugin,
    redoPlugin,
    underlinePlugin,
    headingPlugin,
    previewPlugin,
    referencePlugin,
    alertPlugin,
    linkCollectionPlugin,
    embedLinkPlugin,
} from "./plugins/index.js";

import { extractTextFromHtml } from "./utils/utils.js";

const AVERAGE_WORDS_READ_PER_MINUTE = 200;

const MarkdownEditor = (height = null, toolbar = "basic", extraData = {}) => ({
    editor: null,
    toolbar: null,
    toolbarItems: null,
    showOverlay: false,
    charsCount: 0,
    wordsCount: 0,
    readMinutes: 0,
    height: height !== null ? height : "600px",
    toolbarItems: [
        // ...Undo & redo

        "divider",

        "bold",
        "italic",
        "strike",
        "quote",
        "divider",

        // ...Headers

        "divider",

        "ol",
        "ul",
        "table",
        "image",

        "divider",

        "link",
        "code",
        "codeblock",

        "divider",

        // ...Plugins

        "divider",

        // ...Preview, etc
    ],
    plugins:
        toolbar === "basic"
            ? ["preview", "redo", "undo"]
            : [
                  "preview",
                  "simplecast",
                  "twitter",
                  "youtube",
                  "linkcollection",
                  "heading1",
                  "heading2",
                  "heading3",
                  "heading4",
                  "heading5",
                  "heading6",
                  "underline",
                  "redo",
                  "undo",
                  "reference",
                  "alert",
                  "embedlink",
              ],
    init() {
        try {
            const { input } = this.$refs;

            this.editor = new Editor({
                el: this.$refs.editor,
                height: this.height,
                initialEditType: "markdown",
                usageStatistics: false,
                hideModeSwitch: true,
                previewStyle: "vertical",
                initialValue: input.value,
                events: {
                    change: () => this.onChangeHandler(),
                },
                toolbarItems: this.toolbarItems,
                plugins: this.getPlugins(),
            });

            this.editor.getCodeMirror().setOption("lineNumbers", true);

            this.toolbar = this.editor.getUI().getToolbar();

            this.toolbarItems = this.toolbar.getItems();

            this.addIconsToTheButtons();

            this.initOverlay();

            this.updatePreviewClasses();

            this.removeScrollSyncButton();
        } catch (error) {
            alert("Something went wrong!");
            console.error(error);
        }
    },
    removeScrollSyncButton() {
        const scrollButton = this.editor
            .getUI()
            .el.querySelector(".tui-scrollsync");
        scrollButton.previousSibling.remove();
        scrollButton.remove();
    },
    getPlugins() {
        const {
            iconH1,
            iconH2,
            iconH3,
            iconH4,
            iconH5,
            iconH6,
            iconYoutube,
            iconTwitter,
            iconPodcast,
            iconUndo,
            iconUnderline,
            iconRedo,
            iconPreview,
            iconReference,
            iconAlert,
            iconLinkcollection,
            iconEmbedLink,
        } = this.$refs;

        const buttonIndex = this.toolbarItems.length;

        const plugins = {
            alert: (editor) => alertPlugin(editor, buttonIndex, iconAlert),
            preview: (editor) =>
                previewPlugin(editor, buttonIndex, iconPreview),
            reference: (editor) =>
                referencePlugin(editor, buttonIndex, iconReference),
            linkcollection: (editor) =>
                linkCollectionPlugin(
                    editor,
                    buttonIndex - 1,
                    iconLinkcollection
                ),
            youtube: (editor) =>
                youtubePlugin(editor, buttonIndex - 1, iconYoutube),
            simplecast: (editor) =>
                simplecastPlugin(editor, buttonIndex - 1, iconPodcast),
            twitter: (editor) =>
                twitterPlugin(editor, buttonIndex - 1, iconTwitter),
            embedlink: (editor) =>
                embedLinkPlugin(editor, buttonIndex - 1, iconEmbedLink),
            heading6: (editor) =>
                headingPlugin(editor, buttonIndex - 11, iconH6, 6),
            heading5: (editor) =>
                headingPlugin(editor, buttonIndex - 11, iconH5, 5),
            heading4: (editor) =>
                headingPlugin(editor, buttonIndex - 11, iconH4, 4),
            heading3: (editor) =>
                headingPlugin(editor, buttonIndex - 11, iconH3, 3),
            heading2: (editor) =>
                headingPlugin(editor, buttonIndex - 11, iconH2, 2),
            heading1: (editor) =>
                headingPlugin(editor, buttonIndex - 11, iconH1, 1),
            underline: (editor) =>
                underlinePlugin(editor, buttonIndex - 15, iconUnderline),
            redo: (editor) => redoPlugin(editor, 0, iconRedo),
            undo: (editor) => undoPlugin(editor, 0, iconUndo),
        };

        Object.keys(plugins).forEach((pluginName) => {
            if (!this.plugins.includes(pluginName)) {
                delete plugins[pluginName];
            }
        });

        return Object.values(plugins);
    },
    addIconsToTheButtons() {
        const {
            iconBold,
            iconItalic,
            iconStrike,
            iconQuote,
            iconOl,
            iconUl,
            iconTable,
            iconImage,
            iconLink,
            iconCode,
            iconCodeblock,
        } = this.$refs;

        const buttons = [
            { name: "italic", icon: iconItalic },
            { name: "bold", icon: iconBold },
            { name: "strike", icon: iconStrike },
            { name: "quote", icon: iconQuote },
            { name: "ol", icon: iconOl },
            { name: "ul", icon: iconUl },
            { name: "table", icon: iconTable },
            { name: "image", icon: iconImage },
            { name: "link", icon: iconLink },
            { name: "code", icon: iconCode },
            { name: "codeblock", icon: iconCodeblock },
        ];

        buttons.map(({ name, icon }) => {
            const button = this.toolbarItems.find((i) =>
                i.className.includes(`tui-${name}`)
            );
            if (button) {
                button.el.innerHTML = icon.innerHTML;
            }
        });
    },
    updatePreviewClasses() {
        const ui = this.editor.getUI();

        ui.el.querySelector(".tui-editor-contents").className =
            "tui-editor-contents documentation-content text-theme-secondary-700";
    },
    initOverlay() {
        this.editor.eventManager.addEventType("popupShown");
        this.editor.eventManager.addEventType("popupHidden");
        this.editor.eventManager.listen(
            "popupShown",
            () => (this.showOverlay = true)
        );
        this.editor.eventManager.listen(
            "popupHidden",
            () => (this.showOverlay = false)
        );

        this.editor.getUI()._popups.forEach((popup) => {
            popup.customEventManager.on(
                "shown",
                () => (this.showOverlay = true)
            );
            popup.customEventManager.on(
                "hidden",
                () => (this.showOverlay = false)
            );
        });
    },
    onChangeHandler() {
        const { input } = this.$refs;

        input.value = this.editor.getMarkdown();

        const text = extractTextFromHtml(this.editor.getHtml());

        this.charsCount = text.length;
        this.wordsCount = text.trim().split(/\s+/).length;
        this.readMinutes = Math.round(
            this.wordsCount / AVERAGE_WORDS_READ_PER_MINUTE
        );

        const event = new Event("input", {
            bubbles: true,
            cancelable: true,
        });

        input.dispatchEvent(event);
    },

    ...extraData,
});

export default MarkdownEditor;
