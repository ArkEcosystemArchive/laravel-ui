const defaultTheme = require("tailwindcss/defaultTheme");

module.exports = {
    darkMode: "class",

    theme: {
        extend: {
            borderRadius: {
                "2.5xl": "1.25rem",
            },
            borderWidth: {
                3: "3px",
                6: "6px",
                20: "20px",
            },
            boxShadow: {
                "button-primary":
                    "2px 3px 10px 2px rgba(var(--theme-color-primary-rgb), 0.34)",
                "button-secondary":
                    "2px 3px 10px 2px rgba(var(--theme-color-primary-rgb), 0.34)",
                "lg-smooth":
                    "0 10px 15px -3px rgba(0, 0, 0, 0.025), 0 4px 6px -2px rgba(0, 0, 0, 0.025)",
                "header-smooth": " 0px 2px 10px 0px rgba(192, 200, 207, 0.22)",
                "header-smooth-dark": " 0px 2px 10px 0px rgba(18, 18, 19, .6)",
                "lg-dark":
                    "0 0px 25px -3px rgba(18, 18, 19, 0.7), 0 4px 15px 0px rgba(18, 18, 19, 0.7)",
                none: "none",
            },
            fontFamily: {
                sans: ["Inter", ...defaultTheme.fontFamily.sans],
                code: ["FiraMono"],
            },
            maxWidth: {
                "7xl": "80rem",
                "8xl": "85rem",
                "1/2": "50%",
                "2/3": "66%",
            },
            height: {
                "21": "5.25rem",
                "22": "5.5rem",
                "30": "7.5rem",
            },
            opacity: {
                "90": ".9",
            },
            width: {
                "120": "30rem",
            },
            zIndex: {
                "5": 5,
            },
            ringColor: {
                focus: "rgba(var(--theme-color-primary-rgb), 0.50)",
            },
            inset: {
                "13": "3.25rem",
            },
        },

        colors: {
            // Modals
            backdrop: "rgba(0, 0, 0, 0.75)",

            "color-background": "#f5f7f9",
            black: "#121213",
            white: "#ffffff",
            transparent: "transparent",

            // Tailwind overrides
            "theme-primary-50": "var(--theme-color-primary-50)",
            "theme-primary-100": "var(--theme-color-primary-100)",
            "theme-primary-200": "var(--theme-color-primary-200)",
            "theme-primary-300": "var(--theme-color-primary-300)",
            "theme-primary-400": "var(--theme-color-primary-400)",
            "theme-primary-500": "var(--theme-color-primary-500)",
            "theme-primary-600": "var(--theme-color-primary-600)",
            "theme-primary-700": "var(--theme-color-primary-700)",
            "theme-primary-800": "var(--theme-color-primary-800)",
            "theme-primary-900": "var(--theme-color-primary-900)",

            "theme-secondary-50": "var(--theme-color-secondary-50)",
            "theme-secondary-100": "var(--theme-color-secondary-100)",
            "theme-secondary-200": "var(--theme-color-secondary-200)",
            "theme-secondary-300": "var(--theme-color-secondary-300)",
            "theme-secondary-400": "var(--theme-color-secondary-400)",
            "theme-secondary-500": "var(--theme-color-secondary-500)",
            "theme-secondary-600": "var(--theme-color-secondary-600)",
            "theme-secondary-700": "var(--theme-color-secondary-700)",
            "theme-secondary-800": "var(--theme-color-secondary-800)",
            "theme-secondary-900": "var(--theme-color-secondary-900)",

            "theme-danger-50": "var(--theme-color-danger-50)",
            "theme-danger-100": "var(--theme-color-danger-100)",
            "theme-danger-200": "var(--theme-color-danger-200)",
            "theme-danger-300": "var(--theme-color-danger-300)",
            "theme-danger-400": "var(--theme-color-danger-400)",
            "theme-danger-500": "var(--theme-color-danger-500)",
            "theme-danger-600": "var(--theme-color-danger-600)",
            "theme-danger-700": "var(--theme-color-danger-700)",
            "theme-danger-800": "var(--theme-color-danger-800)",
            "theme-danger-900": "var(--theme-color-danger-900)",

            "theme-warning-50": "var(--theme-color-warning-50)",
            "theme-warning-100": "var(--theme-color-warning-100)",
            "theme-warning-200": "var(--theme-color-warning-200)",
            "theme-warning-300": "var(--theme-color-warning-300)",
            "theme-warning-400": "var(--theme-color-warning-400)",
            "theme-warning-500": "var(--theme-color-warning-500)",
            "theme-warning-600": "var(--theme-color-warning-600)",
            "theme-warning-700": "var(--theme-color-warning-700)",
            "theme-warning-800": "var(--theme-color-warning-800)",
            "theme-warning-900": "var(--theme-color-warning-900)",

            "theme-success-50": "var(--theme-color-success-50)",
            "theme-success-100": "var(--theme-color-success-100)",
            "theme-success-200": "var(--theme-color-success-200)",
            "theme-success-300": "var(--theme-color-success-300)",
            "theme-success-400": "var(--theme-color-success-400)",
            "theme-success-500": "var(--theme-color-success-500)",
            "theme-success-600": "var(--theme-color-success-600)",
            "theme-success-700": "var(--theme-color-success-700)",
            "theme-success-800": "var(--theme-color-success-800)",
            "theme-success-900": "var(--theme-color-success-900)",

            "theme-info-50": "var(--theme-color-info-50)",
            "theme-info-100": "var(--theme-color-info-100)",
            "theme-info-200": "var(--theme-color-info-200)",
            "theme-info-300": "var(--theme-color-info-300)",
            "theme-info-400": "var(--theme-color-info-400)",
            "theme-info-500": "var(--theme-color-info-500)",
            "theme-info-600": "var(--theme-color-info-600)",
            "theme-info-700": "var(--theme-color-info-700)",
            "theme-info-800": "var(--theme-color-info-800)",
            "theme-info-900": "var(--theme-color-info-900)",

            "theme-hint-50": "var(--theme-color-hint-50)",
            "theme-hint-100": "var(--theme-color-hint-100)",
            "theme-hint-200": "var(--theme-color-hint-200)",
            "theme-hint-300": "var(--theme-color-hint-300)",
            "theme-hint-400": "var(--theme-color-hint-400)",
            "theme-hint-500": "var(--theme-color-hint-500)",
            "theme-hint-600": "var(--theme-color-hint-600)",
            "theme-hint-700": "var(--theme-color-hint-700)",
            "theme-hint-800": "var(--theme-color-hint-800)",
            "theme-hint-900": "var(--theme-color-hint-900)",
        },

        customForms: (theme) => ({
            DEFAULT: {
                select: {
                    icon: (
                        iconColor
                    ) => `<svg xmlns="http://www.w3.org/2000/svg" viewBox="-5 -5 16 15">
                        <path fill="${iconColor}" d="M3.9 5.4L.7 1.9C.4 1.6.4 1.1.7.8s.7-.3 1 0l2.8 2.9L7.2.8c.3-.3.7-.3 1 0s.3.8 0 1.1L5 5.4c-.3.3-.7.3-1.1 0h0z"/>
                    </svg>`,

                    iconColor: theme("colors.gray-700"),

                    "&:hover": {
                        iconColor: theme("colors.gray-600"),
                    },
                },
            },
        }),
    },
    variants: {
        boxShadow: ["dark", "responsive", "hover", "focus"],
        divideColor: ["dark", "responsive", "hover", "focus"],
        opacity: ["dark", "responsive", "hover", "focus"],
        display: ["dark", "responsive"],
        extend: {
            margin: ["focus-visible"],
            padding: ["focus-visible"],
            borderRadius: ["focus-visible"],
            borderWidth: ["focus-visible"],
            borderColor: ["focus-visible"],
            ringColor: ["focus-visible"],
            ringWidth: ["focus-visible"],
            textDecoration: ["focus-visible"],
            transitionProperty: ["focus-visible"],
            zIndex: ["focus-visible"],
        },
    },
    plugins: [require("@tailwindcss/ui")],
    purge: {
        mode: "all",
        content: [
            "./resources/views/**/*.blade.php",
            "./vendor/arkecosystem/ui/resources/views/**/*.blade.php",
            "./vendor/arkecosystem/fortify/resources/views/**/*.blade.php",
            "./vendor/arkecosystem/hermes/resources/views/**/*.blade.php",
            "./resources/js/**/*.js",
            "./resources/js/**/*.vue",
            "./app/**/*.php",
        ],
        options: {
            safelist: {
                standard: [
                    /horizontal$/,
                    /alert-/,
                    /swiper-/,
                    /toast-/,
                    /^hljs/,
                    /^media-library/,

                    /* pikaday classes */
                    /^pika-/,
                    /is-selected/,
                    /is-today/,
                    /is-disabled/,
                    /is-hidden/,
                    /is-bound/,
                ],

                deep: [/tippy-/, /\[data-expandable\]/],
            },
        },
    },
};
