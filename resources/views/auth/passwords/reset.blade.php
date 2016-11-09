@extends('layouts.login')

@section('content')
    <div class="tab-content">
        <div id="password_reset" class="tab-pane active">
            <form method="POST" action="{{ url('password/reset') }}">
                {!! csrf_field() !!}
                <input type="hidden" name="token" value="{{ $token }}">
                @include('partials.errors')
                <p class="text-muted text-center">
                    @lang('auth.reset_title')
                </p>
                <input type="text" name="email" placeholder="@lang('validation.attributes.email')" class="form-control" value="{{ old('email') }}">
                <input type="password" name="password" placeholder="@lang('validation.attributes.password')" class="form-control top">
                <input type="password" name="password_confirmation" placeholder="@lang('validation.attributes.password_confirmation')" class="form-control bottom">

                <button class="btn btn-lg btn-primary btn-block" type="submit">@lang('auth.reset_button')</button>
            </form>
        </div>
    </div>
@endsection
