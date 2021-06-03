@props([
    'socialIconHoverClass' => 'hover:bg-theme-danger-400 hover:text-white',
    'discordUrl' => trans('ui::urls.discord'),
    'subject' => null,
    'message' => null,
    'helpTitle' => trans('ui::pages.contact.let_us_help.title'),
    'helpDescription' => trans('ui::pages.contact.let_us_help.description'),
    'additionalTitle' => trans('ui::pages.contact.additional_support.title'),
    'additionalDescription' => trans('ui::pages.contact.additional_support.description'),
    'formTitle' => trans('ui::pages.contact.form.title'),
    'formDescription' => trans('ui::pages.contact.form.description'),
    'contactNetworks' => [
        'twitter' => trans('ui::urls.twitter'),
        'facebook' => trans('ui::urls.facebook'),
        'reddit' => trans('ui::urls.reddit'),
        'linkedin' => trans('ui::urls.linkedin'),
    ],
])

<div class="flex flex-col space-y-16 lg:flex-row lg:space-y-0 contact-content">
    <div class="flex-1 space-y-8 lg:w-1/2 border-theme-secondary-300 lg:border-r lg:pr-6">
        <div class="pb-8 border-b border-dashed border-theme-secondary-300">
            <h3>{{ $helpTitle }}</h3>

            <div class="mt-4 paragraph-description">
                {{ $helpDescription }}
            </div>
        </div>

        <div class="pb-8 border-b border-dashed border-theme-secondary-300">
            <h3>{{ $additionalTitle }}</h3>

            <div class="mt-4 paragraph-description">
                {{ $additionalDescription }}
            </div>

            <div class="flex flex-col mt-6 space-y-3 sm:flex-row sm:space-x-2 sm:space-y-0 sm:items-center">
                <a href="@lang('ui::urls.documentation')" target="_blank" rel="noopener noreferrer" class="button-secondary">@lang('ui::actions.documentation')</a>

                <span class="font-semibold leading-none text-center">@lang('ui::general.or')</span>

                <a href="{{ $discordUrl}}" target="_blank" rel="noopener nofollow noreferrer" class="button-secondary">
                    <div class="flex justify-center items-center space-x-2 w-full">
                        @svg('brands.outline.discord', 'w-5 h-5')
                        <span>@lang('ui::actions.discord')</span>
                    </div>
                </a>
            </div>
        </div>

        <div class="space-y-3 text-theme-secondary-900">
            <div class="font-bold">@lang('ui::pages.contact.social.subtitle')</div>

            <div class="flex space-x-3">
                @foreach($contactNetworks as $name => $url)
                    <x-ark-social-square hover-class="{{ $socialIconHoverClass }}" :url="$url" :icon="'brands.outline.' . $name" />
                @endforeach
            </div>
        </div>
    </div>

    <div class="flex flex-col flex-1 lg:pl-6" x-data="{ subject: '{{ old('subject', $subject) }}' }">
        <h3>{{ $formTitle }}</h3>
        <div class="mt-4">{{ $formDescription }}</div>

        <form id="contact-form" method="POST" action="{{ route('contact') }}#contact-form" class="flex flex-col flex-1 space-y-8" enctype="multipart/form-data">
            @csrf

            @honeypot

            <div class="flex flex-col space-y-8 sm:flex-row sm:space-x-3 sm:space-y-0">
                <x-ark-input
                    name="name"
                    :label="trans('ui::forms.name')"
                    autocomplete="name"
                    class="w-full"
                    :value="old('name')"
                    :errors="$errors"
                />

                <x-ark-input
                    type="email"
                    name="email"
                    :label="trans('ui::forms.email')"
                    autocomplete="email"
                    class="w-full"
                    :value="old('email')"
                    :errors="$errors"
                />
            </div>

            <x-ark-select
                name="subject"
                on-change="subject = $event.target.value"
                :label="trans('ui::forms.subject')"
                :errors="$errors"
            >
                @foreach(config('web.contact.subjects') as $contactSubject)
                    <option
                        value="{{ $contactSubject['value'] }}"
                        @if(old('subject', $subject) === $contactSubject['value']) selected @endif
                    >
                        {{ $contactSubject['label'] }}
                    </option>
                @endforeach
            </x-ark-select>

            <x-ark-textarea
                name="message"
                :label="trans('ui::forms.message')"
                rows="3"
                class="w-full"
                :errors="$errors"
                :placeholder="trans('ui::pages.contact.message_placeholder')"
            >{{ old('message', $message) }}</x-ark-textarea>

            <div x-show="subject === 'job_application'">
                <x-ark-input
                    type="file"
                    name="attachment"
                    :label="trans('ui::forms.attachment_pdf')"
                    class="w-full"
                    :errors="$errors"
                    accept="application/pdf"
                />
            </div>

            <div class="flex relative flex-col flex-1 justify-end">
                <button
                    type="submit"
                    x-data="{
                        success: {{ (flash()->level === 'success') ? 'true' : 'false' }},
                        error: {{ (flash()->level === 'error') ? 'true' : 'false' }}
                    }"
                    @if(flash()->message)
                        x-init="livewire.emit('toastMessage', ['{{ flash()->message }}', '{{ flash()->level }}'])"
                    @endif
                    x-cloak
                    class="button-primary"
                >
                    @lang('ui::actions.send')
                </button>
            </div>
        </form>
    </div>
</div>
