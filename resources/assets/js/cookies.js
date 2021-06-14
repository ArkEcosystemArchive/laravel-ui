window.cookies = () => {
    return {
        set(cookieName, value) {
            Cookies.noConflict().set(cookieName, value, { expires: 31 });
        },

        get(cookieName) {
            Cookies.noConflict().get(cookieName);
        },
    };
};
