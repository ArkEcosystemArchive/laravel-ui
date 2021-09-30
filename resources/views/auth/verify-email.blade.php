@extends('layouts.app')

<x-ark-metadata page="verification.notice" />

@section('title')
    <x-data-bag key="fortify-content" resolver="name" view="ark-fortify::components.page-title" />
@endsection

@section('breadcrumbs')
    <x-ark-breadcrumbs :crumbs="[
        ['route' => 'login', 'label' =>trans('ui::menu.sign_in')],
        ['label' => trans('ui::menu.verify')],
    ]" />
@endsection

@section('content')
    <livewire:auth.verify-email />
@endsection
