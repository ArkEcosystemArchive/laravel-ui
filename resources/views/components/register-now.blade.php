@empty($signupLink)
  @lang('ui::auth.sign-in.register_now', ['route' => route('register')])
@else
  {!! $signupLink !!}
@endempty
