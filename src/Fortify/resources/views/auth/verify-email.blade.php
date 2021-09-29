@extends('layouts.app')

<x-ark-metadata page="verification.notice" />

@section('title')
    <x-data-bag key="fortify-content" resolver="name" view="ark-fortify::components.page-title" />
@endsection

@section('breadcrumbs')
    <x-ark-breadcrumbs :crumbs="[
        ['route' => 'login', 'label' =>trans('fortify::menu.sign_in')],
        ['label' => trans('fortify::menu.verify')],
    ]" />
@endsection

@section('content')
    <livewire:auth.verify-email />
@endsection

