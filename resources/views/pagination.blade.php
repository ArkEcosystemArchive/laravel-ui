@php
['path' => $path, 'pageName' => $pageName] =    $paginator->getOptions();
@endphp
<div
    x-data="{
        search: false,
        page: null,
        init() {
            this.$watch('search', (search) => {
                if (this.search) {
                    this.$nextTick(() => {
                        const searchInputs = this.$el.querySelectorAll('input[name={{ $pageName }}]');
                        searchInputs.forEach( (input) => {
                            input.focus()
                        })
                    })
                 } else {
                    this.page = null;
                 }
            })

            this.$watch('page', (page) => {
                if (page === null) {
                    return;
                }

                if (page < 1) {
                    this.page = 1;
                }
                if (page > {{ $paginator->lastPage() }}) {
                    this.page = {{ $paginator->lastPage() }};
                }
            })
        },
        blurHandler() {
            if (!this.page) {
                this.search = false
            }
        },
        toggleSearch() {
            this.search = !this.search;
        },
    }"
    x-init="init"
    class="pagination-wrapper"
>
    <div class="relative pagination-pages-mobile">
        <form x-show="search" name="searchForm" type="get" action="{{ $path }}" class="absolute left-0 z-10 flex w-full h-full px-2 overflow-hidden rounded bg-theme-primary-100 dark:bg-theme-secondary-800">
            <input
                x-model.number="page"
                type="number"
                min="1"
                max="{{ $paginator->lastPage() }}"
                name="{{ $pageName }}"
                placeholder="Enter the page" class="w-full px-3 py-2 bg-transparent"
                @blur="blurHandler"
            />
            <button type="submit" class="p-2 text-theme-secondary-400 hover:text-theme-primary-500" :disabled="!page">
                <x-ark-icon name="search" size="sm" />
            </button>
            <button type="button" class="p-2 text-theme-secondary-400 hover:text-theme-primary-500" @click="toggleSearch()">
                <x-ark-icon name="close" size="sm" />
            </button>
        </form>

        <button type="button" class="button-pagination-page-indicator button-pagination-page-indicator--search" @click="toggleSearch()"><span>Page {{ $paginator->currentPage() }} of {{ $paginator->lastPage() }}</span></button>
    </div>

    <div class="flex space-x-3">
        <button
            wire:click="gotoPage(1)"
            class="items-center button-secondary pagination-button-mobile" @if($paginator->onFirstPage()) disabled @endif
        >
            <x-ark-icon name="pagination-first" size="xs" />
        </button>
        <button
            wire:click="gotoPage({{ $paginator->currentPage() - 1 }})"
            class="items-center button-secondary pagination-button-mobile" @if($paginator->onFirstPage()) disabled @endif
        >
            <div class="flex items-center">
                <x-ark-icon class="inline-block lg:hidden" name="chevron-left" size="xs" />
                <span class="hidden lg:flex">Previous</span>
            </div>
        </button>

        <div class="relative">
            <form x-show="search" name="searchForm" type="get" action="{{ $path }}" class="absolute left-0 z-10 flex w-full h-full px-2 overflow-hidden rounded bg-theme-primary-100 dark:bg-theme-secondary-800 pagination-form-desktop">
                <input
                    x-ref="search"
                    x-model.number="page"
                    type="number"
                    min="1"
                    max="{{ $paginator->lastPage() }}"
                    name="{{ $pageName }}"
                    placeholder="Enter the page number" class="w-full px-3 py-2 bg-transparent"
                    @blur="blurHandler"
                />
                <button type="submit" class="p-2 text-theme-secondary-400 hover:text-theme-primary-500" :disabled="!page">
                    <x-ark-icon name="search" size="sm" />
                </button>
                <button type="button" class="p-2 text-theme-secondary-400 hover:text-theme-primary-500" @click="toggleSearch()">
                    <x-ark-icon name="close" size="sm" />
                </button>
            </form>

            <div class="hidden px-2 rounded bg-theme-primary-100 dark:bg-theme-secondary-800 md:flex flex-inline">
                @foreach ($elements as $element)
                    {{-- "Three Dots" Separator --}}
                    @if (is_string($element))
                        <button @click="toggleSearch()" type="button" class="button-pagination-page-indicator button-pagination-page-indicator--search"><span>{{ $element }}</span></button>
                    @endif

                    {{-- Array Of Links --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            <button
                                class="@if ($paginator->currentPage() === $page) button-pagination-page-indicator--selected @else button-pagination-page-indicator  @endif"
                                wire:click="gotoPage({{ $page }})"
                            >
                                {{ $page }}
                            </button>
                        @endforeach
                    @endif
                @endforeach
            </div>

            <div class="pagination-pages md:hidden">
                <button @click="toggleSearch" type="button" class="button-pagination-page-indicator button-pagination-page-indicator--search"><span>Page {{ $paginator->currentPage() }} of {{ $paginator->lastPage() }}</span></button>
            </div>
        </div>

        <button
            wire:click="gotoPage({{ $paginator->currentPage() + 1 }})"
            class="items-center button-secondary pagination-button-mobile" @if($paginator->currentPage() === $paginator->lastPage()) disabled @endif
        >
            <div class="flex items-center">
                <span class="hidden lg:flex">Next</span>
                <x-ark-icon class="inline-block lg:hidden" name="chevron-right" size="xs" />
            </div>
        </button>
        <button
            wire:click="gotoPage({{ $paginator->lastPage() }})"
            class="items-center button-secondary pagination-button-mobile"
            @if($paginator->currentPage() === $paginator->lastPage()) disabled @endif
        >
            <x-ark-icon name="pagination-last" size="xs" />
        </button>
    </div>
</div>
