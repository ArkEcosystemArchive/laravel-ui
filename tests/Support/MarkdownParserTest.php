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

it('accepts `ol` lists', function () {
    $markdown = <<<MARKDOWN
<ol>
    <li>Item 1</li>
  <li>Item 2</li>
    <li>Item 3</li>
</ol>

1. item a
2. item b
3. item c

MARKDOWN;

    $convertedHtml = <<<HTML
<ol>
    <li>Item 1</li>
<li>Item 2</li>
<li>Item 3</li>
</ol>
<ol>
<li>item a</li>
<li>item b</li>
<li>item c</li>
</ol>

HTML;

    $html = <<<HTML
<ol>
<li>Item 1</li>
<li>Item 2</li>
<li>Item 3</li>
</ol>
<ol>
<li>item a</li>
<li>item b</li>
<li>item c</li>
</ol>

HTML;

    $this->mock(MarkdownConverterInterface::class)
        ->shouldReceive('convertToHtml')
        ->andReturn($convertedHtml);

    expect(MarkdownParser::basic($markdown))->toBe($html);
});

it('accepts `ul` lists', function () {
    $markdown = <<<MARKDOWN
<ul>
    <li>Item 1</li>
  <li>Item 2</li>
    <li>Item 3</li>
</ul>

- item a
- item b
- item c

MARKDOWN;

    $convertedHtml = <<<HTML
<ul>
    <li>Item 1</li>
<li>Item 2</li>
<li>Item 3</li>
</ul>
<ul>
<li>item a</li>
<li>item b</li>
<li>item c</li>
</ul>

HTML;

    $html = <<<HTML
<ul>
<li>Item 1</li>
<li>Item 2</li>
<li>Item 3</li>
</ul>
<ul>
<li>item a</li>
<li>item b</li>
<li>item c</li>
</ul>

HTML;

    $this->mock(MarkdownConverterInterface::class)
        ->shouldReceive('convertToHtml')
        ->andReturn($convertedHtml);

    expect(MarkdownParser::basic($markdown))->toBe($html);
});

it('handles html paragraphs and line breaks', function () {
    $markdown = <<<MARKDOWN
<p>
custom paragraph
with some line breaks


and even double breaks
</p>


<p>Single line</p>

<p>Paragraph with <br /> explicit line breaks

Regular markdown paragraph

regular markdown...
...line break

MARKDOWN;

    $convertedHtml = <<<HTML
<p><br /> custom paragraph<br /> with some line breaks<br /> <br /> <br /> and even double breaks<br /></p>
<p>Single line</p>
<p>Paragraph with <br /> explicit line breaks
<p>Regular markdown paragraph</p>
<p>regular markdown…
…line break</p>

HTML;

    $html = <<<HTML
<p><br />
custom paragraph<br />
with some line breaks<br />
<br />
<br />
and even double breaks<br /></p>
<p>Single line</p>
<p>Paragraph with<br />
explicit line breaks</p>
<p>Regular markdown paragraph</p>
<p>regular markdown…<br />
…line break</p>

HTML;

    $this->mock(MarkdownConverterInterface::class)
        ->shouldReceive('convertToHtml')
        ->andReturn($convertedHtml);

    expect(MarkdownParser::basic($markdown))->toBe($html);
});

it('handles line breaks inside html tags', function () {
    $markdown = <<<MARKDOWN
<strong>a text with multiple
line breaks


inside a tag</strong>

<ul>
<li>list items with a line

break
</li>
<li>regular</li>

</ul>

MARKDOWN;

    $convertedHtml = <<<HTML
<p><strong>a text with multiple<br />line breaks<br /><br /><br />inside a tag</strong></p>
<ul>
<li>list items with a line<br /><br />break<br /></li>
<li>regular</li>
</ul>

HTML;

    $html = <<<HTML
<p><strong>a text with multiple<br />
line breaks<br />
<br />
<br />
inside a tag</strong></p>
<ul>
<li>list items with a line<br />
<br />
break<br /></li>
<li>regular</li>
</ul>

HTML;

    $this->mock(MarkdownConverterInterface::class)
        ->shouldReceive('convertToHtml')
        ->andReturn($convertedHtml);

    expect(MarkdownParser::basic($markdown))->toBe($html);
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

it('keeps the link component', function () {
    $markdown = <<<MARKDOWN
Visit the [Ark](https://ark.io/) website!

[https://ark.io/](https://ark.io/)

MARKDOWN;

    $convertedHtml = <<<HTML
<p>Visit the <span x-data="{
        openModal() {
            Livewire.emit('openModal', '933ff189f227da6ca82ce14f77bfbf4b')
        },
        redirect() {
            window.open('https://ark.io/', '_blank')
        },
        hasDisabledLinkWarning() {
            return localStorage.getItem('has_disabled_link_warning') === 'true';
        }
    }"
>
    <a
        :href="hasDisabledLinkWarning() ? 'https://ark.io/' : 'javascript:;'"
        :target="hasDisabledLinkWarning() ? '_blank' : '_self'"
        rel="noopener nofollow"
        class="break-all cursor-pointer font-semibold items-center link"
        @click="hasDisabledLinkWarning() ? redirect() : openModal()"
    >
        <span>Ark</span>

        <svg wire:key="cYGY7hvI" class="fill-current w-4 h-4 inline flex-shrink-0 ml-1 -mt-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M23.251 7.498V.748h-6.75m6.75 0l-15 15m3-10.5h-9a1.5 1.5 0 00-1.5 1.5v15a1.5 1.5 0 001.5 1.5h15a1.5 1.5 0 001.5-1.5v-9" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg>            </a>

    </span>
 website!</p>
<p><span x-data="{
        openModal() {
            Livewire.emit('openModal', '1d5affb951bf14c1d2cbd73a956d3bc8')
        },
        redirect() {
            window.open('https://ark.io/', '_blank')
        },
        hasDisabledLinkWarning() {
            return localStorage.getItem('has_disabled_link_warning') === 'true';
        }
    }"
>
    <a
        :href="hasDisabledLinkWarning() ? 'https://ark.io/' : 'javascript:;'"
        :target="hasDisabledLinkWarning() ? '_blank' : '_self'"
        rel="noopener nofollow"
        class="break-all cursor-pointer font-semibold items-center link"
        @click="hasDisabledLinkWarning() ? redirect() : openModal()"
    >
        <span>https://ark.io/</span>

        <svg wire:key="LrVRJbzw" class="fill-current w-4 h-4 inline flex-shrink-0 ml-1 -mt-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M23.251 7.498V.748h-6.75m6.75 0l-15 15m3-10.5h-9a1.5 1.5 0 00-1.5 1.5v15a1.5 1.5 0 001.5 1.5h15a1.5 1.5 0 001.5-1.5v-9" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg>            </a>

    </span>
</p>

HTML;

    $this->mock(MarkdownConverterInterface::class)
        ->shouldReceive('convertToHtml')
        ->andReturn($convertedHtml);

    expect(MarkdownParser::basic($markdown))->toContain("<span>Ark</span>");
    expect(MarkdownParser::basic($markdown))->toContain("hasDisabledLinkWarning() ? 'https://ark.io/' : 'javascript:;");
    expect(MarkdownParser::basic($markdown))->toContain("hasDisabledLinkWarning() ? 'https://ark.io/' : 'javascript:;");
});

it('handlers relative links', function () {
    $markdown = <<<MARKDOWN
[My acccount](/account)

MARKDOWN;

    $convertedHtml = <<<HTML
<p><a href="/account" class="font-semibold link">My acccount</a></p>

HTML;

    $html = <<<HTML
<p><a href="/account" class="font-semibold link">My
acccount</a></p>

HTML;

    $this->mock(MarkdownConverterInterface::class)
        ->shouldReceive('convertToHtml')
        ->andReturn($convertedHtml);
    expect(MarkdownParser::basic($markdown))->toBe($html);
});

it('parses links with random characters in the link text', function () {
    $markdown = <<<MARKDOWN
[·$%&/()=?^*¨;MÑ](https://ark.io/)

MARKDOWN;

    $convertedHtml = <<<HTML
<p><span x-data="{
        openModal() {
            Livewire.emit('openModal', '90e49c24f2c8714897fe06a5f177da6b')
        },
        redirect() {
            window.open('https://ark.io/', '_blank')
        },
        hasDisabledLinkWarning() {
            return localStorage.getItem('has_disabled_link_warning') === 'true';
        }
    }"
>
    <a
        :href="hasDisabledLinkWarning() ? 'https://ark.io/' : 'javascript:;'"
        :target="hasDisabledLinkWarning() ? '_blank' : '_self'"
        rel="noopener nofollow"
        class="break-all cursor-pointer font-semibold items-center link"
        @click="hasDisabledLinkWarning() ? redirect() : openModal()"
    >
        <span>·$%&amp;amp;/()=?^*¨;MÑ</span>

        <svg wire:key="JcUdy1s6" class="fill-current w-4 h-4 inline flex-shrink-0 ml-1 -mt-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M23.251 7.498V.748h-6.75m6.75 0l-15 15m3-10.5h-9a1.5 1.5 0 00-1.5 1.5v15a1.5 1.5 0 001.5 1.5h15a1.5 1.5 0 001.5-1.5v-9" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg>            </a>

    </span>
</p>

HTML;

    $this->mock(MarkdownConverterInterface::class)
        ->shouldReceive('convertToHtml')
        ->andReturn($convertedHtml);

        expect(MarkdownParser::basic($markdown))->toContain("hasDisabledLinkWarning() ? 'https://ark.io/' : 'javascript:;");
        expect(MarkdownParser::basic($markdown))->toContain("·$%&amp;amp;/()=?^*¨;MÑ");
});

it('accepts `i` and `em` tags on full markdown', function () {
    $markdown = <<<MARKDOWN
<i>Italic 1</i>

<em>Italic 2</em>

**Italic 3**
MARKDOWN;

    $convertedHtml = <<<HTML
<p><i>Italic 1</i></p>
<p><em>Italic 2</em></p>
<p><i>Italic 3</i></p>

HTML;

    $html = $convertedHtml;

    $this->mock(MarkdownConverterInterface::class)
        ->shouldReceive('convertToHtml')
        ->andReturn($convertedHtml);

    expect(MarkdownParser::basic($markdown))->toBe($html);
});

it('accepts `ins` or underline on `full`', function () {
    $markdown = <<<MARKDOWN
<ins>Underline</ins>

MARKDOWN;

    $convertedHtml = <<<HTML
<p><ins>Underline</ins></p>

HTML;

    $html = $convertedHtml;

    $this->mock(MarkdownConverterInterface::class)
        ->shouldReceive('convertToHtml')
        ->andReturn($convertedHtml);

    expect(MarkdownParser::full($markdown))->toBe($html);
});

it('strips an `script` tag', function () {
    $markdown = <<<MARKDOWN
<script>alert(document.cookie)</script>

MARKDOWN;

    $convertedHtml = <<<HTML
<script>alert(document.cookie)</script>

HTML;

    $html = <<<HTML
<p>alert(document.cookie)</p>

HTML;

    $this->mock(MarkdownConverterInterface::class)
        ->shouldReceive('convertToHtml')
        ->andReturn($convertedHtml);

    expect(MarkdownParser::basic($markdown))->toBe($html);
});

it('strips unsafe attributes', function () {
    $markdown = <<<MARKDOWN
<a x-data x-init="alert(document.cookie)" onload="alert(document.cookie)" href="/account" class="font-semibold link">My acccount</a>

MARKDOWN;

    $convertedHtml = <<<HTML
<p><a x-data x-init="alert(document.cookie)" onload="alert(document.cookie)" href="/account" class="font-semibold link">My acccount</a></p>

HTML;

    $html = <<<HTML
<p><a href="/account" class="font-semibold link">My
acccount</a></p>

HTML;

    $this->mock(MarkdownConverterInterface::class)
        ->shouldReceive('convertToHtml')
        ->andReturn($convertedHtml);

    expect(MarkdownParser::basic($markdown))->toBe($html);
});
