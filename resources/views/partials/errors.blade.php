@if (count($errors) > 0)
    <div class="alert alert-danger">
        @lang('general.top_text')
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif