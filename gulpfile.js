var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
    mix
    //.sass('app.scss')
        .copy(
            [
                'bower_components/jquery/dist/jquery.js',
                'bower_components/autosize/dist/autosize.js',
                'bower_components/bootstrap/dist/js/bootstrap.js',
                'bower_components/bootstrap-switch/dist/js/bootstrap-switch.js',
                'bower_components/bootstrap-tagsinput/dist/bootstrap-tagsinput.js',
                'bower_components/jasny-bootstrap/dist/js/jasny-bootstrap.js',
                'bower_components/screenfull/dist/screenfull.js',
                'bower_components/metisMenu/dist/metisMenu.js',

                'bower_components/chosen/chosen.jquery.js',

                'bower_components/datatables/media/js/jquery.dataTables.js',
                'bower_components/datatables/media/js/dataTables.bootstrap.js',
                'bower_components/datatables-fixedcolumns/js/dataTables.fixedColumns.js',

                'bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.js',
                'bower_components/bootstrap-datepicker/dist/locales/bootstrap-datepicker.es.min.js',

                'bower_components/moment/src/moment.js',
                'bower_components/bootstrap-daterangepicker/daterangepicker.js',

                'bower_components/jquery.uniform/lib/jquery.uniform.js',

                'bower_components/tinycolor/tinycolor.js',
                'bower_components/pick-a-color/src/js/pick-a-color.js'

            ],
            'resources/assets/js/vendor')

        .scripts(
            [
                'resources/assets/js/vendor/jquery.js',
                'resources/assets/js/vendor/autosize.js',
                'resources/assets/js/vendor/bootstrap.js',
                'resources/assets/js/vendor/bootstrap-switch.js',
                'resources/assets/js/vendor/bootstrap-tagsinput.js',
                'resources/assets/js/vendor/jasny-bootstrap.js',
                'resources/assets/js/vendor/screenfull.js',
                'resources/assets/js/vendor/metisMenu.js',
                'resources/assets/js/vendor/metisCore.js',
                'resources/assets/js/vendor/chosen.jquery.js',
                'resources/assets/js/app_defaults.js'
            ],
            'public/assets/js/app.min.js')

        .scripts(
            [
                'resources/assets/js/vendor/jquery.uniform.js'
            ],
            'public/assets/js/libs/jquery.uniform.min.js')

        .scripts(
            [
                'resources/assets/js/vendor/jquery.dataTables.js',
                'resources/assets/js/vendor/dataTables.bootstrap.js',
                'resources/assets/js/vendor/dataTables.fixedColumns.js',
                'resources/assets/js/datatable_defaults.js'
            ],
            'public/assets/js/datatables.min.js')

        .scripts(
            [
                'resources/assets/js/vendor/bootstrap-datepicker.js',
                'resources/assets/js/vendor/bootstrap-datepicker.es.min.js',
                'resources/assets/js/datepicker_defaults.js'
            ],
            'public/assets/js/datepicker.min.js')

        /*.scripts(
         [
         'resources/assets/js/vendor/moment.js',
         'resources/assets/js/vendor/daterangepicker.js'
         ],
         'public/assets/js/libs/daterangepicker.min.js')*/

        .scripts(
            [
                'resources/assets/js/vendor/tinycolor.js',
                'resources/assets/js/vendor/pick-a-color.js'
            ],
            'public/assets/js/libs/pickacolor.min.js')

        .version(
            [
                //"public/css/app.css",
                //"public/assets/js/app.min.js"
            ]
        );
});
