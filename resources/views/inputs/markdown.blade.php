@props([
    'xData' => '{}',
    'name',
    'id' => null,
    'model' => null,
])

@php
$icons = [
    'iconBold' => 'text-bold',
    'iconItalic' => 'text-italic',
    'iconStrike' => 'text-strike-through',
    'iconUnderline' => 'text-underline',
    'iconQuote' => 'open-quote',
    'iconUl' => 'list-numbers',
    'iconOl' => 'list-bullets',
    'iconTable' => 'table',
    'iconImage' => 'image-file-landscape',
    'iconLink' => 'hyperlink',
    'iconCode' => 'programming-browser-1',
    'iconCodeblock' => 'programming-browser',
    'iconYoutube' => 'social-video-youtube-clip',
    'iconTwitter' => 'social-media-twitter',
    'iconUndo' => 'undo',
    'iconRedo' => 'redo',
]
@endphp
<div
    x-data="MarkdownEditor({{ $xData }})"
    x-init="init"
    class="overflow-hidden bg-white rounded border-2 border-theme-secondary-200"
>
    <div x-show="showOverlay" class="fixed top-0 left-0 z-50 w-full h-full bg-black bg-opacity-75" style="display: none"></div>
    <div>
        @for($i=1; $i<=6; $i++)
        <template x-ref="iconH{{ $i }}">
            @svg('wyswyg.H' . $i, 'inline h-5')
        </template>
        @endfor
        @foreach($icons as $ref => $iconName)
        <template x-ref="{{ $ref }}">
            @svg('wyswyg.' . $iconName, 'inline h-5')
        </template>
        @endforeach
        <template x-ref="iconChevronDrown">
            @svg('chevron-down', 'inline h-3')
        </template>
    </div>

    <input
        x-ref="input"
        type="hidden"
        id="{{ $id ? $id : $name }}"
        name="{{ $name }}"
        wire:model="{{ $model ? $model : $name }}"
    />

    <div wire:ignore x-ref="editor">
        <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>

    </div>
    <div x-cloak class="flex justify-end py-3 text-xs bg-white">
        <span class="px-4 ">Words: <strong x-text="wordsCount"></strong></span>
        <span class="px-4 border-l-2 border-theme-secondary-200">Characters: <strong x-text="charsCount"></strong></span>
        <span class="px-4 border-l-2 border-theme-secondary-200">Reading time: <strong><span x-text="readMinutes"></span> min</strong></span>
    </div>
</div>
