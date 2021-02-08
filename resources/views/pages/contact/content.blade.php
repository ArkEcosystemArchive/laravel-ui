<div class="flex flex-col py-8 space-y-16 content-container lg:flex-row lg:space-y-0">
    <div class="flex-1 space-y-8 border-theme-secondary-300 lg:border-r lg:pr-6">
        <div class="pb-8 border-b border-dashed border-theme-secondary-300">
            <h3>@lang('ui::pages.contact.let_us_help.title')</h3>

            <div class="mt-4 paragraph-description">
                @lang('ui::pages.contact.let_us_help.description')
            </div>
        </div>

        <div class="pb-8 border-b border-dashed border-theme-secondary-300">
            <h3>@lang('ui::pages.contact.additional_support.title')</h3>

            <div class="mt-4 paragraph-description">
                @lang('ui::pages.contact.additional_support.description')
            </div>

            <div class="flex flex-col mt-6 space-y-3 sm:flex-row sm:space-x-2 sm:space-y-0 sm:items-center">
                <a href="@lang('ui::urls.documentation')" target="_blank" rel="noopener noreferrer" class="button-secondary">@lang('ui::actions.documentation')</a>

                <span class="font-semibold leading-none text-center">@lang('ui::general.or')</span>

                <a href="{{ $discordUrl ?? trans('ui::urls.discord') }}" target="_blank" rel="noopener nofollow noreferrer" class="button-secondary">
                    <div class="flex items-center justify-center w-full space-x-2">
                        @svg('brands.outline.discord', 'w-5 h-5')
                        <span>@lang('ui::actions.discord')</span>
                    </div>
                </a>
            </div>
        </div>

        <div class="space-y-3 text-theme-secondary-900">
            <div class="font-bold">@lang('ui::pages.contact.social.subtitle')</div>

            <div class="flex space-x-3">
                <x-ark-social-square hover-class="{{ $socialIconHoverClass ?? 'hover:bg-theme-danger-400 hover:text-white' }}" @endisset :url="trans('ui::urls.twitter')" icon="brands.outline.twitter" />
                <x-ark-social-square hover-class="{{ $socialIconHoverClass ?? 'hover:bg-theme-danger-400 hover:text-white' }}" :url="trans('ui::urls.facebook')" icon="brands.outline.facebook" />
                <x-ark-social-square hover-class="{{ $socialIconHoverClass ?? 'hover:bg-theme-danger-400 hover:text-white' }}" :url="trans('ui::urls.reddit')" icon="brands.outline.reddit" />
                <x-ark-social-square hover-class="{{ $socialIconHoverClass ?? 'hover:bg-theme-danger-400 hover:text-white' }}" :url="trans('ui::urls.linkedin')" icon="brands.outline.linkedin" />
            </div>
        </div>
    </div>

    <div class="flex flex-col flex-1 lg:pl-6" x-data="{ subject: '{{ $subject }}' }">
        <h3>@lang('ui::pages.contact.form.title')</h3>
        <div class="mt-4">@lang('ui::pages.contact.form.description')</div>

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

            <div
                x-data="{
                    success: {{ (flash()->level === 'success') ? 'true' : 'false' }},
                    error: {{ (flash()->level === 'error') ? 'true' : 'false' }}
                }"
                x-init="setTimeout(() => { error = false; success = false }, 10000)"
                class="relative flex flex-col justify-end flex-1"
            >
                <div x-show.transition="success" class="absolute top-0 w-full" x-cloak>
                    <x-ark-toast
                        type="success"
                        :message="flash()->message"
                        alpineClose="success = false"
                        class="text-center"
                    />
                </div>

                <div x-show.transition="error" class="absolute top-0 w-full" x-cloak>
                    <x-ark-toast
                        type="error"
                        :message="flash()->message"
                        alpineClose="error = false"
                        class="text-center"
                    />
                </div>

                <button x-bind.transition:class="{ invisible: success || error }" type="submit" class="button-primary" x-cloak>
                    @lang('ui::actions.send')
                </button>
            </div>
        </form>
    </div>
</div>
