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

                    </div>

                    <table id="centersResumeTable" class="table table-bordered table-condensed table-hover table-striped sortableTable responsive-table" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th class="text-center">@lang('pages/center.name')</th>
                            <th class="text-center">@lang('pages/center.address')</th>
                            <th class="text-center">@lang('pages/center.postalCode')</th>
                            <th class="text-center">@lang('pages/center.municipality')</th>
                            <th class="text-center">@lang('pages/center.island')</th>
                            <th class="text-center">@lang('pages/store.emptySpaces')</th>
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
                                <td class="text-center">{{ $center->emptySpace() }}</td>
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

                </div>
            </div>
        </div>
    </div>
@stop
@push('scripts')
<script src="{{ asset('/assets/js/datatables.min.js') }}"></script>

<script>
    $(function() {
        $('#centersResumeTable').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "{!! route('center.ajaxResume') !!}",
            "fnDrawCallback": function() {
                $('[data-toggle="tooltip"]').tooltip();
            },
            columns: [
                { data: 'name', name: 'name'},
                { data: 'address', name: 'address'},
                { data: 'postalCode', name: 'postalCode'},
                { data: 'municipality.name', name: 'municipality.name'},
                { data: 'municipality.island.name', name: 'municipality.island.name'},
                { data: 'emptySpace', searchable: false},
                { data: 'actions', name: 'actions', orderable: false, searchable: false}
            ],
            "aoColumnDefs": [
                { "sClass": "text-right" , "aTargets": [6] },
                { "sClass": "text-center", "aTargets": [5] }
            ]
        });
    });
</script>
@endpush