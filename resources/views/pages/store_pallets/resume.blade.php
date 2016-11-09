@extends('layouts.default')
@section('content')

    <div class="row">
        <div class="col-lg-12">

            @forelse($pallets as $pallet)
                <div class="box">
                    <header class="dark">
                        <div class="icons">
                            <i class="fa fa-tasks"></i>
                        </div>
                        <h5>@lang('pages/store_pallets.box_title'){{ $pallet->position }} (Palé {{ $pallet->palletType->name }})</h5>

                        <div class="toolbar">
                            <nav style="padding: 8px;">
                                <div class="btn-group" data-id="{{ $pallet->id }}">
                                    <a data-toggle="modal" data-target="#palletTransferModal" class="btn btn-warning btn-sm btn-pallet-transfer">
                                        @lang('pages/store_pallets.transfer_button')
                                        <i class="fa fa-exchange"></i>
                                    </a>
                                </div>
                                <div class="btn-group">
                                    <form method="POST" action="{{ route('storePallets.transfer', $pallet->id) }}">
                                        {{csrf_field()}}
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            @lang('pages/store_pallets.picking_button')
                                            <i class="fa fa-sign-out"></i>
                                        </button>
                                    </form>
                                </div>
                                <a href="javascript:;" class="btn btn-default btn-xs collapse-box">
                                    <i class="fa fa-minus"></i>
                                </a>
                                <a href="javascript:;" class="btn btn-default btn-xs full-box">
                                    <i class="fa fa-expand"></i>
                                </a>
                                <a href="javascript:;" class="btn btn-danger btn-xs close-box">
                                    <i class="fa fa-times"></i>
                                </a>
                            </nav>
                        </div>
                    </header>

                    <div class="body collapse in" style="overflow-x: hidden;">

                        @include('partials.msg_success')

                        <table id="articlesResumeTable" class="table table-bordered table-condensed table-hover table-striped sortableTable responsive-table" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th class="text-center">@lang('pages/pallet_article.lot')</th>
                                <th class="text-center">@lang('pages/article.name')</th>
                                <th class="text-center">@lang('pages/article.group')</th>
                                <th class="text-center">@lang('pages/article.subgroup')</th>
                                <th class="text-center">@lang('pages/pallet_article.number')</th>
                                <th class="text-center">@lang('pages/pallet_article.weight')</th>
                                <th class="text-center">@lang('pages/pallet_article.registeredDate')</th>
                                <th class="text-center">@lang('pages/pallet_article.expirationDate')</th>
                                <th style="min-width: 62px;">&nbsp;</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($pallet->articles as $article)
                                <tr data-id="{{ $article->pivot->id }}" data-number="{{ $article->pivot->number }}" data-max="{{ $article->pivot->number }}" class="center">
                                    <td class="text-center">{{ $article->pivot->lot}}</td>
                                    <td class="text-center">{{ $article->name }}</td>
                                    <td class="text-center">{{ $article->groupName }}</td>
                                    <td class="text-center">{{ $article->subgroupName }}</td>
                                    <td class="text-center">{{ $article->pivot->number }}</td>
                                    <td class="text-center">{{ $article->pivot->weight * $article->pivot->number }}</td>
                                    <td class="text-center">{{ $article->pivot->created_at }}</td>
                                    <td class="text-center">{{ $article->pivot->expiration }}</td>

                                    <td align="right" style="vertical-align: middle;">
                                        <span data-toggle="modal" data-target="#transferModal">
                                            <a data-toggle="tooltip" data-original-title="@lang('general.transfer')" data-placement="bottom" class="btn btn-warning btn-xs btn-transfer">
                                                <i class="fa fa-exchange"></i>
                                            </a>
                                        </span>
                                        <span data-toggle="modal" data-target="#transferModal">
                                            <a data-toggle="tooltip" data-original-title="@lang('general.picking')" data-placement="bottom" class="btn btn-danger btn-xs btn-picking">
                                                <i class="fa fa-sign-out"></i>
                                            </a>
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            @empty
                @include('partials.msg_success')

                <div class="text-center" style="margin-top: 50px;">
                    <h2>No hay palés en esta ubicación</h2>
                </div>
            @endforelse
        </div>
    </div>

    <form id="formLocations" method="POST" action="{{ route('storePallet.palletLocations', ':store_id') }}">
        {{ csrf_field() }}
    </form>

    <form id="formArticleLocations" method="POST" action="{{ route('palletArticle.articleLocations', ':store_id') }}">
        {{ csrf_field() }}
        <input type="hidden" value="" name="store_id">
    </form>
@stop

@push('modals')

    @include('modals.article_transfer')

    <div id="palletTransferModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">@lang('pages/store_pallets.transfer_modal_title')</h4>
                </div>

                <div class="modal-body text-center">
                    <form method="POST" action="{{ route('storePallets.transfer', ':palletId') }}" id="palletTransferForm" class="container-fluid">
                        {{ csrf_field() }}
                        <div class="row form-group" id="storeInput">
                            <label class="control-label col-lg-4" for="name">@lang('pages/pallet_article.storeName')</label>
                            <div class="col-lg-6">
                                <select data-placeholder="@lang('pages/pallet_article.selectStore')" class="form-control" name="store_id" id="storePalletSelect" required>
                                    <option value="" disabled selected></option>
                                    @foreach($stores as $store)
                                        <option value="{{ $store->id }}">{{ $store->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row form-group" id="locationInput">
                            <label class="control-label col-lg-4" for="name">@lang('pages/pallet_article.location')</label>
                            <div class="col-lg-6">
                                <select class="form-control" name="location" id="locationPalletSelect" disabled required>
                                    <option value="" disabled selected>Selecciona primero el almacén ...</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <button type="submit" class="btn btn-default">Traspasar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endpush

@push('scripts')
    <script>
        $(document).ready(function () {

            $('.btn-pallet-transfer').click(function () {
                var id = $(this).parent('div').data('id');
                var formAction = $('#palletTransferForm').attr('action').replace(':palletId', id);
                $('#palletTransferForm').attr('action', formAction);
            });

            $('#storePalletSelect').change(function(e) {
                e.preventDefault();
                var form = $('#formLocations');
                var locationSelect = $('#locationPalletSelect');

                var action = form.attr('action').replace(':store_id', $(this).val());
                $(this).prop('disabled', 'disabled');
                $.post(action, form.serialize(), function (response) {
                    locationSelect.find('option').remove();
                    locationSelect.append('<option value="" disabled selected>Selecciona una ubicación ...</option>');
                    $.each(response, function(i, v) {
                        locationSelect.append('<option value="' + v + '">' + v + '</option>');
                    });
                    locationSelect.prop('disabled', false);
                }).fail(function(response){
                    alert("Ha existido algún fallo al recoger las localizaciones");
                });
                $(this).prop('disabled', false);

            });
        });
    </script>
@endpush