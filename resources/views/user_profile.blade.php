@extends('layouts.default')

@section('content')

    <div class="box">
        <header class="dark">
            <div class="icons">
                <i class="fa fa-user"></i>
            </div>
            <h5>Modificar datos de usuario</h5>

            @include('partials.window_options')
        </header>

        <div class="body">

            @include('partials.msg_success')

            @include('partials.errors')

            <div class="row">
                <form class="form-horizontal" method="POST" action="{{ route('user_profile.update', $user->id) }}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <div class="col-lg-12">
                            <img class="media-object img-thumbnail user-img" style="margin: 0px auto;"
                                 @if($user->hasProfileImage())
                                    src="{{ route('user_profile.image') }}" width="128px"
                                 @else
                                    src="{{ asset('assets/img/user.gif') }}"
                                @endif
                            >
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-lg-4">@lang('pages/user_profile.image')</label>
                        <div class="col-lg-4">
                            <input class="form-control" type="file" name="image" id="image" value="{{ old('image') }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-lg-4">@lang('pages/user_profile.name')</label>
                        <div class="col-lg-4">
                            <input class="form-control" type="text" name="name" id="name"
                                   value="@if(isset($user) && $user != null){{ $user->name }}@else{{ old('name') }}@endif" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-lg-4">@lang('pages/user_profile.surname')</label>
                        <div class=" col-lg-4">
                            <input class="form-control" type="text" name="surname" id="surname"
                                   value="@if(isset($user) && $user != null){{ $user->surname }}@else{{ old('surname') }}@endif" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-lg-4">@lang('pages/user_profile.telephone')</label>
                        <div class=" col-lg-4">
                            <input class="form-control" type="tel" name="telephone" id="telephone"
                                   value="@if(isset($user) && $user != null){{ $user->telephone }}@else{{ old('telephone') }}@endif" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-lg-4">@lang('pages/user_profile.email')</label>
                        <div class=" col-lg-4">
                            <input class="form-control" type="email" name="email" id="email"
                                   value="@if(isset($user) && $user != null){{ $user->email }}@else{{ old('email') }}@endif" />
                        </div>
                    </div>

                    <div class="form-actions no-margin-bottom text-center col-lg-12">
                        <a class="btn btn-default btn-sm" href="{{ route('user_profile.resume') }}">@lang('general.cancel')</a>
                        <input type="submit" value="@lang('general.save')" class="btn btn-primary">
                    </div>
                </form>
            </div>

        </div>
    </div>

@endsection
