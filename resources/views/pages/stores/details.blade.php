@extends('layouts.default')
@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="box">
                <header class="dark">
                    <div class="icons">
                        <i class="fa fa-building"></i>
                    </div>
                    <h5>@lang('pages/store.dataTitle')</h5>

                    @include('partials.window_options')
                </header>

                <div class="body">

                    @include('partials.msg_success')

                    @include('partials.errors')

                    <form class="form-horizontal" method="POST"
                          action="@if(isset($store) && $store != null){{ route('store.update', $store->id) }}@else{{ route('store.store') }}@endif">

                        {{ csrf_field() }}

                        <div class="form-group">
                            <label class="control-label col-lg-4" for="name">@lang('pages/store.name')</label>
                            <div class="col-lg-4">
                                <input type="text" class="form-control" name="name" id="name"
                                       value="@if(isset($store) && $store != null){{ $store->name }}@else{{ old('name') }}@endif" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-lg-4" for="rows">@lang('pages/store.rows')</label>
                            <div class="col-lg-4">
                                <input type="number" class="form-control" name="rows" id="rows"
                                       value="@if(isset($store) && $store != null){{ $store->rows }}@else{{ old('rows') }}@endif" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-lg-4" for="columns">@lang('pages/store.columns')</label>
                            <div class="col-lg-4">
                                <input type="number" class="form-control" name="columns" id="columns"
                                       value="@if(isset($store) && $store != null){{ $store->columns }}@else{{ old('columns') }}@endif" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-lg-4" for="longitude">@lang('pages/store.longitude')</label>
                            <div class="col-lg-4">
                                <input type="number" class="form-control" name="longitude" id="longitude"
                                       value="@if(isset($store) && $store != null){{ $store->longitude }}@else{{ old('longitude') }}@endif" />
                            </div>
                        </div>

                        <div class="form-actions no-margin-bottom text-center">
                            <a class="btn btn-default btn-sm" href="{{ route('store.resume') }}">@lang('general.cancel')</a>
                            <input type="submit" class="btn btn-primary" value="@if(isset($store) && $store != null)@lang('general.update')@else @lang('general.save') @endif">
                        </div>
                    </form>
                </div>
            </div><!--box-->
        </div><!-- /.col-lg-12 -->
    </div><!-- /.row -->
@endsection