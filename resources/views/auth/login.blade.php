@extends('layouts.login')

@section('content')

    <div class="tab-content">
        <div id="login" class="tab-pane active">
            <form method="POST" action="{{ route('login') }}" role="form">
                {!! csrf_field() !!}

                @include('partials.errors')
                <p class="text-muted text-center">
                    @lang('auth.login_title')
                </p>
                <input type="text" name="email" placeholder="@lang('validation.attributes.user')" class="form-control top" value="{{ old('email') }}">
                <input type="password" name="password" placeholder="@lang('validation.attributes.password')" class="form-control bottom">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="remember"> @lang('auth.remember_me')
                    </label>
                </div>
                <button class="btn btn-lg btn-primary btn-block" type="submit">@lang('general.enter')</button>
            </form>
        </div>
        <div id="forgot" class="tab-pane">
            <form method="POST" action="{{ route('passwordEmail') }}">
                {!! csrf_field() !!}
                @include('partials.errors')
                <p class="text-muted text-center">
                    @lang('auth.valid_email')
                </p>
                <input name="email" type="email" class="form-control" placeholder="mail@domain.com" value="{{ old('email') }}">
                <br>
                <button class="btn btn-lg btn-danger btn-block" type="submit">@lang('auth.forgotPassword_link')</button>
            </form>
        </div>
        {{--<div id="signup" class="tab-pane">
                <form action="index.html">
                    <input type="text" placeholder="Usuario" class="form-control top">
                    <input type="email" placeholder="mail@domain.com" class="form-control middle">
                    <input type="password" placeholder="contraseña" class="form-control middle">
                    <input type="password" placeholder="repite contraseña" class="form-control bottom">
                    <button class="btn btn-lg btn-success btn-block" type="submit">Register</button>
                </form>
            </div>--}}
    </div>
    <hr>
    <div class="text-center">
        <ul class="list-inline">
            <li> <a class="text-muted" href="#login" data-toggle="tab">@lang('auth.access_link')</a>  </li>
            <li> <a class="text-muted" href="#forgot" data-toggle="tab">@lang('auth.forgotPassword_link')</a>  </li>
            <!--<li> <a class="text-muted" href="#signup" data-toggle="tab">Signup</a>  </li>-->
        </ul>
    </div>
@endsection

