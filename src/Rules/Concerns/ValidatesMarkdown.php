<?php

namespace ARKEcosystem\UserInterface\Rules\Concerns;

use ARKEcosystem\UserInterface\Support\MarkdownParser;

trait ValidatesMarkdown
{
    private function getText($value): string
    {
        $html = $this->getHtml($value);

        $html = $this->removeHeadersAnchors($html);

        return trim(strip_tags($html));
    }

    private function removeHeadersAnchors($html): string
    {
        $regex = '/<a\s?[^>]*[^>]*>#<\/a>/siU';
        return preg_replace($regex, '', $html);
    }

    private function getHtml($value): string
    {
        return MarkdownParser::full($value);
    }

}
