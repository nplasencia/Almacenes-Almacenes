@extends('layouts.default')
@section('content')

    <div class="row">
        <div class="col-lg-12">

            <div class="box">

                <div class="body collapse in">

                    @include('partials.msg_success')

                    <div class="row" style="margin-left: 0; margin-bottom: 10px;">

                        <a href="{{ route('user.create') }}" class="btn btn-success">
                            <i class="fa fa-plus-circle"></i>
                            <span class="link-title">&nbsp;@lang('pages/user.new_button')</span>
                        </a>

                    </div>

                    <table id="usersResumeTable" class="table table-bordered table-condensed table-hover table-striped sortableTable responsive-table" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th class="text-center">@lang('pages/user.name')</th>
                                <th class="text-center">@lang('pages/user.surname')</th>
                                <th class="text-center">@lang('pages/user.role')</th>
                                <th class="text-center">@lang('pages/user.telephone')</th>
                                <th class="text-center">@lang('pages/user.email')</th>
                                <th style="min-width: 62px;">&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                            <tr data-id="{{ $user->id }}" class="center">
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->surname }}</td>
                                <td>{{ trans('general.'.$user->role) }}</td>
                                <td>{{ $user->telephone }}</td>
                                <td>{{ $user->email }}</td>
                                <td align="right" style="vertical-align: middle;">
                                    <a href="{{ route('user.details', $user->id) }}" data-toggle="tooltip" data-original-title="@lang('general.edit')" data-placement="bottom" class="btn btn-success btn-xs">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <a href="{{ route('user.delete', $user->id) }}" data-toggle="tooltip" data-original-title="@lang('general.remove')" data-placement="bottom" class="btn btn-danger btn-xs btn-delete">
                                        <i class="fa fa-trash-o"></i>
                                    </a>
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
        $('#usersResumeTable').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "{!! route('user.ajaxResume') !!}",
            "fnDrawCallback": function() {
                $('[data-toggle="tooltip"]').tooltip();
            },
            columns: [
                { data: 'name', name: 'name'},
                { data: 'surname', name: 'surname'},
                { data: 'role', name: 'role'},
                { data: 'telephone', name: 'telephone'},
                { data: 'email', name: 'email'},
                { data: 'actions', name: 'actions', orderable: false, searchable: false}
            ],
            "aoColumnDefs": [
                { "sClass": "text-right" , "aTargets": [5] },
            ]
        });
    });
</script>
@endpush