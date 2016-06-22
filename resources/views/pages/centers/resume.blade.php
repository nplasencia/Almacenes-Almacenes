@extends('layouts.default')
@section('content')

    <div class="row">
        <div class="col-lg-12">

            <div class="box">

                <div class="body collapse in">

                    @include('partials.msg_success')

                    <div class="row" style="margin-left: 0; margin-bottom: 10px;">

                        <a href="{{ route('center.create') }}" class="btn btn-success">
                            <i class="fa fa-plus-circle"></i>
                            <span class="link-title">&nbsp;@lang('pages/center.newButton')</span>
                        </a>

                        @include('partials.searchbox')
                    </div>

                    <table id="dataTable" class="table table-bordered table-condensed table-hover table-striped sortableTable responsive-table">
                        <thead>
                        <tr>
                            <th class="text-center">@lang('pages/center.name')</th>
                            <th class="text-center">@lang('pages/center.address')</th>
                            <th class="text-center">@lang('pages/center.postalCode')</th>
                            <th class="text-center">@lang('pages/center.municipality')</th>
                            <th class="text-center">@lang('pages/center.island')</th>
                            <th style="min-width: 62px;">&nbsp;</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($centers as $center)
                            <tr data-id="{{ $center->id }}" class="center">
                                <td>{{ $center->name }}</td>
                                <td>{{ $center->address }}</td>
                                <td>{{ $center->postalCode }}</td>
                                <td>{{ $center->municipality->name }}</td>
                                <td>{{ $center->municipality->island->name }}</td>
                                <td align="right" style="vertical-align: middle;">
                                    <div class="btn-group">
                                        <a href="{{ route('center.details', $center->id) }}" data-toggle="tooltip" data-original-title="@lang('general.edit')" data-placement="bottom" class="btn btn-success btn-xs">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                    </div>
                                    <div class="btn-group">
                                        <a href="{{ route('center.delete', $center->id) }}" data-toggle="tooltip" data-original-title="@lang('general.remove')" data-placement="bottom" class="btn btn-danger btn-xs btn-delete">
                                            <i class="fa fa-trash-o"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    @include ('partials.pagination')
                </div>
            </div>
        </div>
    </div>
@endsection