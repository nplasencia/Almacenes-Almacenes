@extends('layouts.default')

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="box">
                <header class="dark">
                    <div class="icons">
                        <i class="fa fa-tasks"></i>
                    </div>
                    <h5>@lang('pages/article_new.add_articles_title')</h5>

                    @include('partials.window_options')
                </header>

                <div class="body collapse in" style="min-height: 233px;">
                    @include('partials.msg_success')
                    @include('partials.errors')

                    <form class="form-horizontal" method="POST" action="{{ route('articlesNew.storeArticlesToPallet', $pallet->id) }}">

                        {{ csrf_field() }}

                        <div class="form-group">
                            <label class="control-label col-lg-4" for="lot">@lang('pages/pallet_article.lot')</label>
                            <div class="col-lg-4">
                                <select data-placeholder="@lang('pages/article_new.select_lot')" class="form-control chosen-select" name="lot" id="lotSelect" required>
                                    <option value=""></option>
                                    @foreach($lots as $lot)
                                        <option value="{{ $lot }}"
                                                @if( old('lot') == $lot ) selected="selected" @endif
                                        >{{ $lot }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group" id="articleInput">
                            <label class="control-label col-lg-4" for="newArticle_id">@lang('pages/article_new.article')</label>
                            <div class="col-lg-4">
                                <select class="form-control" name="newArticle_id" id="newArticleSelect" disabled required>
                                    <option value="" disabled selected>Selecciona primero el lote ...</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-lg-4" for="number">@lang('pages/article_new.number')</label>
                            <div class="col-lg-4">
                                <input type="number" min="1" class="form-control" name="number" id="numberInput" disabled required placeholder="Selecciona primero el lote ...">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-lg-4" for="weight">@lang('pages/article_new.weight')</label>
                            <div class="col-lg-4">
                                <input type="number" min="0" step="0.1" class="form-control" name="weight" id="weightInput" disabled required placeholder="Selecciona primero el lote ...">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-lg-4" for="totalWeight">@lang('pages/article_new.total_weight')</label>
                            <div class="col-lg-4">
                                <input type="number" class="form-control" name="totalWeight" id="totalWeightInput" disabled value="0.0">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-lg-4" for="expiration">@lang('pages/article_new.expiration')</label>
                            <div class=" col-lg-4">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    <input data-provide="datepicker" class="form-control" type="text" name="expiration" id="expiration"
                                           value="{{ old('expiration') }}" placeholder="Selecciona primero el lote ..." disabled required>
                                </div>
                            </div>
                        </div>

                        <div class="form-actions no-margin-bottom text-center">
                            <a class="btn btn-default btn-sm" href="{{ back() }}">@lang('general.cancel')</a>
                            <input type="submit" class="btn btn-primary" value="@lang('general.add')">
                        </div>
                    </form>
                </div>
            </div>

            @if($pallet->articles->count() > 0)
                <div class="box">
                    <header class="dark">
                        <div class="icons">
                            <i class="fa fa-tasks"></i>
                        </div>
                        <h5>@lang('pages/article_new.articles_added_title',['storeName' => $pallet->store->name, 'location' => $pallet->location])</h5>

                        @include('partials.window_options')
                    </header>

                    <div class="body collapse in" style="min-height: 233px;">
                        <table class="table table-bordered table-condensed table-hover table-striped sortableTable responsive-table" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th class="text-center">@lang('pages/pallet_article.lot')</th>
                                <th class="text-center">@lang('pages/pallet_article.article')</th>
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
                            @foreach($pallet->articles as $article)
                                <tr data-id="{{ $pallet->id }}" data-number="{{ $pallet->number }}" data-max="{{ $pallet->number }}" class="center">
                                    <td class="text-center">{{ $article->pivot->lot }}</td>
                                    <td class="text-center">{{ $article->name }}</td>
                                    <td class="text-center">{{ $pallet->location }}</td>
                                    <td class="text-center">{{ $pallet->position }}</td>
                                    <td class="text-center">{{ $article->pivot->number }}</td>
                                    <td class="text-center">{{ $article->pivot->totalWeight }}</td>
                                    <td class="text-center">{{ $article->pivot->created_at }}</td>
                                    <td class="text-center">{{ $article->pivot->expiration }}</td>
                                    <td align="right">

                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

        </div>
    </div>

    <form id="formNewArticles" method="POST" action="{{ route('articlesNew.newArticles', ':lot') }}">
        {{ csrf_field() }}
    </form>
@stop

@push('scripts')
    <script src="{{ asset('assets/js/datepicker.min.js') }}"></script>

    <script>
        $(function() {
            /*$('#articlesNextExpirationResumeTable').DataTable({
                "order": [[ 7, "asc" ]]
            });*/


        });

        (function( $ ) {
            $.fn.totalWeightCalc = function() {
                var numberInput = $('#numberInput');
                var weightInput = $('#weightInput');
                var totalWeightInput = $('#totalWeightInput');

                var num = numberInput.val() * weightInput.val();
                totalWeightInput.val(num.toFixed(2));
            };
        })( jQuery );

        $(document).ready(function () {

            $('#expiration').datepicker({  minDate: 0 });

            $('#lotSelect').change(function (e) {
                e.preventDefault();
                var form = $('#formNewArticles');
                var newArticleSelect = $('#newArticleSelect');

                var action = form.attr('action').replace(':lot', $(this).val());
                $(this).prop('disabled', 'disabled');
                $.post(action, form.serialize(), function (response) {
                    newArticleSelect.find('option').remove();
                    newArticleSelect.append('<option value="" disabled selected>Selecciona la mercancía ...</option>');
                    $.each(response, function (i, v) {
                        newArticleSelect.append('<option data-max="' + v[2] + '" value="' + v[0] + '">' + v[1] + '</option>');
                    });
                    newArticleSelect.prop('disabled', false);
                    $('#numberInput').prop('disabled', 'disabled');
                    $('#numberInput').prop('placeholder', 'Selecciona primero la mercancía');
                    $('#weightInput').prop('disabled', 'disabled');
                    $('#weightInput').prop('placeholder', 'Selecciona primero la mercancía');
                    $('#expiration').prop('disabled', 'disabled');
                    $('#expiration').prop('placeholder', 'Selecciona primero la mercancía');
                }).fail(function (response) {
                    alert("Ha existido algún fallo al recoger la mercancía del lote seleccionado");
                });
                $(this).prop('disabled', false);

            });

            $('#newArticleSelect').change(function (e) {
                e.preventDefault();

                var numberInput = $('#numberInput');
                var max = $(this).find(':selected').data('max');
                numberInput.prop('disabled', false);
                numberInput.removeAttr('placeholder');
                numberInput.attr('max', max);
                numberInput.val(max);

                var weightInput = $('#weightInput');
                weightInput.prop('disabled', false);
                weightInput.val(0);

                var expirationDate = $('#expiration');
                expirationDate.prop('disabled', false);
                expirationDate.removeAttr('placeholder');
                expirationDate.val('');
            });

            $('#numberInput').change(function (e) {
                e.preventDefault();
                $(this).totalWeightCalc();
            });

            $('#weightInput').change(function (e) {
                e.preventDefault();
                $(this).totalWeightCalc();
            });

        });

    </script>
@endpush
