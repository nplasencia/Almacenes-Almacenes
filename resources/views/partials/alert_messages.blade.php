@if(sizeof($alert_messages) > 0)
    <a data-placement="bottom" data-original-title="{{ trans('general.alert_message', ['ItemsCount' => sizeof($alert_messages)]) }}" href="{{ route('articlesNew.addPallet') }}" data-toggle="tooltip" class="btn btn-default btn-sm">
        <i class="fa fa-comments"></i>
        <span class="label label-danger">{{ sizeof($alert_messages) }}</span>
    </a>
@endif
