<?php

namespace ARKEcosystem\UserInterface\Support\Concerns;

use ARKEcosystem\UserInterface\Support\MarkdownParser;

trait HandlesMarkdown
{
    private function getText(string | null $value): string
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

    private function getHtml(string | null $value): string
    {
        return MarkdownParser::full($value);
    }

}
