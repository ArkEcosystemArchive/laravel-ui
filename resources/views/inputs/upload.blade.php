<div
    class="flex flex-col flex-1 h-full"
    x-data="{{ $method }}({ url: '{{ $url }}', onUpload: () => { window.location.reload() }})"
>
    <label for="{{ $id ?? $name }}" class="input-label @error($name) input-label--error @enderror">
        {{ ($label ?? '') ? $label : trans('forms.' . $name) }}
    </label>

    <div class="flex flex-1 mt-2">
        <div class="flex-1 h-full sm:grid sm:grid-cols-2 sm:gap-4 sm:items-start">
            <div class="h-full sm:col-span-2">
                <div class="flex justify-center px-6 pt-5 pb-6 h-full rounded-md border-2 border-dashed border-theme-secondary-300">
                    <div class="m-auto text-center">
                        <svg class="mx-auto w-12 h-12 text-theme-secondary-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>

                        <p class="mt-1 text-sm text-theme-secondary-600">
                            <input
                                id="{{ $id ?? $name }}"
                                type="file"
                                class="block absolute top-0 opacity-0 cursor-pointer"
                                @if ($change ?? false) @change.prevent="{{ $change }}" @endif
                            >

                            <button
                                type="button"
                                class="link"
                                @if ($click ?? false) @click="{{ $click }}" @endif
                            >
                                Upload a file
                            </button>
                        </p>

                        <p class="mt-1 text-xs text-theme-secondary-500">
                            {{ strtoupper(implode(', ', $extensions ?? [])) }} up to {{ $size ?? '10' }}MB
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @error($name)
        <p class="input-help--error">{{ $message }}</p>
    @enderror
</div>
