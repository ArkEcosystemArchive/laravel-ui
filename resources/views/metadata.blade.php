@props([
    'page'          => 'home',
    'detail'        => null,
    'noDescription' => false,
    'noImage'       => false,
])

@section('meta-title')
    @lang("metatags.{$page}.title", ['detail' => $detail])
@endsection

@unless($noDescription)
    @section('meta-description')
        @lang("metatags.{$page}.description", ['detail' => $detail])
    @endsection
@endunless

@unless($noImage)
    @section('meta-image')
        @lang("metatags.{$page}.image", ['detail' => $detail ? Str::camel(Str::slug($detail)) : null])
    @endsection
@endunless
