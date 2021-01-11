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
>
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
</div>
