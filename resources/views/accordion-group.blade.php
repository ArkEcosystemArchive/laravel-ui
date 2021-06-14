<div x-data="{ openPanel: null }">
    <dl>
        @for($i = 0; $i < $slots; $i++)
            <div class="border border-theme-secondary-200 rounded-xl p-6 @if($i > 0) mt-5 @endif">
                <dt>
                    <button
                        type="button"
                        class="flex justify-between items-center w-full text-left focus:outline-none text-theme-primary-600"
                        :class="{ 'mb-5': openPanel === {{ $i }} }"
                        @click="openPanel = (openPanel === {{ $i }} ? null : {{ $i }})"
                    >
                        <span class="text-lg font-semibold">
                            {{ ${"title_{$i}"} }}
                        </span>
                        <span class="flex items-center ml-6 h-7">
                            <span :class="{ 'rotate-180': openPanel === {{ $i }} }" class="transition duration-150 ease-in-out transform">@svg('chevron-down', 'h-3 w-3')</span>
                        </span>
                    </button>
                </dt>
                <dd class="mt-2" x-show.transition.opacity="openPanel === {{ $i }}" x-cloak>
                    {{ ${"slot_{$i}"} }}
                </dd>
            </div>
        @endfor
    </dl>
</div>
