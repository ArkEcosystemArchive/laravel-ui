<?php

declare(strict_types=1);

use Mockery\MockInterface;
use League\CommonMark\MarkdownConverterInterface;
use ARKEcosystem\UserInterface\Rules\MarkdownMaxChars;

it('validates the resulted text length', function () {
    $text = <<<EOT
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

    $html = <<<HTML
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
            ->andReturn($html);
    });

    $rule = new MarkdownMaxChars(763);
    $this->assertTrue($rule->passes('markdown', $text));

    $rule = new MarkdownMaxChars(762);
    $this->assertFalse($rule->passes('markdown', $text));
});

it('has an error message', function () {
    $rule = new MarkdownMaxChars(30);
    expect($rule->message())->toBe(trans('validation.custom.max_markdown_chars', ['max' => 30]));
});
