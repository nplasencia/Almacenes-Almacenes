@extends('layouts.default')
@section('content')

    <div class="row">
        <div class="col-lg-12">

            <div class="box">

                <div class="body collapse in">

                    @include('partials.msg_success')

                    <table id="articlesResumeTable" class="table table-bordered table-condensed table-hover table-striped sortableTable responsive-table" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th class="text-center">@lang('pages/article.name')</th>
                            <th class="text-center">@lang('pages/article.subgroup')</th>
                            <th class="text-center">@lang('pages/article.group')</th>
                            <th class="text-center">@lang('pages/pallet.name')</th>
                            <th style="min-width: 62px;">&nbsp;</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($articles as $article)
                            <tr class="center">
                                <td class="text-center">{{ $article->name }}</td>
                                <td class="text-center">{{ $article->groupName }}</td>
                                <td class="text-center">{{ $article->subgroup }}</td>
                                <td class="text-center">{{ $article->sum }}</td>

                                <td align="right" style="vertical-align: middle;">
                                    <div class="btn-group">
                                        <a href="{{ route('article.details', $article->id) }}" data-toggle="tooltip" data-original-title="@lang('general.edit')" data-placement="bottom" class="btn btn-success btn-xs">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                    </div>
                                    <div class="btn-group">
                                        <a href="{{ route('article.delete', $article->id) }}" data-toggle="tooltip" data-original-title="@lang('general.remove')" data-placement="bottom" class="btn btn-danger btn-xs btn-delete">
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
        $('#articlesResumeTable').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "{!! route('palletArticle.ajaxResume') !!}",
            "fnDrawCallback": function() {
                $('[data-toggle="tooltip"]').tooltip();
            },
            columns: [
                { data: 'name', name: 'name'},
                { data: 'groupName', name: 'groupName'},
                { data: 'subgroup', name: 'subgroup'},
                { data: 'sum', name: 'sum', searchable: false},
                { data: 'actions', name: 'actions', orderable: false, searchable: false}
            ],
            "aoColumnDefs": [
                { "sClass": "text-right" , "aTargets": [4] },
                { "sClass": "text-center", "aTargets": [0,1,2,3] }
            ]
        });
    });
</script>
@endpush