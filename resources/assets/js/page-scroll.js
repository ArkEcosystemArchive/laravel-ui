window.scrollToQuery = (selector) => {
    const navbar = document.querySelector("#navbar");

    window.scrollTo({
        top: document.querySelector(selector).offsetTop - (navbar ? navbar.clientHeight : 0),
        behavior: "smooth",
    });
};
