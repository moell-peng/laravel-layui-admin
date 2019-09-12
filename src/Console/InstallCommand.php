<?php

namespace Moell\LayuiAdmin\Console;


use Illuminate\Console\Command;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'laravel-layui-admin:install';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install moell/laravel-layui-admin';
    /**
     * Execute the console command.
     *
     * @author moell<moel91@foxmail.com>
     * @return mixed
     */
    public function handle()
    {
        $this->call('vendor:publish', ['--provider' => 'Spatie\Permission\PermissionServiceProvider']);
        $this->call('vendor:publish', [
            '--provider' => 'Moell\LayuiAdmin\Providers\LayuiAdminServiceProvider',
            '--tag' => 'config'
        ]);
        $this->call('vendor:publish', [
            '--provider' => 'Moell\LayuiAdmin\Providers\LayuiAdminServiceProvider',
            '--tag' => 'public'
        ]);

        $this->call('vendor:publish', [
            '--provider' => 'Moell\LayuiAdmin\Providers\LayuiAdminServiceProvider',
            '--tag' => 'migrations'
        ]);
    }
}