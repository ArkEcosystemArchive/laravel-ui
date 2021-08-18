@props([
    'content',
    'filename',
    'class'        => '',
    'extension'    => 'txt',
    'title'        => trans('ui::actions.save'),
    'type'         => 'text/plain',
    'wrapperClass' => '',
])

<div
    x-data="fileDownload()"
    class="{{ $wrapperClass }}"
>
    <button
        type="button"
        class="button-secondary flex items-center {{ $class }}"
        @click="save('{{ $filename }}', '{{ $content }}', '{{ $type }}', '{{ $extension }}')"
    >
        <x-ark-icon name="download" size="sm" />

        <span class="ml-2">{{ $title }}</span>
    </button>
</div>
