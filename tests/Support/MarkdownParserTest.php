<?php

use ARKEcosystem\UserInterface\Support\MarkdownParser;
use League\CommonMark\MarkdownConverterInterface;

it('handles regular markdown', function () {
    $markdown = <<<MARKDOWN
* Item 1
* Item 2
* Item 4

Hello world!

**Bold**
MARKDOWN;

    $convertedHtml = <<<HTML
<ul>
<li>Item 1</li>
<li>Item 2</li>
<li>Item 4</li>
</ul>
<p>Hello world!</p>
<p><strong>Bold</strong></p>

HTML;

    $html = $convertedHtml;

    $this->mock(MarkdownConverterInterface::class)
        ->shouldReceive('convertToHtml')
        ->andReturn($convertedHtml);

    expect(MarkdownParser::basic($markdown))->toBe($html);
});

it('keeps the headings when using the `basic` parser', function () {
    $markdown = <<<MARKDOWN
### Heading 3
#### Heading 4

* Item 1
* Item 2
* Item 4

Hello world!

**Bold**
MARKDOWN;

    $convertedHtml = <<<HTML
<p>### Heading 3
#### Heading 4</p>
<ul>
<li>Item 1</li>
<li>Item 2</li>
<li>Item 4</li>
</ul>
<p>Hello world!</p>
<p><strong>Bold</strong></p>

HTML;

    $html = <<<HTML
<p>### Heading 3<br />
#### Heading 4</p>
<ul>
<li>Item 1</li>
<li>Item 2</li>
<li>Item 4</li>
</ul>
<p>Hello world!</p>
<p><strong>Bold</strong></p>

HTML;

    $this->mock(MarkdownConverterInterface::class)
        ->shouldReceive('convertToHtml')
        ->andReturn($convertedHtml);

    expect(MarkdownParser::basic($markdown))->toBe($html);
});


it('accepts headers when using the `full` parser', function () {
    $markdown = <<<MARKDOWN
### Heading 3
#### Heading 4

* Item 1
* Item 2
* Item 4

Hello world!

**Bold**
MARKDOWN;

    $convertedHtml = <<<HTML
<h3><a id="user-content-heading-3" href="#heading-3" name="heading-3" class="heading-permalink" aria-hidden="true" title="Permalink">#</a>Heading 3</h3>
<h4><a id="user-content-heading-4" href="#heading-4" name="heading-4" class="heading-permalink" aria-hidden="true" title="Permalink">#</a>Heading 4</h4>
<ul>
<li>Item 1</li>
<li>Item 2</li>
<li>Item 4</li>
</ul>
<p>Hello world!</p>
<p><strong>Bold</strong></p>

HTML;

    $html = <<<HTML
<h3><a id="user-content-heading-3" href="#heading-3" name=
"heading-3" class="heading-permalink" aria-hidden="true" title=
"Permalink">#</a>Heading 3</h3>
<h4><a id="user-content-heading-4" href="#heading-4" name=
"heading-4" class="heading-permalink" aria-hidden="true" title=
"Permalink">#</a>Heading 4</h4>
<ul>
<li>Item 1</li>
<li>Item 2</li>
<li>Item 4</li>
</ul>
<p>Hello world!</p>
<p><strong>Bold</strong></p>

HTML;

    $this->mock(MarkdownConverterInterface::class)
        ->shouldReceive('convertToHtml')
        ->andReturn($convertedHtml);

    expect(MarkdownParser::full($markdown))->toBe($html);
});


it('accepts `b` and `strong` tags', function () {
    $markdown = <<<MARKDOWN
<strong>Bold 1</strong>

<b>Bold 2</b>

**Bold3**
MARKDOWN;

    $convertedHtml = <<<HTML
<p><strong>Bold 1</strong></p>
<p><b>Bold 2</b></p>
<p><strong>Bold3</strong></p>

HTML;

    $html = $convertedHtml;

    $this->mock(MarkdownConverterInterface::class)
        ->shouldReceive('convertToHtml')
        ->andReturn($convertedHtml);

    expect(MarkdownParser::basic($markdown))->toBe($html);
});
