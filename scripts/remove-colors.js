const fs = require('fs');
const filePath = './resources/assets/icons/';
const files = fs.readdirSync(filePath);

for (const file of files) {

    if (!file.endsWith('.svg')) {
        continue;
    }

    const oldContent = fs.readFileSync(`${filePath}${file}`).toString();
    fs.writeFileSync(`${filePath}${file}`, oldContent.replace(/#[0-9a-f]{6}/, 'currentColor'));
}