@props([
    'page'   => 'home',
    'detail' => null,
])

@section('meta-title')
    @lang("metatags.{$page}.title", ['detail' => $detail])
@endsection

@isset(trans('metatags.'.$page)['description'])
    @section('meta-description')
        @lang("metatags.{$page}.description", ['detail' => $detail])
    @endsection
@endisset

@isset(trans('metatags.'.$page)['image'])
    @section('meta-image')
        @lang("metatags.{$page}.image", ['detail' => $detail ? Str::camel(Str::slug($detail)) : null])
    @endsection
@endisset
