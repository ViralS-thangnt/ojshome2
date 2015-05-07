<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ReportServiceProvider extends ServiceProvider {

	/**
	 * Bootstrap the application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		//
	}

	/**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->bind(
            'App\Lib\Prototype\Interfaces\ReportInterface',
            'App\Lib\Prototype\DBClasses\Eloquent\EloquentReportRepository'
        );
	}

}
