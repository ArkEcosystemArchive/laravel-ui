<?php

declare(strict_types=1);

use ARKEcosystem\UserInterface\Rules\MarkdownMaxChars;
use League\CommonMark\MarkdownConverterInterface;
use League\CommonMark\Node\Block\Document;
use League\CommonMark\Output\RenderedContent;
use Mockery\MockInterface;

it('validates the resulted text length', function () {
    $text = <<<'EOT'
# Aut spes nomina turis

## Spem non bracchia

Lorem markdownum; aequor rapta refovet requirit grandia *nec* germanae partu
progenies dignamque: duorum materno attraxerat ut. **Incidit tenerum membra**,
cutem potum flores perit plenaque umerique; dura *equo vidit*. Tristia sedem
quem terras bracchia, miratur et oblivia? Erat est, *verso* parte nulla; miser
constitit celerem convivia: et esse: [infelix
inridens](http://sucis.org/corpora-adde) ora tuae! Dum punior cornua; Est huic,
digitos Clanis in arces si quodam barbare aut dicta.

1. Pronaque suos modo tibi vetuere fluit equos
2. Metuit vim Hersilie iamque __videt__ intendens spiritus
3. Modo infracto

Animi verecundo gentes adversaque vultum equos maduere; terra petit solebas, et,
iam *amnis* promissa miluus! Diomedeos ira atque facinus deus magnum legit
*pariter*!
EOT;

    $html = <<<'HTML'
<h1><a id="user-content-aut-spes-nomina-turis" href="#aut-spes-nomina-turis" name="aut-spes-nomina-turis" class="heading-permalink" aria-hidden="true" title="Permalink">#</a>Aut spes nomina turis</h1>
<h2><a id="user-content-spem-non-bracchia" href="#spem-non-bracchia" name="spem-non-bracchia" class="heading-permalink" aria-hidden="true" title="Permalink">#</a>Spem non bracchia</h2>
<p>Lorem markdownum; aequor rapta refovet requirit grandia <em>nec</em> germanae partu
progenies dignamque: duorum materno attraxerat ut. <strong>Incidit tenerum membra</strong>,
cutem potum flores perit plenaque umerique; dura <em>equo vidit</em>. Tristia sedem
quem terras bracchia, miratur et oblivia? Erat est, <em>verso</em> parte nulla; miser
constitit celerem convivia: et esse: <a rel="noopener noreferrer" target="_blank" class="external-link" href="http://sucis.org/corpora-adde">infelix
inridens</a> ora tuae! Dum punior cornua; Est huic,
digitos Clanis in arces si quodam barbare aut dicta.</p>
<ol>
<li>Pronaque suos modo tibi vetuere fluit equos</li>
<li>Metuit vim Hersilie iamque <strong>videt</strong> intendens spiritus</li>
<li>Modo infracto</li>
</ol>
<p>Animi verecundo gentes adversaque vultum equos maduere; terra petit solebas, et,
iam <em>amnis</em> promissa miluus! Diomedeos ira atque facinus deus magnum legit
<em>pariter</em>!</p>
HTML;

    $this->mock(MarkdownConverterInterface::class, function (MockInterface $mock) use ($html) {
        $mock->shouldReceive('convertToHtml')
            ->andReturn(new RenderedContent(new Document(), $html));
    });

    $rule = new MarkdownMaxChars(762);
    $this->assertTrue($rule->passes('markdown', $text));

    $rule = new MarkdownMaxChars(761);
    $this->assertFalse($rule->passes('markdown', $text));
});

it('accepts the exact number of chars on the parameter', function () {
    $text = str_repeat('a', 100);

    $this->mock(MarkdownConverterInterface::class, function (MockInterface $mock) use ($text) {
        $mock->shouldReceive('convertToHtml')
            ->andReturn(new RenderedContent(new Document(), $text));
    });

    $rule = new MarkdownMaxChars(100);
    $this->assertTrue($rule->passes('markdown', $text));
});

it('trims the whitespaces for counting', function () {
    $text = str_repeat('a', 100);

    $this->mock(MarkdownConverterInterface::class, function (MockInterface $mock) use ($text) {
        $mock->shouldReceive('convertToHtml')
            ->andReturn(new RenderedContent(new Document(), $text."\n"));
    });

    $rule = new MarkdownMaxChars(100);
    $this->assertTrue($rule->passes('markdown', $text));
});

it('doesnt accepts more characters than the limit', function () {
    $text = str_repeat('a', 11);

    $this->mock(MarkdownConverterInterface::class, function (MockInterface $mock) use ($text) {
        $mock->shouldReceive('convertToHtml')
            ->andReturn(new RenderedContent(new Document(), $text));
    });

    $rule = new MarkdownMaxChars(10);
    $this->assertFalse($rule->passes('markdown', $text));
});

it('validates unicode text correctly', function () {
    $text = '⡷⡷⡷';

    $this->mock(MarkdownConverterInterface::class, function (MockInterface $mock) {
        $mock->shouldReceive('convertToHtml')
            ->andReturn(new RenderedContent(new Document(), '⡷⡷⡷'));
    });

    $rule = new MarkdownMaxChars(3);
    $this->assertTrue($rule->passes('markdown', $text));

    $rule = new MarkdownMaxChars(2);
    $this->assertFalse($rule->passes('markdown', $text));
});

it('has an error message', function () {
    $rule = new MarkdownMaxChars(30);
    expect($rule->message())->toBe(trans('ui::validation.custom.max_markdown_chars', ['max' => 30]));
});

it('handles the characters count when we have lists', function () {
    $markdown = <<<'EOT'
I have been involved in the Blockchain and crypto industries for years. I started getting more active after discovering ARK and began collaborating with others in the ARK community:

Delegate Cam’s Yellow Jacket for ArkLogoWorks
BroadcastJunkie for ArkForIT
Delegate Cryptology for ArkTippr
Jorma for ArkDirectory

I launched a community service of my own under the name ARKStickers where I began shipping ARK sticker packs all over the world in exchange for ARK coins. Shortly thereafter, I helped write docs for the ARK Team. I founded the ARK Community Committee to make cool ARK stuff with other people, like ARKTimeline. I was hired to the team in 2018, and have since produced over 100 podcast episodes under The ARK Crypto Podcast. I attended and spoke at Blockchain conferences such as Consensus NYC 2019, WorldCryptoCon, Hivefest, DYGYCON, and others. I have been interviewed by BlockTV, Cointelegraph, and other media outlets. I now serve as Senior Brand Manager for ARK and its products.
EOT;

    $html = <<<'HTML'
<p>I have been involved in the Blockchain and crypto industries for years. I started getting more active after discovering ARK and began collaborating with others in the ARK community:</p>
<ul>
<li>
<strong>Delegate Cam’s Yellow Jacket</strong> for <em>ArkLogoWorks</em>
</li>
<li>
<strong>BroadcastJunkie</strong> for <em>ArkForIT</em>
</li>
<li>
<strong>Delegate Cryptology</strong> for <em>ArkTippr</em>
</li>
<li>
<strong>Jorma</strong> for <em>ArkDirectory</em>
</li>
</ul>
<p>I launched a community service of my own under the name <em>ARKStickers</em> where I began shipping ARK sticker packs all over the world in exchange for ARK coins. Shortly thereafter, I helped write docs for the ARK Team. I founded the ARK Community Committee to make cool ARK stuff with other people, like ARKTimeline. I was hired to the team in 2018, and have since produced over 100 podcast episodes under <em>The ARK Crypto Podcast.</em> I attended and spoke at Blockchain conferences such as Consensus NYC 2019, WorldCryptoCon, Hivefest, DYGYCON, and others. I have been interviewed by BlockTV, Cointelegraph, and other media outlets. I now serve as Senior Brand Manager for ARK and its products.</p>
HTML;

    $this->mock(MarkdownConverterInterface::class)
        ->shouldReceive('convertToHtml')
        ->andReturn(new RenderedContent(new Document(), $html));

    $rule = new MarkdownMaxChars(998);
    $this->assertTrue($rule->passes('markdown', $markdown));

    $rule = new MarkdownMaxChars(997);
    $this->assertFalse($rule->passes('markdown', $markdown));
});
