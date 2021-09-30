<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\CommonMark\Extensions\Highlighter;

use League\CommonMark\Block\Element\AbstractBlock;
use League\CommonMark\Block\Renderer\BlockRendererInterface;
use League\CommonMark\Block\Renderer\IndentedCodeRenderer as BaseIndentedCodeRenderer;
use League\CommonMark\ElementRendererInterface;

final class IndentedCodeRenderer implements BlockRendererInterface
{
    /** @var \ARKEcosystem\Foundation\CommonMark\Extensions\Highlighter\CodeBlockHighlighter */
    private $highlighter;

    /** @var \League\CommonMark\Block\Renderer\IndentedCodeRenderer */
    private $baseRenderer;

    public function __construct()
    {
        $this->highlighter  = new CodeBlockHighlighter();
        $this->baseRenderer = new BaseIndentedCodeRenderer();
    }

    public function render(AbstractBlock $block, ElementRendererInterface $htmlRenderer, $inTightList = false)
    {
        $element = $this->baseRenderer->render($block, $htmlRenderer, $inTightList);

        $element->setContents(
            $this->highlighter->highlight($element->getContents())
        );

        return $element;
    }
}
