@extends('layouts.default')
@section('content')

    <div class="row">
        <div class="col-lg-12">

            @foreach($storesLocations as $storeName => $locations)
                <div class="box">

                    <header class="dark">
                        <div class="icons">
                            <i class="fa fa-th"></i>
                        </div>
                        <h5>Huecos libres del almacén {{ $storeName }}</h5>

                        @include('partials.window_options')
                    </header>

                    <div class="body collapse in">

                        @include('partials.msg_success')

                        <table class="table table-bordered table-condensed table-hover table-striped sortableTable responsive-table" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th class="text-center">@lang('pages/pallets.position')</th>
                                <th class="text-center">@lang('pages/pallets.totalSpace')</th>
                                <th class="text-center">@lang('pages/pallets.usedSpace')</th>
                                <th class="text-center">@lang('pages/pallets.emptySpace')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($locations as $location => $values)
                                <tr data-id="{{ $location }}" class="center">
                                    <td class="text-center">{{ $location }}</td>
                                    <td class="text-center">{{ $values['total'] }}</td>
                                    <td class="text-center">{{ $values['used'] }}</td>
                                    <td class="text-center">{{ $values['empty'] }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
