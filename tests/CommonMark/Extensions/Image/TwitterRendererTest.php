<?php

declare(strict_types=1);

use ARKEcosystem\Foundation\CommonMark\Extensions\Image\MediaUrl;
use ARKEcosystem\Foundation\CommonMark\Extensions\Image\TwitterRenderer;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

it('should render twitter embeds', function () {
    $response = [
        'url'  => 'https://twitter.com/arkecosystem/status/1234',
        'html' => '<blockquote>...</blockquote>',
    ];

    Http::fake([
        'publish.twitter.com/*' => $response,
    ]);

    $mediaUrl = new MediaUrl('twitter', 'arkecosystem/status/1234');
    $subject = new TwitterRenderer();

    expect($subject->render($mediaUrl))->toBe('<blockquote>...</blockquote>');
});

it('gets the response from the cache if set', function () {
    $id = 'arkecosystem/status/1234';
    Cache::set(md5('https://twitter.com/'.$id), '<blockquote>cached</blockquote>');

    $mediaUrl = new MediaUrl('twitter', 'arkecosystem/status/1234');
    $subject = new TwitterRenderer();

    expect($subject->render($mediaUrl))->toBe('<blockquote>cached</blockquote>');
});

it('returns an empty string if receives an invalid response', function () {
    $response = [
      'invalid' => 'invalid',
  ];

    Http::fake([
      'publish.twitter.com/*' => $response,
  ]);

    $mediaUrl = new MediaUrl('twitter', 'arkecosystem/status/1234');

    $subject = new TwitterRenderer();

    expect($subject->render($mediaUrl))->toBe('');
});

it('returns an empty string if twitter server is down', function () {
    Http::fake([
      'publish.twitter.com/*' => function () {
          throw new ConnectionException();
      },
  ]);

    $mediaUrl = new MediaUrl('twitter', 'arkecosystem/status/1234');

    $subject = new TwitterRenderer();

    expect($subject->render($mediaUrl))->toBe('');
});

it('caches the response for 5 minutes if server is down', function () {
    $id = 'arkecosystem/status/1234';
    $cacheKey = md5('https://twitter.com/'.$id);

    Cache::shouldReceive('rememberForever')
    ->once()
    ->with($cacheKey, \Closure::class)
    ->andReturn(false)
    ->shouldReceive('forget')
    ->once()
    ->with($cacheKey)
    ->shouldReceive('remember')
    ->with($cacheKey, Carbon::class, \Closure::class)
    ->once()
    ->andReturn('');

    Http::fake([
      'publish.twitter.com/*' => function () {
          throw new ConnectionException();
      },
  ]);

    $mediaUrl = new MediaUrl('twitter', $id);

    $subject = new TwitterRenderer();

    expect($subject->render($mediaUrl))->toBe('');
});
