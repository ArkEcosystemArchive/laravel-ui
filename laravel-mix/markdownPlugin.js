const mix = require('laravel-mix');
const importCss = require('postcss-import');
const tailwindCss = require('tailwindcss');

class MarkdownPlugin {
    register(tailwindConfigFile = 'tailwind.config.js', ...args) {
        mix
            .js('vendor/arkecosystem/ui/resources/assets/js/markdown-editor/markdown-editor.js', 'public/js/markdown-editor.js')
            .postCss('vendor/arkecosystem/ui/resources/assets/css/markdown-editor.css', 'public/css', [importCss(), tailwindCss(tailwindConfigFile)])
    }

    webpackConfig(webpackConfig) {
        const  index = webpackConfig.plugins.findIndex(plugin => (plugin.constructor.name === 'WebpackNotifierPlugin' || plugin.options?.alwaysNotify !== undefined));

        webpackConfig.plugins[index].options.excludeWarnings = true;
        if (!webpackConfig.stats.warningsFilter) {
            webpackConfig.stats.warningsFilter = [];
        }

        webpackConfig.stats.warningsFilter.push(/@charset must precede all other statements/);
    }
}

mix.extend('markdown', new MarkdownPlugin());
