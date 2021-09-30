<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\CommonMark\Extensions\Highlighter;

use DomainException;

final class CodeBlockHighlighter
{
    /** @phpstan-ignore-next-line */
    public function highlight(string $codeBlock, ?string $language = null): string
    {
        if (str_contains($codeBlock, '<')) {
            preg_match('#<\s*?code\b[^>]*>(.*?)</code\b[^>]*>#s', $codeBlock, $matches);

            $codeBlock = $matches[1];
        } else {
            $codeBlock = trim(htmlspecialchars_decode(strip_tags($codeBlock)));
        }

        try {
            return vsprintf('<code class="hljs-copy language-%s">%s</code>', [$language, $codeBlock]);
        } catch (DomainException $e) {
            return $codeBlock;
        }
    }
}
