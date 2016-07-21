@extends('layouts.default')
@section('content')

    <div class="row">
        <div class="col-lg-12">

            <div class="box">

                <div class="body collapse in">

                    @include('partials.msg_success')

                    <table id="palletsResumeTable" class="table table-bordered table-condensed table-hover table-striped sortableTable responsive-table" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th class="text-center">@lang('pages/pallets.position')</th>
                            <th class="text-center">@lang('pages/pallets.totalSpace')</th>
                            <th class="text-center">@lang('pages/pallets.usedSpace')</th>
                            <th class="text-center">@lang('pages/pallets.emptySpace')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($positions as $position => $values)
                            <tr data-id="{{ $position }}" class="center">
                                <td class="text-center">{{ $position }}</td>
                                <td class="text-center">{{ $values['total'] }}</td>
                                <td class="text-center">{{ $values['used'] }}</td>
                                <td class="text-center">{{ $values['empty'] }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
@endsection