<?php namespace App\Providers;

use View;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider {

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function boot()
    {
        // Using class based composers...
        View::composer(['manuscripts.*', 'users.*', 'dashboard.*'], 'App\Http\ViewComposers\UserComposer');
    }

    /**
     * Register
     *
     * @return void
     */
    public function register()
    {
        //
    }

}