@props([
    'xData' => '{}',
    'name',
    'id' => null,
    'model' => null,
    'class' => '',
    'label' => '',
    'height' => null,
    'toolbar' => 'basic',
    'plugins' => null,
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
    'iconPodcast' => 'social-music-podcast',
    'iconLinkcollection' => 'app-window-link',
    'iconEmbedLink' => 'image-link',
    'iconReference' => 'page-reference',
    'iconAlert' => 'alert-triangle',
    'iconUndo' => 'undo',
    'iconRedo' => 'redo',
    'iconPreview' => 'monitor',
]
@endphp

<div class="{{ $class ?? '' }}">
    <div class="input-group">
        <label for="{{ $id ?? $name }}" class="input-label @error($name) input-label--error @enderror">
            {{ ($label ?? '') ? $label : trans('forms.' . $name) }}
        </label>

        <div class="input-wrapper">
            <div
                x-data="MarkdownEditor(
                    @if($height)'{{ $height }}'@else null @endif,
                    '{{ $toolbar }}',
                    {{ $xData }}
                )"
                x-init="init"
                class="overflow-hidden bg-white border-2 rounded border-theme-secondary-200"
            >
                <div x-show="showOverlay" class="fixed top-0 left-0 z-50 w-full h-full bg-black bg-opacity-75" style="display: none"></div>
                <div>
                    @for($i=1; $i<=6; $i++)
                        <template x-ref="iconH{{ $i }}">
                            @svg('wysiwyg.H' . $i, 'inline h-5')
                        </template>
                    @endfor
                    @foreach($icons as $ref => $iconName)
                        <template x-ref="{{ $ref }}">
                            @svg('wysiwyg.' . $iconName, 'inline h-4')
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

                <div wire:ignore x-ref="editor"></div>

                <div x-cloak class="flex justify-end py-3 text-xs bg-white border-t-2 border-theme-secondary-200">
                    <span class="px-4 ">Words: <strong x-text="wordsCount"></strong></span>
                    <span class="px-4 border-l-2 border-theme-secondary-200">Characters: <strong x-text="charsCount"></strong></span>
                    <span class="px-4 border-l-2 border-theme-secondary-200">Reading time: <strong><span x-text="readMinutes"></span> min</strong></span>
                </div>
            </div>
        </div>

        @error($name)
            <p class="input-help--error">{{ $message }}</p>
        @enderror
    </div>
</div>

