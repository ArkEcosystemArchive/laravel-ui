<?php

declare(strict_types=1);

use ARKEcosystem\Foundation\UserInterface\Rules\MarkdownWithContent;
use League\CommonMark\MarkdownConverterInterface;
use League\CommonMark\Node\Block\Document;
use League\CommonMark\Output\RenderedContent;
use Mockery\MockInterface;

it('handles null values', function () {
    $this->mock(MarkdownConverterInterface::class, function (MockInterface $mock) {
        $mock->shouldReceive('convertToHtml')
            ->andReturn(new RenderedContent(new Document(), ''));
    });

    $rule = new MarkdownWithContent();
    $this->assertFalse($rule->passes('markdown', null));
});

it('denies zero-width characters', function ($text) {
    $this->mock(MarkdownConverterInterface::class, function (MockInterface $mock) use ($text) {
        $mock->shouldReceive('convertToHtml')
            ->andReturn(new RenderedContent(new Document(), $text));
    });

    $rule = new MarkdownWithContent();
    $this->assertFalse($rule->passes('markdown', $text));
    $this->assertFalse($rule->passes('markdown', str_repeat($text, 10)));
})->with([
    '᠎',
    ' ',
    ' ',
    ' ',
    ' ',
    ' ',
    ' ',
    ' ',
    ' ',
    ' ',
    ' ',
    ' ',
    '​',
    ' ',
    ' ',
    '　',
    '﻿',
    ' ',
]);

it('accepts zero-width characters if has more content', function ($text) {
    $text = $text.' something ';

    $this->mock(MarkdownConverterInterface::class, function (MockInterface $mock) use ($text) {
        $mock->shouldReceive('convertToHtml')
            ->andReturn(new RenderedContent(new Document(), $text));
    });

    $rule = new MarkdownWithContent();
    $this->assertTrue($rule->passes('markdown', $text));
})->with([
    '᠎',
    ' ',
    ' ',
    ' ',
    ' ',
    ' ',
    ' ',
    ' ',
    ' ',
    ' ',
    ' ',
    ' ',
    '​',
    ' ',
    ' ',
    '　',
    '﻿',
    ' ',
]);

it('denies empty images as unique content', function () {
    $text = '![]()';

    $this->mock(MarkdownConverterInterface::class, function (MockInterface $mock) {
        $mock->shouldReceive('convertToHtml')->andReturn(new RenderedContent(new Document(), '<p><img src="" alt="" /></p>'));
    });

    $rule = new MarkdownWithContent();

    $this->assertFalse($rule->passes('markdown', $text));
});

it('accepts only one image with alt text', function () {
    $text = '![hello](http://myimage.png)';

    $this->mock(MarkdownConverterInterface::class, function (MockInterface $mock) {
        $mock->shouldReceive('convertToHtml')->andReturn(new RenderedContent(new Document(), '<p><div class="image-container"><img src="http://myimage.png" alt="hello" /><span class="image-caption">hello</span></div></p>'));
    });

    $rule = new MarkdownWithContent();

    $this->assertTrue($rule->passes('markdown', $text));
});

it('accepts only one image without alt text', function () {
    $text = '![](http://myimage.png)';

    $this->mock(MarkdownConverterInterface::class, function (MockInterface $mock) {
        $mock->shouldReceive('convertToHtml')->andReturn(new RenderedContent(new Document(), ' "<p><img src="http://myimage.png" alt="" /></p>\n"'));
    });

    $rule = new MarkdownWithContent();

    $this->assertTrue($rule->passes('markdown', $text));
});

it('denies markdown with just spaces', function () {
    // mix of return key, spaces and tabs
    $text = <<<'EOT'




EOT;

    $this->mock(MarkdownConverterInterface::class, function (MockInterface $mock) {
        $mock->shouldReceive('convertToHtml')->andReturn(new RenderedContent(new Document(), ''));
    });

    $rule = new MarkdownWithContent();

    $this->assertFalse($rule->passes('markdown', $text));
});

it('denies a single horizontal rule', function () {
    $text = '****';

    $this->mock(MarkdownConverterInterface::class, function (MockInterface $mock) {
        $mock->shouldReceive('convertToHtml')->andReturn(new RenderedContent(new Document(), '<hr />'));
    });

    $rule = new MarkdownWithContent();

    $this->assertFalse($rule->passes('markdown', $text));
});
