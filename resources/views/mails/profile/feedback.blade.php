@component('mail::message')

{{ $message }}

@lang('ui::mails.footer', ['applicationName' => config('app.name')])
@endcomponent
