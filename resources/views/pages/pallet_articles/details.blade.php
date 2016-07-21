@extends('layouts.default')
@section('content')

    <div class="row">
        <div class="col-lg-12">

            <div class="box">

                <header class="dark">
                    <div class="icons">
                        <i class="fa fa-cubes"></i>
                    </div>
                    <h5>Posiciones de la mercancía</h5>

                    @include('partials.window_options')
                </header>

                <div class="body collapse in">

                    @include('partials.msg_success')

                    <table class="table table-bordered table-condensed table-hover table-striped sortableTable responsive-table" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th class="text-center">@lang('pages/pallet_article.lot')</th>
                            <th class="text-center">@lang('pages/pallet_article.number')</th>
                            <th class="text-center">@lang('pages/pallet_article.weight')</th>
                            <th class="text-center">@lang('pages/pallet_article.storeName')</th>
                            <th class="text-center">@lang('pages/pallet_article.location')</th>
                            <th class="text-center">@lang('pages/pallet_article.position')</th>
                            <th class="text-center">@lang('pages/pallet_article.registeredDate')</th>
                            <th class="text-center">@lang('pages/pallet_article.expirationDate')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($pallets as $pallet)
                            <tr class="center">
                                <td class="text-center">{{ $pallet->lot }}</td>
                                <td class="text-center">{{ $pallet->number }}</td>
                                <td class="text-center">{{ $pallet->totalWeight }}</td>
                                <td class="text-center">{{ $pallet->storeName }}</td>
                                <td class="text-center">{{ $pallet->location }}</td>
                                <td class="text-center">{{ $pallet->position }}</td>
                                <td class="text-center">{{ $pallet->created_at }}</td>
                                <td class="text-center">{{ $pallet->expiration }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
@endsection