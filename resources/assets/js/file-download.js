window.fileDownload = () => {
    return {
        save: function (filename, data, dataType, extension) {
            let blob = new Blob([data], { type: dataType });

            if (window.navigator.msSaveOrOpenBlob) {
                window.navigator.msSaveBlob(blob, `${filename}.${extension}`);
            } else {
                let elem = window.document.createElement("a");
                elem.href = window.URL.createObjectURL(blob);
                elem.download = `${filename}.${extension}`;
                document.body.appendChild(elem);
                elem.click();
                document.body.removeChild(elem);
            }
        },
    };
};
