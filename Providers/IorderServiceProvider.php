<?php

namespace Modules\Iorder\Providers;

use Illuminate\Database\Eloquent\Factory as EloquentFactory;
use Illuminate\Support\ServiceProvider;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Core\Events\BuildingSidebar;
use Modules\Core\Events\LoadingBackendTranslations;
use Modules\Iorder\Listeners\RegisterIorderSidebar;

class IorderServiceProvider extends ServiceProvider
{
    use CanPublishConfiguration;
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
        $this->registerBindings();
        $this->app['events']->listen(BuildingSidebar::class, RegisterIorderSidebar::class);

        $this->app['events']->listen(LoadingBackendTranslations::class, function (LoadingBackendTranslations $event) {
            // append translations
        });


    }

    public function boot()
    {
       
        $this->publishConfig('iorder', 'config');
        $this->publishConfig('iorder', 'crud-fields');

        $this->mergeConfigFrom($this->getModuleConfigFilePath('iorder', 'settings'), "asgard.iorder.settings");
        $this->mergeConfigFrom($this->getModuleConfigFilePath('iorder', 'settings-fields'), "asgard.iorder.settings-fields");
        $this->mergeConfigFrom($this->getModuleConfigFilePath('iorder', 'permissions'), "asgard.iorder.permissions");

        //$this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
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

    private function registerBindings()
    {
        $this->app->bind(
            'Modules\Iorder\Repositories\OrderRepository',
            function () {
                $repository = new \Modules\Iorder\Repositories\Eloquent\EloquentOrderRepository(new \Modules\Iorder\Entities\Order());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Iorder\Repositories\Cache\CacheOrderDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Iorder\Repositories\ItemRepository',
            function () {
                $repository = new \Modules\Iorder\Repositories\Eloquent\EloquentItemRepository(new \Modules\Iorder\Entities\Item());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Iorder\Repositories\Cache\CacheItemDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Iorder\Repositories\SupplyRepository',
            function () {
                $repository = new \Modules\Iorder\Repositories\Eloquent\EloquentSupplyRepository(new \Modules\Iorder\Entities\Supply());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Iorder\Repositories\Cache\CacheSupplyDecorator($repository);
            }
        );
// add bindings



    }


}
