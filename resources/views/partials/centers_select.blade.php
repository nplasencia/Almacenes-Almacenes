<div class="topnav" style="text-align: left;">
    <form class="form-horizontal" method="POST" action="{{ route('center.change') }}" style="color: #9d9d9d;">
        {{ csrf_field() }}
        <label class="control-label" for="center_id">@lang('general.centerSelect')</label>
        <select data-placeholder="@lang('general.centerSelectText')" class="form-control chosen-select" name="center_id" id="center_id">
            <option disabled="disabled" value=""></option>
            @foreach($centersSelect as $center)
                <option value="{{ $center->id }}"
                    @if(session('center_id') == $center->id)
                        selected="selected"
                    @endif
                >{{ $center->name }}</option>
            @endforeach
        </select>
        <input type="submit" class="hidden" id="changeCenterButton">
    </form>
</div>