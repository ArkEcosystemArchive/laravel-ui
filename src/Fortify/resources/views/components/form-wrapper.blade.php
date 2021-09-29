@props(['action', 'method' => 'POST'])

<div class="sm:max-w-xl py-8 mx-auto" {{ $attributes }}>
    <form action="{{ $action }}" method="{{ $method }}" class="flex flex-col px-8 pb-8 sm:pt-8 border-b-2 sm:border-2 sm:rounded-xl border-theme-secondary-200">
        @csrf
        {{ $slot  }}
    </form>
</div>
