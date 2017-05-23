<?php

namespace Domain\Commander;

use Illuminate\Support\ServiceProvider;

class CommanderServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
        $this->registerCommandTranslator();

        $this->registerCommandBus();
    }

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return ['commander'];
	}

    protected function registerCommandTranslator()
    {
        $this->app->bind('Domain\Commander\CommandTranslator', 'Domain\Commander\BasicCommandTranslator');
    }

    protected function registerCommandBus()
    {
        $this->app->bindShared('Domain\Commander\CommandBus', function () {
            return $this->app->make('Domain\Commander\ValidationCommandBus');
        });
    }

}
