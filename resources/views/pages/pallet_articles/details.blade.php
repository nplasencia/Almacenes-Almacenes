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
                            <th class="text-center">@lang('pages/pallet_article.storeName')</th>
                            <th class="text-center">@lang('pages/pallet_article.location')</th>
                            <th class="text-center">@lang('pages/pallet_article.position')</th>
                            <th class="text-center">@lang('pages/pallet_article.number')</th>
                            <th class="text-center">@lang('pages/pallet_article.weight')</th>
                            <th class="text-center">@lang('pages/pallet_article.registeredDate')</th>
                            <th class="text-center">@lang('pages/pallet_article.expirationDate')</th>
                            <th style="min-width: 62px;">&nbsp;</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($pallets as $pallet)
                            <tr data-id="{{ $pallet->id }}" data-number="{{ $pallet->number }}" data-max="{{ $pallet->number }}" class="center">
                                <td class="text-center">{{ $pallet->lot }}</td>
                                <td class="text-center">{{ $pallet->storeName }}</td>
                                <td class="text-center">
                                    @if ($pallet->storeName != 'Picking'){{ $pallet->location }}@endif
                                </td>
                                <td class="text-center">
                                    @if ($pallet->storeName != 'Picking'){{ $pallet->position }}@endif
                                </td>
                                <td class="text-center">{{ $pallet->number }}</td>
                                <td class="text-center">{{ $pallet->totalWeight }}</td>
                                <td class="text-center">{{ $pallet->created_at }}</td>
                                <td class="text-center">{{ $pallet->expiration }}</td>
                                <td align="right">
                                    <span data-toggle="modal" data-target="#transferModal">
                                        <a data-toggle="tooltip" data-original-title="@lang('general.transfer')" data-placement="bottom" class="btn btn-warning btn-xs btn-transfer">
                                            <i class="fa fa-exchange"></i>
                                        </a>
                                    </span>
                                    @if ($pallet->storeName != 'Picking')
                                        <span data-toggle="modal" data-target="#transferModal">
                                            <a data-toggle="tooltip" data-original-title="@lang('general.picking')" data-placement="bottom" class="btn btn-danger btn-xs btn-picking">
                                                <i class="fa fa-sign-out"></i>
                                            </a>
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
@stop
@push('modals')

    @include('modals.article_transfer')

@endpush