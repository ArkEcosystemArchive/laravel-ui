<?php

namespace ARKEcosystem\UserInterface\Rules\Concerns;

use ARKEcosystem\UserInterface\Support\MarkdownParser;

trait ValidatesMarkdown
{
    private function getText(string | null $value): string
    {
        $html = $this->getHtml($value);
        $html = $this->removeExtraLineBreakInListItems($html);
        $html = $this->removeHeadersAnchors($html);

        return trim(strip_tags($html));
    }

    private function removeHeadersAnchors($html): string
    {
        $regex = '/<a\s?[^>]*[^>]*>#<\/a>/siU';
        return preg_replace($regex, '', $html);
    }

    private function removeExtraLineBreakInListItems($html): string
    {
        $regex = '/<(li)([^>]*)>(\n\r*)(.+?)(\n\r*)<\/\1>/mis';
        $substitution = '<$1$2>$4<\\/$1>';

        return preg_replace($regex, $substitution, $html);

    }

    private function getHtml(string | null $value): string
    {
        return MarkdownParser::full($value);
    }

}
