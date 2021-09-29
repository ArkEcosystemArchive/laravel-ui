<?php

declare(strict_types=1);

namespace ARKEcosystem\CommonMark\Extensions\Highlighter;

use League\CommonMark\Block\Element\AbstractBlock;
use League\CommonMark\Block\Element\FencedCode;
use League\CommonMark\Block\Renderer\BlockRendererInterface;
use League\CommonMark\Block\Renderer\FencedCodeRenderer as BaseFencedCodeRenderer;
use League\CommonMark\ElementRendererInterface;
use League\CommonMark\HtmlElement;
use League\CommonMark\Util\Xml;

final class FencedCodeRenderer implements BlockRendererInterface
{
    /** @var \ARKEcosystem\CommonMark\Extensions\Highlighter\CodeBlockHighlighter */
    private $highlighter;

    /** @var \League\CommonMark\Block\Renderer\FencedCodeRenderer */
    private $baseRenderer;

    public function __construct()
    {
        $this->highlighter  = new CodeBlockHighlighter();
        $this->baseRenderer = new BaseFencedCodeRenderer();
    }

    public function render(AbstractBlock $block, ElementRendererInterface $htmlRenderer, $inTightList = false)
    {
        $element = $this->baseRenderer->render($block, $htmlRenderer, $inTightList);

        $this->configureLineNumbers($element);

        $element->setContents(
            $this->highlighter->highlight(
                $element->getContents(),
                $this->getSpecifiedLanguage($block)
            )
        );

        $container = new HtmlElement('div', ['class' => 'p-4 mb-6 rounded-xl bg-theme-secondary-800 overflow-x-auto']);
        $container->setContents($element);

        return $container;
    }

    private function configureLineNumbers(HtmlElement $element): void
    {
        $codeBlockWithoutTags = strip_tags($element->getContents());
        $contents             = trim(htmlspecialchars_decode($codeBlockWithoutTags));

        if (count(explode("\n", $contents)) === 1) {
            $element->setAttribute('class', 'hljs');
        } else {
            $element->setAttribute('class', 'hljs line-numbers');
        }
    }

    private function getSpecifiedLanguage(FencedCode $block): ?string
    {
        $infoWords = $block->getInfoWords();

        /* @phpstan-ignore-next-line */
        if (empty($infoWords) || empty($infoWords[0])) {
            return null;
        }

        return Xml::escape($infoWords[0]);
    }
}
