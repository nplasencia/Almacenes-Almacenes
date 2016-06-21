@if (Session::has('success'))
    <div class="alert alert-success text-center fade in">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        {{ Session::get('success') }}
    </div>
@elseif(Session::has('info'))
    <div class="alert alert-info text-center fade in">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        {{ Session::get('info') }}
    </div>
@endif