<!DOCTYPE html>
<html class="no-js">
<head>
    @include('partials.head')
</head>

<body class="  ">
<div class="bg-dark dk" id="wrap">
    <div id="top">
        @include('partials.header')
    </div>
    <div id="left">
        @include('partials.menu_user')

        {!! Html::menu('menu.items') !!}
    </div>

    <div id="content">
        <div class="outer">
            <div class="inner bg-light lter" style="min-height: 357px;">
                <div class="row">
                    <div class="col-lg-12">

                        @yield('content')

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('partials.footer')
</body>
</html>