<div
    x-data="fileDownload()"
>
    <button
        type="button"
        class="button-secondary flex items-center {{ $class ?? '' }}"
        @click="save('{{ $filename }}', '{{ $content }}', '{{ $type ?? 'text/plain' }}', '{{ $extension ?? 'txt'}}')"
    >
        <x-ark-icon name="download" size="sm" />

        <span class="ml-2">{{ ($title ?? '') ? $title : trans('ui::actions.save') }}</span>
    </button>
</div>
