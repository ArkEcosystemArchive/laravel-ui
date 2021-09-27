<?php

declare(strict_types=1);

namespace ARKEcosystem\UserInterface\Http\Controllers;

use ARKEcosystem\UserInterface\Support\Concerns\ParsesMarkdown;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

final class WysiwygControlller extends Controller
{
    use ParsesMarkdown;

    public function getTwitterEmbedCode(Request $request): string
    {
        $id = $request->get('id');

        if (! $id) {
            abort('400', 'Missing id');
        }

        $url = 'https://twitter.com/'.$request->get('id');

        return Cache::rememberForever(md5($url), fn () => Http::get('https://publish.twitter.com/oembed', [
            'url'         => $url,
            'hide_thread' => 1,
            'hide_media'  => 0,
            'omit_script' => true,
            'dnt'         => true,
            'limit'       => 20,
            'chrome'      => 'nofooter',
        ])->json()['html']);
    }

    public function uploadImage(Request $request): array
    {
        $this->validate($request, [
            'image' => 'required|image',
        ]);

        $file = $request->file('image');

        $path = $file->storePubliclyAs(
            config('ui.wysiwyg.folder'),
            $file->hashName(),
            config('ui.wysiwyg.disk')
        );

        return ['url' => asset($path)];
    }

    public function countCharacters(Request $request): array
    {
        $this->validate($request, [
            'markdown' => ['string', 'nullable'],
        ]);

        $markdown = $request->markdown;

        return $this->count($markdown);
    }
}
