@empty($signupLink)
  @lang('fortify::auth.sign-in.register_now', ['route' => route('register')])
@else
  {!! $signupLink !!}
@endempty
