<div id="transferModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">@lang('pages/pallet_article.transfer_modal_title')</h4>
            </div>

            <div class="modal-body text-center">
                <form method="POST" action="{{ route('palletArticle.transfer', ':palletArticleId') }}" id="transferForm" class="container-fluid">
                    {{ csrf_field() }}
                    <div class="row form-group" id="storeInput" style="display: none;" >
                        <label class="control-label col-lg-4" for="name">@lang('pages/pallet_article.storeName')</label>
                        <div class="col-lg-6">
                            <select data-placeholder="@lang('pages/pallet_article.selectStore')" class="form-control" name="store_id" id="storeSelect" required>
                                <option value="" disabled selected></option>
                                @foreach($stores as $store)
                                    <option value="{{ $store->id }}">{{ $store->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row form-group" id="locationInput" style="display: none;" >
                        <label class="control-label col-lg-4" for="name">@lang('pages/pallet_article.location')</label>
                        <div class="col-lg-6">
                            <select class="form-control" name="location" id="locationSelect" disabled required>
                                <option value="" disabled selected>Selecciona primero el almacén ...</option>
                            </select>
                        </div>
                    </div>

                    <div class="row form-group" id="palletInput" style="display: none;" >
                        <label class="control-label col-lg-4" for="name">@lang('general.palletType')</label>
                        <div class="col-lg-6">
                            <select class="form-control" name="palletType_id" id="palletTypeSelect">
                                <option value="" disabled selected>Selecciona el tipo de palé ...</option>
                                <option value="1">Americano</option>
                                <option value="2">Europeo</option>
                            </select>
                        </div>
                    </div>

                    <div class="row form-group">
                        <label class="control-label col-lg-4" for="name">@lang('pages/pallet_article.number')</label>
                        <div class="col-lg-6">
                            <input type="number" class="form-control text-right" name="number" id="number" min="1" value="" required/>
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

@push('scripts')
    <script>

        (function( $ ){
            $.fn.formCreate = function() {
                var id = $(this).parents('tr').data('id');
                var formAction = $('#transferForm').attr('action').replace(':palletArticleId', id);
                $('#transferForm').attr('action', formAction);

                var max = $(this).parents('tr').data('max');
                $('#transferForm').find('#number').attr('max', max);
                var number = $(this).parents('tr').data('number');
                $('#transferForm').find('#number').attr('value', number);
                return this;
            };
        })( jQuery );

        $(document).ready(function () {

            $('.btn-transfer').click(function () {
                $('#storeInput').show();
                $('#locationInput').show();
                $('#storeSelect').prop('required', 'required');
                $('#locationSelect').prop('required', 'required');

                $(this).formCreate();
            });

            $('.btn-picking').click(function() {
                $('#storeInput').hide();
                $('#locationInput').hide();
                $('#palletInput').hide();
                $('#storeSelect').prop('required', false);
                $('#locationSelect').prop('required', false);
                $('#palletSelect').prop('required', false);

                $(this).formCreate();
            });


            $('#storeSelect').change(function(e) {
                e.preventDefault();
                var form = $('#formArticleLocations');
                var locationSelect = $('#locationSelect');

                var action = form.attr('action').replace(':store_id', $(this).val());
                $(this).prop('disabled', 'disabled');
                $.post(action, form.serialize(), function (response) {
                    locationSelect.find('option').remove();
                    locationSelect.append('<option value="" disabled selected>Selecciona una ubicación ...</option>');
                    $.each(response, function(i, v){
                        locationSelect.append('<option value="' + v[0] + '">' + v[1] + '</option>');
                    })
                    locationSelect.prop('disabled', false);
                }).fail(function(response){
                    alert("Ha existido algún fallo al recoger las localizaciones");
                });
                $(this).prop('disabled', false);

            });

            $('#locationSelect').change(function(e) {
                e.preventDefault();

                $selectedStoreId = $(this).val();
                if ($selectedStoreId.indexOf(":0")>=0) {
                    $('#palletInput').show();
                    $('#palletSelect').prop('required', 'required');
                } else {
                    $('#palletInput').hide();
                    $('#palletSelect').prop('required', false);
                }

            });
        });
    </script>
@endpush