<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\CommonMark\Extensions\Table;

use ARKEcosystem\Foundation\CommonMark\Emoji;
use League\CommonMark\Block\Element\AbstractBlock;
use League\CommonMark\Block\Renderer\BlockRendererInterface;
use League\CommonMark\ElementRendererInterface;
use League\CommonMark\Extension\Table\Table;
use League\CommonMark\HtmlElement;

final class TableRenderer implements BlockRendererInterface
{
    public function render(AbstractBlock $block, ElementRendererInterface $htmlRenderer, bool $inTightList = false)
    {
        if (! $block instanceof Table) {
            throw new \InvalidArgumentException('Incompatible block type: '.get_class($block));
        }

        $attrs = $block->getData('attributes', []);

        $separator = $htmlRenderer->getOption('inner_separator', "\n");

        $children = $htmlRenderer->renderBlocks($block->children());

        $table = new HtmlElement('table', $attrs, $separator.\trim($children).$separator);

        try {
            $table->setContents(Emoji::convert($table->getContents()));
        } catch (\Throwable $th) {
            $table->setContents($table->getContents());
        }

        $container = new HtmlElement('div', ['class' => 'table-wrapper overflow-x-auto']);
        $container->setContents($table);

        return $container;
    }
}
