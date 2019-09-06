<?php

namespace Moell\LayuiAdmin\Providers;


use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Moell\LayuiAdmin\Console\InstallCommand;

class LayuiAdminServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->registerRouter();
        $this->viewComposer();

        if ($this->app->runningInConsole()) {
            $this->registerMigrations();

            $this->commands([
                InstallCommand::class
            ]);
        }

        $this->loadViewsFrom(__DIR__.'/../../views', 'admin');

        $this->publishes([
            __DIR__.'/../../assets' => public_path('vendor/laravel-layui-admin'),
            ], 'public');

        $this->publishes([
            __DIR__.'/../../views' => resource_path('views/vendor/admin'),
        ], 'views');

        $this->publishes([
            __DIR__.'/../../config/admin.php' => config_path('admin.php'),
        ], 'config');
    }

    public function register()
    {

    }

    private function viewComposer()
    {
        View::composer(
            'admin::layouts.admin', 'Moell\LayuiAdmin\ViewComposers\AdminComposer'
        );
    }

    private function registerMigrations()
    {
        $migrationsPath = __DIR__ . '/../../database/migrations/';
        $items = [
            'create_admin_table.php',
            'add_custom_field_permission_tables.php',
            'create_navigation_table.php',
            'create_permission_group_table.php'
        ];
        $paths = [];
        foreach ($items as $key => $name) {
            $paths[$migrationsPath . $name] = database_path('migrations') . "/". $this->formatTimestamp($key+1) . '_' . $name;
        }
        $this->publishes($paths, 'migrations');
    }
    /**
     * @param $addition
     * @return false|string
     */
    private function formatTimestamp($addition)
    {
        return date('Y_m_d_His', time() + $addition);
    }


    /**
     * 注册路由
     *
     * @author moell
     */
    private function registerRouter()
    {
        require __DIR__.'/../routes.php';
    }
}