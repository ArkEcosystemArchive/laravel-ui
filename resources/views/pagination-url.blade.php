@php
['pageName' => $pageName, 'urlParams' => $urlParams] = ARKEcosystem\UserInterface\UI::getPaginationData($paginator);
@endphp
<div
    x-data="Pagination('{{ $pageName }}', {{ $paginator->lastPage() }})"
    x-init="init"
    class="pagination-wrapper"
>
    <div class="relative pagination-pages-mobile">
        <form x-show="search" name="searchForm" type="get" class="absolute left-0 z-10 flex w-full h-full px-2 overflow-hidden rounded bg-theme-primary-100 dark:bg-theme-secondary-800">
            <input
                x-model.number="page"
                type="number"
                min="1"
                max="{{ $paginator->lastPage() }}"
                name="{{ $pageName }}"
                placeholder="Enter the page"
                class="w-full px-3 py-2 bg-transparent dark:text-theme-secondary-200"
                x-on:blur="blurHandler"
            />
            @foreach($urlParams as $key => $value)
            <input type="hidden" name="{{ $key }}" value="{{ $value }}" />
            @endforeach
            <button type="submit" class="p-2 text-theme-secondary-500 hover:text-theme-primary-500 transition-default dark:text-theme-secondary-200" :disabled="!page">
                <x-ark-icon name="search" size="sm" />
            </button>
            <button type="button" class="p-2 text-theme-secondary-500 hover:text-theme-primary-500 transition-default dark:text-theme-secondary-200" x-on:click="hideSearch()">
                <x-ark-icon name="close" size="sm" />
            </button>
        </form>

        <button type="button"
            class="button-pagination-page-indicator button-pagination-page-indicator--search"
            :class="{ 'opacity-0': search }"
            x-on:click="toggleSearch"
        ><span>Page {{ $paginator->currentPage() }} of {{ $paginator->lastPage() }}</span></button>
    </div>

    <div class="flex space-x-3">
        @if($paginator->onFirstPage())
            <div class="flex items-center button-generic button-disabled">
                <span class="flex items-center">
                    <x-ark-icon name="pagination-first" size="xs" />
                </span>
            </div>
        @else
            <a class="flex" href="{{ $paginator->url(1) }}">
                <div class="flex items-center h-full button-secondary pagination-button-mobile">
                    <span class="flex items-center">
                        <x-ark-icon name="pagination-first" size="xs" />
                    </span>
                </div>
            </a>
        @endif

        @if($paginator->onFirstPage())
            <div class="flex items-center button-generic button-disabled">
                <div class="flex items-center">
                    <span class="hidden lg:flex lg:ml-2">Previous</span>
                </div>
            </div>
        @else
            <a class="flex" href="{{ $paginator->previousPageUrl() }}">
                <div class="flex items-center h-full button-secondary pagination-button-mobile">
                    <div class="flex items-center">
                        <span class="hidden lg:flex lg:ml-2">Previous</span>
                    </div>
                </div>
            </a>
        @endif

        <div class="relative">
            <form x-show="search" name="searchForm" type="get" class="absolute left-0 z-10 flex w-full h-full px-2 overflow-hidden rounded bg-theme-primary-100 dark:bg-theme-secondary-800 pagination-form-desktop">
                <input
                    x-ref="search"
                    x-model.number="page"
                    type="number"
                    min="1"
                    max="{{ $paginator->lastPage() }}"
                    name="{{ $pageName }}"
                    placeholder="Enter the page number"
                    class="w-full px-3 py-2 bg-transparent dark:text-theme-secondary-200"
                    x-on:blur="blurHandler"
                />
                @foreach($urlParams as $key => $value)
                <input type="hidden" name="{{ $key }}" value="{{ $value }}" />
                @endforeach
                <button type="submit" class="p-2 text-theme-secondary-500 hover:text-theme-primary-500 transition-default dark:text-theme-secondary-200" :disabled="!page">
                    <x-ark-icon name="search" size="sm" />
                </button>
                <button type="button" class="p-2 text-theme-secondary-500 hover:text-theme-primary-500 transition-default dark:text-theme-secondary-200" x-on:click="hideSearch">
                    <x-ark-icon name="close" size="sm" />
                </button>
            </form>

            <div class="hidden px-2 rounded bg-theme-primary-100 dark:bg-theme-secondary-800 md:flex flex-inline">
                @foreach ($elements as $element)
                    {{-- "Three Dots" Separator --}}
                    @if (is_string($element))
                        <button
                            x-on:click="toggleSearch"
                            type="button"
                            class="button-pagination-page-indicator button-pagination-page-indicator--search"
                            :class="{ 'opacity-0': search }"
                        >
                            <span class="button-pagination-search"><x-ark-icon name="search" size="sm" /></span>
                            <span class="button-pagination-ellipsis">{{ $element }}</span>
                        </button>
                    @endif

                    {{-- Array Of Links --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            <a
                                href="{{ $url }}"
                                class="@if ($paginator->currentPage() === $page) button-pagination-page-indicator--selected @else button-pagination-page-indicator  @endif"
                            >
                                {{ $page }}
                            </a>
                        @endforeach
                    @endif
                @endforeach
            </div>

            <div class="pagination-pages md:hidden">
                <button
                    x-on:click="toggleSearch"
                    type="button"
                    class="button-pagination-page-indicator button-pagination-page-indicator--search"
                    :class="{ 'opacity-0': search }"
                ><span>Page {{ $paginator->currentPage() }} of {{ $paginator->lastPage() }}</span></button>
            </div>
        </div>

        @if($paginator->hasMorePages())
            <a class="flex" href="{{ $paginator->nextPageUrl() }}">
                <div class="flex items-center h-full button-secondary pagination-button-mobile">
                    <div class="flex items-center">
                        <span class="hidden lg:flex lg:mr-2">Next</span>
                    </div>
                </div>
            </a>
        @else
            <div class="flex items-center button-generic button-disabled">
                <div class="flex items-center">
                    <span class="hidden lg:flex lg:mr-2">Next</span>
                </div>
            </div>
        @endif

        @if($paginator->hasMorePages())
            <a class="flex" href="{{ $paginator->url($paginator->lastPage()) }}">
                <div class="flex items-center h-full button-secondary pagination-button-mobile">
                    <span class="flex items-center">
                        <x-ark-icon name="pagination-last" size="xs" />
                    </span>
                </div>
            </a>
        @else
            <div class="flex items-center button-generic button-disabled">
                <span class="flex items-center">
                    <x-ark-icon name="pagination-last" size="xs" />
                </span>
            </div>
        @endif
    </div>
</div>
