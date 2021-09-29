@component('mail::message')

{{ $message }}

@lang('fortify::mails.footer', ['applicationName' => config('app.name')])
@endcomponent
