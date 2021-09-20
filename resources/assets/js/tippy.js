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
    onHidden: (instance, e) => {
        const index = visibleTooltips.findIndex((i) => i.id === instance.id);
        if (index >= 0) {
            visibleTooltips.splice(index, 1);
        }
    },
};

const initTippy = (parentEl = document.body) => {
    tippy(parentEl.querySelectorAll("[data-tippy-content]"), tooltipSettings);

    tippy(parentEl.querySelectorAll("[data-tippy-hover]", {
        ...tooltipSettings,
        touch: "hold",
        trigger: "mouseenter",
        content: (reference) => reference.dataset.tippyHover,
    }));
}

initTippy();

window.initTippy = initTippy;

document.addEventListener("scroll", () =>
    visibleTooltips.forEach((instance) => instance.hide(0))
);

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
    Livewire.hook("message.received", (message, component) => {
        component.el
            .querySelectorAll("[data-tippy-content], [data-tippy-hover]")
            .forEach((el) => {
                if (!el._tippy) {
                    console.error("Tippy tooltip instance not found. Ensure all tippy instances are properly initialized.", el);
                    return;
                }

                el._tippy.destroy();
            });
    });

    Livewire.hook("message.processed", (message, component) => {
        initTippy(component.el);
    });
}

window.tippy = tippy;
