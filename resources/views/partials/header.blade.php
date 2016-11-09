<!-- .navbar -->
<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container-fluid">

        <!-- Brand and toggle get grouped for better mobile display -->
        <header class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a href="#" class="navbar-brand">
                <img src="{{ asset('assets/img/logo_min.png') }}" alt="" style="margin: 13px 0 0 5px;">
            </a>
        </header>
        <div class="topnav">

            @include('partials.center_emptySpace')

            <div class="btn-group">
                <a data-placement="bottom" data-original-title="@lang('general.fullScreen')" data-toggle="tooltip" class="btn btn-default btn-sm" id="toggleFullScreen">
                    <i class="glyphicon glyphicon-fullscreen"></i>
                </a>
            </div>
            <div class="btn-group">

                @include('partials.alert_messages')

                <a data-toggle="modal" data-original-title="@lang('general.help')" data-placement="bottom" class="btn btn-default btn-sm" href="#helpModal">
                    <i class="fa fa-question"></i>
                </a>
            </div>
            <div class="btn-group">
                <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>

                <a href="{{ url('/logout') }}" data-toggle="tooltip" data-original-title="@lang('general.logout')" data-placement="bottom" class="btn btn-metis-1 btn-sm"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fa fa-power-off"></i>
                </a>
            </div>
            <div class="btn-group">
                <a data-placement="bottom" data-original-title="@lang('general.showHideMenu')" data-toggle="tooltip" class="btn btn-primary btn-sm toggle-left" id="menu-toggle">
                    <i class="fa fa-bars"></i>
                </a>
                <a data-placement="bottom" data-original-title="@lang('general.showHideMenu')" data-toggle="tooltip" class="btn btn-default btn-sm toggle-right"> <span class="glyphicon glyphicon-comment"></span>  </a>
            </div>

        </div>

        @can('superAdmin')
            @include('partials.centers_select')
        @endcan

        <div class="collapse navbar-collapse navbar-ex1-collapse">

            <!-- .nav -->
            <ul class="nav navbar-nav">
                @can('superAdmin')
                    <li>
                        <a href="{{ route('center.create') }}">@lang('pages/center.newButton')</a>
                    </li>
                @endcan
                @can('admin')
                    <li>
                        <a href="{{ route('store.create') }}">@lang('pages/store.newButton')</a>
                    </li>
                @endcan
            </ul><!-- /.nav -->
        </div>
    </div><!-- /.container-fluid -->
</nav><!-- /.navbar -->
<header class="head">
    <div class="search-bar">
        <form class="main-search" action="">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Live Search ...">
                    <span class="input-group-btn">
                        <button class="btn btn-primary btn-sm text-muted" type="button">
                            <i class="fa fa-search"></i>
                        </button>
                    </span>
            </div>
        </form><!-- /.main-search -->
    </div><!-- /.search-bar -->
    <div class="main-bar">
        <h3>
            <i class="{{ $icon }}"></i>&nbsp; {{ $title }}
        </h3>
    </div>
</header><!-- /.head -->