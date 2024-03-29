<?php 

namespace Nodefortytwo\Editable;

use Illuminate\Support\ServiceProvider;
use Illuminate\View\Environment;

class EditableServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;




	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package('nodefortytwo/editable');

		include __DIR__.'/../../filters.php';
		include __DIR__.'/../../routes.php';
		
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array();
	}

}
