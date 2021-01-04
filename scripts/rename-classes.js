const slugify = require('@sindresorhus/slugify');
const fs = require('fs');
const filePath = './resources/assets/icons/';
const files = fs.readdirSync(filePath);

for (const file of files) {

    if (!file.endsWith('.svg')) {
        continue;
    }

    const oldClass = 'st';
    const newClass = slugify(file.replace('.svg', '')) + '-st';
    const oldContent = fs.readFileSync(`${filePath}${file}`).toString();

    // Skip files that don't have `.st` style references
    if (!/\.st\d+/.test(oldContent)) {
        continue;
    }

    let newContent = oldContent;

    for (let i = 0; i < 3; i++) {
        newContent = newContent.split(`${oldClass}${i}`).join(`${newClass}${i}`);
    }

    fs.writeFileSync(`${filePath}${file}`, newContent);
}