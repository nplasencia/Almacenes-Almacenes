@extends('layouts.default')
@section('content')

    <div class="row">
        <div class="col-lg-12">

            <div class="box">

                <div class="body collapse in">

                    @include('partials.msg_success')

                    <div class="row" style="margin-left: 0; margin-bottom: 10px;">

                        <a href="{{ route('store.create') }}" class="btn btn-success">
                            <i class="fa fa-plus-circle"></i>
                            <span class="link-title">&nbsp;@lang('pages/store.newButton')</span>
                        </a>

                    </div>

                    <table id="storesResumeTable" class="table table-bordered table-condensed table-hover table-striped sortableTable responsive-table" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th class="text-center">@lang('pages/store.name')</th>
                            <th class="text-center">@lang('pages/store.rows')</th>
                            <th class="text-center">@lang('pages/store.columns')</th>
                            <th class="text-center">@lang('pages/store.longitude')</th>
                            <th class="text-center">@lang('pages/store.emptySpaces')</th>
                            <th style="min-width: 62px;">&nbsp;</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($stores as $store)
                            <tr data-id="{{ $store->id }}" class="center">
                                <td class="text-center">{{ $store->name }}</td>
                                <td class="text-center">{{ $store->rows }}</td>
                                <td class="text-center">{{ $store->columns }}</td>
                                <td class="text-center">{{ $store->longitude }}</td>
                                <td class="text-center">{{ $store->emptySpace() }}</td>
                                <td align="right" style="vertical-align: middle;">
                                    <div class="btn-group">
                                        <a href="{{ route('store.details', $store->id) }}" data-toggle="tooltip" data-original-title="@lang('general.edit')" data-placement="bottom" class="btn btn-success btn-xs">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                    </div>
                                    <div class="btn-group">
                                        <a href="{{ route('store.delete', $store->id) }}" data-toggle="tooltip" data-original-title="@lang('general.remove')" data-placement="bottom" class="btn btn-danger btn-xs btn-delete">
                                            <i class="fa fa-trash-o"></i>
                                        </a>
                                    </div>
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
@push('scripts')
<script src="{{ asset('/assets/js/datatables.min.js') }}"></script>

<script>
    $(function() {
        $('#storesResumeTable').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "{!! route('store.ajaxResume') !!}",
            columns: [
                { data: 'name', name: 'name'},
                { data: 'rows', name: 'rows', searchable: false},
                { data: 'columns', name: 'columns', searchable: false},
                { data: 'longitude', name: 'longitude', searchable: false},
                { data: 'emptySpace', name: 'emptySpace', searchable: false},
                { data: 'actions', name: 'actions', orderable: false, searchable: false}
            ],
            "aoColumnDefs": [
                { "sClass": "text-right" , "aTargets": [5] },
                { "sClass": "text-center", "aTargets": [1,2,3,4] }
            ]
        });
    });
</script>
@endpush