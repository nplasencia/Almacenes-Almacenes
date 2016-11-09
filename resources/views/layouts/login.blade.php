<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name = "author" content = "Auret - Nauzet Plasencia Cruz">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @include('partials.favicon')
    <title>@lang('auth.page_title')</title>

    <!-- Styles -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

    <link rel="stylesheet" href="{!! asset('assets/css/main.min.css') !!}">
</head>
<body class="login">

    <div class="form-signin">
        <div class="text-center">
            <img src="{{ asset('assets/img/logo.png') }}" alt="Logo">
        </div>
        <hr>
        @yield('content')
    </div>

    <div class="Footer text-center" style="border-top: 0px;">
        <p style="margin-top: -90px;">
            <a href="http://www.auret.es" target="_blank">
                <img src="{{ asset('assets/img/auret_logo.png') }}" alt="Auret Logo">
            </a>
        </p>
        <p style="margin-top: -20px;">
            &copy; {{ date('Y') }}. All rights reserved.
        </p>
    </div>

<!-- JavaScripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js" integrity="sha384-I6F5OKECLVtK/BL+8iSLDEHowSAfUo76ZL9+kGAgTRdiByINKJaqTPH/QVNS1VDb" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
{{-- <script src="{{ elixir('js/app.js') }}"></script> --}}
<script type="text/javascript">
    (function($) {
        $(document).ready(function() {
            $('.list-inline li > a').click(function() {
                var activeForm = $(this).attr('href') + ' > form';
                //console.log(activeForm);
                $(activeForm).addClass('animated fadeIn');
                //set timer to 1 seconds, after that, unload the animate animation
                setTimeout(function() {
                    $(activeForm).removeClass('animated fadeIn');
                }, 1000);
            });
        });
    })(jQuery);
</script>
</body>
</html>