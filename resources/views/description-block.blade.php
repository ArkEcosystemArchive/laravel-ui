<div class="description-block">
    <div class="flex justify-center">
        <img
            @unless ($lazyLoad ?? false)
                src="{{ $image }}"
            @else
                lazy="{{ $image }}"
            @endif
            class="max-w-full"
        />
    </div>

    <div class="flex flex-col mt-8 space-y-4">
        <span class="text-xl font-bold text-theme-secondary-900">
            {{ $title }}
        </span>

        <span class="paragraph-description">{{ $description }}</span>
    </div>
</div>
