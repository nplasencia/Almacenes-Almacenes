@extends('layouts.default')

@section('content')

    <div class="row">
        <div class="col-lg-12">
            @foreach($viewArray as $titleBox => $articles)

                @if (sizeof($articles) > 0)
                    <div class="box">
                        <header class="dark">
                            <div class="icons">
                                <i class="fa fa-cubes"></i>
                            </div>
                            <h5>@lang($titleBox)</h5>
                            @include('partials.window_options')
                        </header>

                        <div class="body collapse in">
                            <table class="table table-bordered table-condensed table-hover table-striped sortableTable responsive-table jsDataTables" cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th class="text-center">@lang('pages/pallet_article.lot')</th>
                                    <th class="text-center">@lang('pages/article.name')</th>
                                    <th class="text-center">@lang('pages/pallet_article.number')</th>
                                    <th class="text-center">@lang('pages/pallet_article.storeName')</th>
                                    <th class="text-center">@lang('pages/pallet_article.location')</th>
                                    <th class="text-center">@lang('pages/pallet_article.position')</th>
                                    <th class="text-center">@lang('pages/pallet_article.registeredDate')</th>
                                    <th class="text-center">@lang('pages/pallet_article.expirationDate')</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($articles as $article)
                                        <tr class="center">
                                            <td class="text-center">{{ $article->lot}}</td>
                                            <td class="text-center">{{ $article->name }}</td>
                                            <td class="text-center">{{ $article->number }}</td>
                                            <td class="text-center">{{ $article->storeName }}</td>
                                            <td class="text-center">{{ $article->location }}</td>
                                            <td class="text-center">{{ $article->position }}</td>
                                            <td class="text-center">{{ $article->created_at }}</td>
                                            <td class="text-center">{{ $article->expiration }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif

            @endforeach
        </div>
    </div>

@stop

@push('scripts')
    <script src="{{ asset('/assets/js/datatables.min.js') }}"></script>

    <script>
        $(function() {
            $('.jsDataTables').DataTable({
                "order": [[ 7, "asc" ]]
            });
        });
    </script>
@endpush
