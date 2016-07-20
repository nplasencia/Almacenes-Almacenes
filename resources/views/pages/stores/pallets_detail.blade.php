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
                            <th style="min-width: 62px;">&nbsp;</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($positions as $position => $values)
                            <tr data-id="{{ $position }}" class="center">
                                <td>{{ $position }}</td>
                                <td>{{ $values['total'] }}</td>
                                <td>{{ $values['used'] }}</td>
                                <td>{{ $values['empty'] }}</td>
                                <td>

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