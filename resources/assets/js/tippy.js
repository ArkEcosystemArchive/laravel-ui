import tippy from "tippy.js";
import "tippy.js/dist/tippy.css";

const visibleTooltips = [];

/** Enable tooltips for components with this data attribute, and global config options */
const tooltipSettings = {
    trigger: "mouseenter focus",
    duration: 0,
    onShown: (instance) => {
        visibleTooltips.push(instance);
    },
    onHidden: (instance,e) => {
        const index = visibleTooltips.findIndex(i => i.id === instance.id);
        if (index >= 0) {
            visibleTooltips.splice(index, 1);
        }
    }
}

tippy("[data-tippy-content]", tooltipSettings);

tippy("[data-tippy-hover]", {
    ...tooltipSettings,
    touch: "hold",
    trigger: "mouseenter",
    content: (reference) => reference.dataset.tippyHover,
});

document.addEventListener('scroll', () => visibleTooltips.forEach((instance) => instance.hide(0)));

window.initClipboard = () => {
    tippy(".clipboard", {
        trigger: "click",
        content: (reference) => reference.getAttribute("tooltip-content"),
        onShow(instance) {
            setTimeout(() => {
                instance.hide();
            }, 3000);
        },
    });
};

if (typeof Livewire !== "undefined") {
    Livewire.hook("message.processed", (message, component) => {
        tippy(component.el.querySelectorAll("[data-tippy-content]"), {
            trigger: "mouseenter focus",
            duration: 0,
        });

        tippy(component.el.querySelectorAll("[data-tippy-hover]"), {
            touch: "hold",
            trigger: "mouseenter",
            content: (reference) => reference.dataset.tippyHover,
            duration: 0,
        });
    });
}

window.tippy = tippy;
