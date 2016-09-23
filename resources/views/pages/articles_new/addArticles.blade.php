@extends('layouts.default')

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="box">
                <header class="dark">
                    <div class="icons">
                        <i class="fa fa-tasks"></i>
                    </div>
                    <h5>@lang('pages/article_new.pallet_title')</h5>

                    @include('partials.window_options')
                </header>

                <div class="body collapse in" style="min-height: 233px;">
                    @include('partials.errors')

                    <form class="form-horizontal" method="POST" action="{{ route('articlesNew.storeNewPallet') }}">

                        {{ csrf_field() }}

                        <div class="form-group">
                            <label class="control-label col-lg-4" for="store_id">@lang('pages/pallet_article.storeName')</label>
                            <div class="col-lg-4">
                                <select data-placeholder="@lang('pages/pallet_article.selectStores')" class="form-control" name="store_id" id="storeSelect" required>
                                    <option value=""></option>
                                    @foreach($stores as $store)
                                        <option value="{{ $store->id }}"
                                            @if( old('store_id') == $store->id ) selected="selected" @endif
                                        >{{ $store->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group" id="locationInput">
                            <label class="control-label col-lg-4" for="location">@lang('pages/pallet_article.location')</label>
                            <div class="col-lg-4">
                                <select class="form-control" name="location" id="locationSelect" disabled required>
                                    <option value="" disabled selected>Selecciona primero el almacén ...</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-lg-4" for="pallet_id">@lang('general.palletType')</label>
                            <div class="col-lg-4">
                                <select data-placeholder="Selecciona el tipo de palé ..." class="form-control" name="pallet_type_id" id="pallet_type_id">
                                    <option value=""></option>
                                    @foreach($palletTypes as $pallet)
                                        <option value="{{ $pallet->id }}"
                                                @if( old('pallet_id') == $pallet->id ) selected="selected" @endif
                                        >{{ $pallet->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-actions no-margin-bottom text-center">
                            <a class="btn btn-default btn-sm" href="{{ back() }}">@lang('general.cancel')</a>
                            <input type="submit" class="btn btn-primary" value="@lang('general.next')">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <form id="formLocations" method="POST" action="{{ route('storePallet.palletLocations', ':store_id') }}">
        {{ csrf_field() }}
    </form>
@stop

@push('scripts')
    <script src="{{ asset('/assets/js/datatables.min.js') }}"></script>

    <script>
        $(function() {
            $('#articlesNextExpirationResumeTable').DataTable({
                "order": [[ 7, "asc" ]]
            });
        });

        $(document).ready(function () {

            $('#storeSelect').change(function (e) {
                e.preventDefault();
                var form = $('#formLocations');
                var locationSelect = $('#locationSelect');

                var action = form.attr('action').replace(':store_id', $(this).val());
                $(this).prop('disabled', 'disabled');
                $.post(action, form.serialize(), function (response) {
                    locationSelect.find('option').remove();
                    locationSelect.append('<option value="" disabled selected>Selecciona una ubicación ...</option>');
                    $.each(response, function (i, v) {
                        locationSelect.append('<option value="' + v + '">' + v + '</option>');
                    });
                    locationSelect.prop('disabled', false);
                }).fail(function (response) {
                    alert("Ha existido algún fallo al recoger las localizaciones");
                });
                $(this).prop('disabled', false);

            });
        });

    </script>
@endpush
