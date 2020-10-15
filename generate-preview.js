const fs = require("fs");
const glob = require("glob");
const color = "#3e9dff";

let html =
    '<html><head><style>svg { width: 25px; height: 25px; }</style></head><body><div style="padding: 10px; width: calc(100vw - 16px);"><div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(7rem, 1fr)); grid-gap: 1rem 1rem;">';

glob.sync("**/*.svg", { cwd: "./resources/assets/icons/" }).forEach((file) => {
    const contents = fs.readFileSync("./resources/assets/icons/" + file);
    html +=
        '<div style="display: flex; flex-direction: column; align-items: center; padding: 1rem; text-align: center; fill: ' +
        color +
        "; color: " +
        color +
        '">' +
        contents +
        '<span style="margin-top: 10px; word-break: break-word; color: #212225; ">' +
        file.split(".")[0] +
        "</span></div>";
});

html += "</div></div></body></html>";

fs.writeFile("icons.html", html, (error) =>
    error ? console.log(error) : console.log("written to icons.html")
);
