<?php

namespace Tests\Analysis;

use GrahamCampbell\Analyzer\AnalysisTrait;
use PHPUnit\Framework\TestCase;

/**
 * @coversNothing
 */
class AnalysisTest extends TestCase
{
    use AnalysisTrait;

    public function getPaths(): array
    {
        return [
            __DIR__.'/../../src',
            __DIR__.'/../../tests',
        ];
    }

    public function getIgnored(): array
    {
        return [
            'League\CommonMark\Block\Element',
            'League\CommonMark\Block\Parser',
            'League\CommonMark\Block\Renderer',
            'League\CommonMark\Inline\Element',
            'League\CommonMark\Inline\Parser',
            'League\CommonMark\Inline\Renderer',
            'Spatie\Snapshots\assertMatchesSnapshot',
        ];
    }
}
