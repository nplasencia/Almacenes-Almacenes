@extends('layouts.default')
@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="box">
                <header class="dark">
                    <div class="icons">
                        <i class="fa fa-building"></i>
                    </div>
                    <h5>@lang('pages/center.centerDataTitle')</h5>

                    @include('partials.window_options')
                </header>

                <div class="body">

                    @include('partials.msg_success')

                    @include('partials.errors')

                    <form class="form-horizontal" method="POST"
                          action="@if(isset($center) && $center != null){{ route('center.update', $center->id) }}@else{{ route('center.store') }}@endif">

                        {{ csrf_field() }}

                        <div class="form-group">
                            <label class="control-label col-lg-4" for="name">@lang('pages/center.name')</label>
                            <div class="col-lg-4">
                                <input type="text" class="form-control" name="name" id="name"
                                       value="@if(isset($center) && $center != null){{ $center->name }}@else{{ old('name') }}@endif" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-lg-4" for="municipality_id">@lang('pages/center.municipality')</label>
                            <div class="col-lg-4">
                                <select data-placeholder="@lang('pages/center.selectMunicipality')" class="form-control chzn-select" name="municipality_id" id="municipality_id">
                                    <option value=""></option>
                                    @foreach($municipalities as $municipality)
                                        <option value="{{ $municipality->id }}"
                                            @if(isset($center) && $center != null)
                                                @if( $center->municipality_id == $municipality->id ) selected="selected" @endif
                                            @else
                                                @if( old('$municipality_id') == $municipality->id ) selected="selected" @endif
                                            @endif
                                        >{{ $municipality->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-lg-4" for="address">@lang('pages/center.address')</label>
                            <div class="col-lg-4">
                                <input type="text" class="form-control" name="address" id="address"
                                       value="@if(isset($center) && $center != null){{ $center->address }}@else{{ old('address') }}@endif" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-lg-4" for="address2">@lang('pages/center.address') 2</label>
                            <div class="col-lg-4">
                                <input type="text" class="form-control" name="address2" id="address2"
                                       value="@if(isset($center) && $center != null){{ $center->address2 }}@else{{ old('address2') }}@endif" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-lg-4" for="postalCode">@lang('pages/center.postalCode')</label>
                            <div class=" col-lg-4">
                                <input class="form-control" type="number" name="postalCode" id="postalCode"
                                       value="@if(isset($center) && $center != null){{ $center->postalCode }}@else{{ old('postalCode') }}@endif">
                            </div>
                        </div>

                        <div class="form-actions no-margin-bottom text-center">
                            <a class="btn btn-default btn-sm" href="{{ route('center.resume') }}">@lang('general.cancel')</a>
                            <input type="submit" class="btn btn-primary" value="@if(isset($center) && $center != null)@lang('general.update')@else @lang('general.save') @endif">
                        </div>
                    </form>
                </div>
            </div><!--box-->
        </div><!-- /.col-lg-12 -->
    </div><!-- /.row -->
@endsection