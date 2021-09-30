@extends('layouts.app', ['fullWidth' => true])

<x-ark-metadata page="two-factor.login" />

@section('title')
    <x-data-bag key="fortify-content" resolver="name" view="ark-fortify::components.page-title" />
@endsection

@section('breadcrumbs')
    <x-ark-breadcrumbs :crumbs="[
        ['route' => 'login', 'label' => trans('ui::menu.sign_in')],
        ['label' => trans('ui::menu.2fa')],
    ]" />
@endsection

@section('content')
    <div class="w-full py-8 bg-theme-secondary-100">
        <div class="container mx-auto ">
            <h1 class="mx-4 text-2xl font-bold text-center md:text-4xl md:mx-8 xl:mx-16 text-theme-secondary-900">@lang('ui::auth.two-factor.page_header')</h1>
            <p class="mx-4 mt-4 font-semibold text-center text-theme-secondary-700 md:mx-8 xl:mx-16">@lang('ui::auth.two-factor.page_description')</p>
        </div>
    </div>

    <div x-data="{ recovery: @json($errors->has('recovery_code')) }" x-cloak>
        @include('ark-fortify::auth.two-factor.form')
        @include('ark-fortify::auth.two-factor.recovery-form')
    </div>
@endsection
