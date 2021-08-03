<?php

namespace ARKEcosystem\UserInterface\Support\Concerns;

use ARKEcosystem\UserInterface\Support\MarkdownParser;

trait ParsesMarkdown
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

    private function count(string | null $value): array
    {
        $text = $this->getText($value);

        return [
            'characters' => mb_strlen($text),
            'words' => str_word_count($text),
        ];
    }
}
