<style>
    .SearchIcon
    {
        color:#fff;

    }
    .SearchButton
    {
        background-color:#3a3a3a;
        border-radius:1px;
    }
    .SearchButton:hover{
        background-color:#6e6e6e;
    }

    .SearchBar{
        margin: 0px 0px 10px;
    }
</style>


<div class="col-lg-3 pull-right">
    {!! Form::open(['route' => $searchRoute, 'method' => 'POST', 'class' => 'search-form']) !!}
        <div class="input-group">
            <input type="text" class="form-control SearchBar" placeholder="Buscar" name="item" value="{{ old('item') }}">
            <span class="input-group-btn">
                <button class="btn btn-defaul SearchButton" type="submit">
                    <span class=" glyphicon glyphicon-search SearchIcon" ></span>
                </button>
            </span>
        </div><!-- /input-group -->
    {!! Form::close() !!}
</div><!-- /.col-lg-6 -->