<?php

namespace Rvsitebuilder\Filemanager;

use Alexusmai\LaravelFileManager\Middleware\FileManagerACL;
use Alexusmai\LaravelFileManager\Services\ACLService\ACLRepository;
use Alexusmai\LaravelFileManager\Services\ConfigService\ConfigRepository;
use Config;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Lib\Apps\Info;

class FilemanagerServiceProvider extends ServiceProvider
{
    /**
     * Class event subscribers.
     *
     * @var array
     */
    protected $subscribe = [
        // \Rvsitebuilder\Filemanager\Listeners\FilemanagerListener::class,
    ];

    /**
     * Register the service provider.
     */
    public function register(): void
    {
        $this->registerConfig();
        $this->registerMiddleware();
    }

    /**
     * Boot the application events.
     */
    public function boot(): void
    {
        $this->bootRoute();
        $this->bootViews();
        $this->bootViewComposer();
        $this->bootTranslations();
        $this->defineVendorPublish();
        $this->defineMigrate();
    }

    public function defineMigrate(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }

    /**
     * Boot Route.
     */
    public function bootRoute(): void
    {
        include_route_files(__DIR__ . '/../routes');
    }

    public function defineVendorPublish(): void
    {
        $this->publishes([
            __DIR__ . '/../public' => public_path('vendor/rvsitebuilder/filemanager'),
        ], 'public');
    }

    /**
     * boot views.
     */
    public function bootViews(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'rvsitebuilder/filemanager');
    }

    public function bootViewComposer(): void
    {
        /*
        View::composer(
            ['rvsitebuilder/filemanager::user.index'], 'Rvsitebuilder\Filemanager\Http\Composers\ViewComposer'
        );
        */
    }

    /**
     * boot translations.
     */
    public function bootTranslations(): void
    {
        //load lang from vendor file-manager
        $this->loadTranslationsFrom(base_path() . '/vendor/alexusmai/laravel-file-manager/resources/lang', 'file-manager');
        //load lang from my packages filemanager
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'rvsitebuilder/filemanager');
    }

    /**
     * Register Middleware.
     */
    public function registerMiddleware(): void
    {
        $router = app()->make(Router::class);
        $router->pushMiddlewareToGroup('admin', FileManagerACL::class);

        // register ACL middleware
        $router->aliasMiddleware('fm-acl', FileManagerACL::class);
    }

    /**
     * Register config.
     */
    protected function registerConfig(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/file-manager.php', 'file-manager');

        $packageInfos = Info::getAllAppsInfo();
        // give access to folder contains .privateapp
        // create config private app access = 2 = read/write
        $privatePackages = $packageInfos['private'];
        $newConfig = [];
        foreach ($privatePackages as $vendor => $aPackages) {
            foreach ($aPackages as $packageName => $value) {
                $newConfig[] = [
                    'disk' => 'apps',
                    'path' => "{$vendor}/{$packageName}/*",
                    'access' => 2,
                ];
            }
        }
        //create config public app access = 1 read only
        $publicPackages = $packageInfos['public'];
        foreach ($publicPackages as $vendor => $aPackages) {
            foreach ($aPackages as $packageName => $value) {
                $newConfig[] = [
                    'disk' => 'apps',
                    'path' => "{$vendor}/{$packageName}/*",
                    'access' => 1,
                ];
            }
        }
        //merge config
        $newConfig = array_merge(config('file-manager.aclRules.1'), $newConfig);

        Config::set([
            'override' => [
                'file-manager.aclRules.1' => $newConfig,
            ],
        ]);

        // Config Repository
        $this->app->bind(
            ConfigRepository::class,
            $this->app['config']['file-manager.configRepository']
        );

        // ACL Repository
        $this->app->bind(
            ACLRepository::class,
            $this->app->make(ConfigRepository::class)->getAclRepository()
        );
    }
}
