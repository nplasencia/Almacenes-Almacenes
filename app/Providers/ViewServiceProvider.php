<?php

namespace App\Providers;

use App\Http\ViewComposers\CenterSelectComposer;
use App\Http\ViewComposers\CenterEmptySpaceComposer;

use App\Http\ViewComposers\MessagesComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composers([
            CenterSelectComposer::class     => 'partials.centers_select',
            CenterEmptySpaceComposer::class => 'partials.center_emptySpace',
	        MessagesComposer::class         => 'partials.alert_messages'
        ]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
