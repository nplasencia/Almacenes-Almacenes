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
                <img src="{{ asset('assets/img/logo_min.png') }}" alt="" style="margin: 13px 0px 0px 5px;">
            </a>
        </header>
        <div class="topnav">
            <div class="btn-group">
                <a data-placement="bottom" data-original-title="Fullscreen" data-toggle="tooltip" class="btn btn-default btn-sm" id="toggleFullScreen">
                    <i class="glyphicon glyphicon-fullscreen"></i>
                </a>
            </div>
            <div class="btn-group">
                <a data-placement="bottom" data-original-title="E-mail" data-toggle="tooltip" class="btn btn-default btn-sm">
                    <i class="fa fa-envelope"></i>
                    <span class="label label-warning">5</span>
                </a>
                <a data-placement="bottom" data-original-title="Messages" href="#" data-toggle="tooltip" class="btn btn-default btn-sm">
                    <i class="fa fa-comments"></i>
                    <span class="label label-danger">4</span>
                </a>
                <a data-toggle="modal" data-original-title="Help" data-placement="bottom" class="btn btn-default btn-sm" href="#helpModal">
                    <i class="fa fa-question"></i>
                </a>
            </div>
            <div class="btn-group">
                <a href="{{ route('logout') }}" data-toggle="tooltip" data-original-title="Logout" data-placement="bottom" class="btn btn-metis-1 btn-sm">
                    <i class="fa fa-power-off"></i>
                </a>
            </div>
            <div class="btn-group">
                <a data-placement="bottom" data-original-title="Show / Hide Left" data-toggle="tooltip" class="btn btn-primary btn-sm toggle-left" id="menu-toggle">
                    <i class="fa fa-bars"></i>
                </a>
                <a data-placement="bottom" data-original-title="Show / Hide Right" data-toggle="tooltip" class="btn btn-default btn-sm toggle-right"> <span class="glyphicon glyphicon-comment"></span>  </a>
            </div>
        </div>
        <div class="collapse navbar-collapse navbar-ex1-collapse">

            <!-- .nav -->
            <ul class="nav navbar-nav">
                <li>
                    <a href="#">Nuevo menú</a>
                </li>
                <li class='dropdown '>
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        Form Elements
                        <b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu">
                        <li> <a href="#">General</a>  </li>
                        <li> <a href="#">Validation</a>  </li>
                        <li> <a href="#">WYSIWYG</a>  </li>
                        <li> <a href="#">Wizard &amp; File Upload</a>  </li>
                    </ul>
                </li>
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