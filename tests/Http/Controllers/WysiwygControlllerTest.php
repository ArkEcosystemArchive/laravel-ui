<?php

use League\CommonMark\MarkdownConverterInterface;

it('counts the characters', function () {
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

    $this->app->instance('middleware.disable', true);

    $this->mock(MarkdownConverterInterface::class)
        ->shouldReceive('convertToHtml')
        ->andReturn($convertedHtml);

    $result = $this
        ->post(route('wysiwyg.count-characters'), [
            'markdown'=> $markdown,
        ])
        ->assertStatus(200)
        ->json();

    expect($result['characters'])->toBe(39);
    expect($result['words'])->toBe(6);
});