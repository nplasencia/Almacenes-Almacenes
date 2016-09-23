@extends('layouts.default')
@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="box">
                <header class="dark">
                    <div class="icons">
                        <i class="fa fa-user"></i>
                    </div>
                    <h5>@lang('pages/user.data_title')</h5>

                    @include('partials.window_options')
                </header>

                <div class="body">

                    @include('partials.msg_success')

                    @include('partials.errors')

                    <form class="form-horizontal" method="POST"
                          action="@if(isset($user) && $user != null){{ route('user.update', $user->id) }}@else{{ route('user.store') }}@endif">

                        {{ csrf_field() }}

                        <div class="form-group">
                            <label class="control-label col-lg-4" for="name">@lang('pages/user.name')</label>
                            <div class="col-lg-4">
                                <input class="form-control" type="text" name="name" id="name" required
                                       value="@if(isset($user) && $user != null){{ $user->name }}@else{{ old('name') }}@endif" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-lg-4" for="surname">@lang('pages/user.surname')</label>
                            <div class=" col-lg-4">
                                <input class="form-control" type="text" name="surname" id="surname" required
                                       value="@if(isset($user) && $user != null){{ $user->surname }}@else{{ old('surname') }}@endif" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-lg-4" for="role">@lang('pages/user.role')</label>
                            <div class=" col-lg-4">
                                <select class="form-control chosen-select" name="role" id="roleSelect" required>
                                    <option value="" disabled selected>@lang('pages/user.select_role')</option>
                                    @foreach($roles as $role)
                                        <option value="{{ $role }}"
                                                @if(isset($user) && $user != null)
                                                    @if( $user->role == $role ) selected="selected" @endif
                                                @else
                                                    @if( old('role') == $role ) selected="selected" @endif
                                                @endif
                                        >@lang('general.'.$role)</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        @if(Auth::user()->role == 'SuperAdmin')
                            <div class="form-group" id="centerSelect" style="display: none;">
                                <label class="control-label col-lg-4" for="center_id">@lang('pages/user.center')</label>
                                <div class=" col-lg-4">
                                    <select class="form-control" name="center_id" id="centerSelect">
                                        <option value="" disabled selected>@lang('pages/user.select_center')</option>
                                        @foreach($centers as $center)
                                            <option value="{{ $center->id }}"
                                                    @if(isset($user) && $user != null)
                                                    @if( $user->center_id == $center->id ) selected="selected" @endif
                                                    @else
                                                    @if( old('center_id') == $center->id ) selected="selected" @endif
                                                    @endif
                                            >{{ $center->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @endif

                        <div class="form-group">
                            <label class="control-label col-lg-4" for="telephone">@lang('pages/user.telephone')</label>
                            <div class=" col-lg-4">
                                <input class="form-control" type="tel" name="telephone" id="telephone"
                                       value="@if(isset($user) && $user != null){{ $user->telephone }}@else{{ old('telephone') }}@endif" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-lg-4" for="email">@lang('pages/user.email')</label>
                            <div class=" col-lg-4">
                                <input class="form-control" type="email" name="email" id="email" required
                                       value="@if(isset($user) && $user != null){{ $user->email }}@else{{ old('email') }}@endif" />
                            </div>
                        </div>

                        <div class="form-actions no-margin-bottom text-center">
                            <a class="btn btn-default btn-sm" href="{{ route('users.resume') }}">@lang('general.cancel')</a>
                            <input type="submit" class="btn btn-primary" value="@if(isset($user) && $user != null)@lang('general.update')@else @lang('general.save') @endif">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

@push('scripts')
<script>
    $(document).ready(function () {
        $('#roleSelect').change(function(e) {
            e.preventDefault();
            var selectedRole = $(this).val();
            if (selectedRole != 'SuperAdmin') {
                $('#centerSelect').show();
            } else {
                $('#centerSelect').hide();
            }
        });
    });
</script>
@endpush