<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\Providers;

use ARKEcosystem\Foundation\CommonMark\Extensions\Highlighter\FencedCodeRenderer;
use ARKEcosystem\Foundation\CommonMark\Extensions\Image\ImageRenderer;
use ARKEcosystem\Foundation\CommonMark\Extensions\Link\LinkRenderer;
use ARKEcosystem\Foundation\CommonMark\View\BladeEngine;
use ARKEcosystem\Foundation\CommonMark\View\BladeMarkdownEngine;
use ARKEcosystem\Foundation\CommonMark\View\FileViewFinder;
use GrahamCampbell\Markdown\MarkdownServiceProvider;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use League\CommonMark\Block\Element as BlockElement;
use League\CommonMark\Block\Element\FencedCode;
use League\CommonMark\Block\Parser as BlockParser;
use League\CommonMark\Block\Renderer as BlockRenderer;
use League\CommonMark\Inline\Element as InlineElement;
use League\CommonMark\Inline\Parser as InlineParser;
use League\CommonMark\Inline\Renderer as InlineRenderer;
use League\CommonMark\Normalizer\SlugNormalizer;

final class CommonMarkServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->register(MarkdownServiceProvider::class);

        $this->registerViewFinder();
    }

    /**
     * Boot services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->registerPublishers();

        $this->registerBladeEngines();

        $this->registerCommonMarkEnvironment();
    }

    /**
     * Register the publishers.
     *
     * @return void
     */
    public function registerPublishers(): void
    {
        $this->publishes([
            __DIR__.'/../../config/markdown.php' => config_path('markdown.php'),
        ], 'config');
    }

    /**
     * Boot services.
     *
     * @return void
     */
    private function registerBladeEngines(): void
    {
        $this->app->view->getEngineResolver()->register('blade', function (): BladeEngine {
            return new BladeEngine($this->app['blade.compiler'], $this->app['files']);
        });

        $this->app->view->getEngineResolver()->register('blademd', function (): BladeMarkdownEngine {
            return new BladeMarkdownEngine($this->app['blade.compiler'], $this->app['markdown']);
        });
    }

    /**
     * Register the view finder implementation.
     *
     * @return void
     */
    private function registerViewFinder(): void
    {
        $this->app->bind('view.finder', function ($app): FileViewFinder {
            return new FileViewFinder($app['files'], $app['config']['view.paths']);
        });
    }

    /**
     * Register the view finder implementation.
     *
     * @return void
     */
    private function registerCommonMarkEnvironment(): void
    {
        $environment = $this->app->get('markdown.environment');
        $environment->addBlockRenderer(FencedCode::class, new FencedCodeRenderer());

        $environment->addBlockParser(new BlockParser\BlockQuoteParser(), 70);
        $environment->addBlockParser(new BlockParser\ATXHeadingParser(), 60);
        $environment->addBlockParser(new BlockParser\FencedCodeParser(), 50);
        $environment->addBlockParser(new BlockParser\HtmlBlockParser(), 40);
        $environment->addBlockParser(new BlockParser\SetExtHeadingParser(), 30);
        $environment->addBlockParser(new BlockParser\ThematicBreakParser(), 20);
        $environment->addBlockParser(new BlockParser\ListParser(), 10);
        $environment->addBlockParser(new BlockParser\IndentedCodeParser(), -100);
        $environment->addBlockParser(new BlockParser\LazyParagraphParser(), -200);

        $environment->addInlineParser(new InlineParser\NewlineParser(), 200);
        $environment->addInlineParser(new InlineParser\BacktickParser(), 150);
        $environment->addInlineParser(new InlineParser\EscapableParser(), 80);
        $environment->addInlineParser(new InlineParser\EntityParser(), 70);
        $environment->addInlineParser(new InlineParser\AutolinkParser(), 50);
        $environment->addInlineParser(new InlineParser\HtmlInlineParser(), 40);
        $environment->addInlineParser(new InlineParser\CloseBracketParser(), 30);
        $environment->addInlineParser(new InlineParser\OpenBracketParser(), 20);
        $environment->addInlineParser(new InlineParser\BangParser(), 10);

        $environment->addBlockRenderer(BlockElement\BlockQuote::class, new BlockRenderer\BlockQuoteRenderer(), 0);
        $environment->addBlockRenderer(BlockElement\Document::class, new BlockRenderer\DocumentRenderer(), 0);
        $environment->addBlockRenderer(BlockElement\FencedCode::class, new BlockRenderer\FencedCodeRenderer(), 0);
        $environment->addBlockRenderer(BlockElement\Heading::class, new BlockRenderer\HeadingRenderer(), 0);
        $environment->addBlockRenderer(BlockElement\HtmlBlock::class, new BlockRenderer\HtmlBlockRenderer(), 0);
        $environment->addBlockRenderer(BlockElement\IndentedCode::class, new BlockRenderer\IndentedCodeRenderer(), 0);
        $environment->addBlockRenderer(BlockElement\ListBlock::class, new BlockRenderer\ListBlockRenderer(), 0);
        $environment->addBlockRenderer(BlockElement\ListItem::class, new BlockRenderer\ListItemRenderer(), 0);
        $environment->addBlockRenderer(BlockElement\Paragraph::class, new BlockRenderer\ParagraphRenderer(), 0);
        $environment->addBlockRenderer(BlockElement\ThematicBreak::class, new BlockRenderer\ThematicBreakRenderer(), 0);

        // $environment->addInlineRenderer(InlineElement\Code::class, new InlineRenderer\CodeRenderer(), 0);
        $environment->addInlineRenderer(InlineElement\Emphasis::class, new InlineRenderer\EmphasisRenderer(), 0);
        $environment->addInlineRenderer(InlineElement\HtmlInline::class, new InlineRenderer\HtmlInlineRenderer(), 0);
        $environment->addInlineRenderer(InlineElement\Image::class, new ImageRenderer(), 0);
        $environment->addInlineRenderer(InlineElement\Newline::class, new InlineRenderer\NewlineRenderer(), 0);
        $environment->addInlineRenderer(InlineElement\Strong::class, new InlineRenderer\StrongRenderer(), 0);
        $environment->addInlineRenderer(InlineElement\Text::class, new InlineRenderer\TextRenderer(), 0);

        $inlineRenderers = array_merge([
            InlineElement\Emphasis::class   => InlineRenderer\EmphasisRenderer::class,
            InlineElement\HtmlInline::class => InlineRenderer\HtmlInlineRenderer::class,
            InlineElement\Image::class      => ImageRenderer::class,
            InlineElement\Link::class       => LinkRenderer::class,
            InlineElement\Newline::class    => InlineRenderer\NewlineRenderer::class,
            InlineElement\Strong::class     => InlineRenderer\StrongRenderer::class,
            InlineElement\Text::class       => InlineRenderer\TextRenderer::class,
        ], Config::get('markdown.inlineRenderers', []));

        foreach ($inlineRenderers as $interface => $implementation) {
            $environment->addInlineRenderer($interface, resolve($implementation), 0);
        }

        $environment->mergeConfig([
            'external_link' => [
                'internal_hosts'     => config('app.url'),
                'open_in_new_window' => true,
                'html_class'         => 'external-link',
                'nofollow'           => '',
                'noopener'           => 'external',
                'noreferrer'         => 'external',
            ],
            'heading_permalink' => [
                'html_class'      => 'heading-permalink',
                'id_prefix'       => 'user-content',
                'insert'          => 'before',
                'title'           => 'Permalink',
                'symbol'          => '#',
                'slug_normalizer' => new SlugNormalizer(),
            ],
        ]);
    }
}
