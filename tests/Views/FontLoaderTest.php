<?php

use function Tests\createViewAttributes;

it('should render the font', function (): void {
    $this
        ->assertView('ark::font-loader', createViewAttributes(['src' => 'https://font.woff']))
        ->contains('<link rel="preconnect" href="https://font.woff" crossorigin />')
        ->contains('<link rel="preload" as="style" href="https://font.woff" />')
        ->contains('<link rel="stylesheet" href="https://font.woff" media="print" onload="this.media=\'all\'" />')
        ->contains('<noscript><link rel="stylesheet" href="https://font.woff" /></noscript>');
});

it('should render the font with a different pre-connect source', function (): void {
    $this
        ->assertView('ark::font-loader', createViewAttributes(['src' => 'https://font.woff', 'preconnect' => 'https://pre.font.woff']))
        ->contains('<link rel="preconnect" href="https://pre.font.woff" crossorigin />')
        ->contains('<link rel="preload" as="style" href="https://font.woff" />')
        ->contains('<link rel="stylesheet" href="https://font.woff" media="print" onload="this.media=\'all\'" />')
        ->contains('<noscript><link rel="stylesheet" href="https://font.woff" /></noscript>');
});

it('should render the font from google fonts with display swap', function (): void {
    $this
        ->assertView('ark::font-loader', createViewAttributes(['src' => 'https://fonts.googleapis.com/css2?family=Inter:wght@400&display=swap', 'preconnect' => 'https://fonts.gstatic.com']))
        ->contains('<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />')
        ->contains('<link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Inter:wght@400&display=swap" />')
        ->contains('<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400&display=swap" media="print" onload="this.media=\'all\'" />')
        ->contains('<noscript><link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400&display=swap" /></noscript>');
});

it('should render the font from google fonts forcing display swap', function (): void {
    $this
        ->assertView('ark::font-loader', createViewAttributes(['src' => 'https://fonts.googleapis.com/css2?family=Inter:wght@400', 'preconnect' => 'https://fonts.gstatic.com']))
        ->contains('<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />')
        ->contains('<link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Inter:wght@400&display=swap" />')
        ->contains('<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400&display=swap" media="print" onload="this.media=\'all\'" />')
        ->contains('<noscript><link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400&display=swap" /></noscript>');
});
