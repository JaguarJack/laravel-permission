<?php

namespace Lizyu\Permission;

use Illuminate\Support\ServiceProvider;
use Lizyu\Permission\Commands\LizPermissionCommand;
use Lizyu\Permission\Contracts\PermissionContracts as Permission;
use Lizyu\Permission\Contracts\RoleContracts as Role;

class PermissionServiceProvider extends ServiceProvider
{
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
        //
        $this->publishConfig();
        $this->reigsterCommand();
        $this->registerMigration();
        $this->bindService();
    }
    
    /**
     * @description:register config
     * @author: wuyanwen <wuyanwen1992@gmail.com>
     * @date:2018年1月13日
     */
    protected function publishConfig()
    {
        $config = __DIR__  . '/../config/lizyu.php';
        
        $config_path = $this->app->configPath() . '/lizyu.php';
        
        $this->publishes([ $config => $config_path ], 'lizyu.config');
    }
    
    /**
     * @description:bind service
     * @author: wuyanwen <wuyanwen1992@gmail.com>
     * @date:2018年1月13日
     */
    protected function bindService()
    {
        $this->app->bind(Permission::class, config('lizyu.permission'));
        $this->app->bind(Role::class, config('lizyu.role'));
    }
    
    /**
     * @description:register command
     * @author: wuyanwen <wuyanwen1992@gmail.com>
     * @date:2018年1月13日
     */
    protected function reigsterCommand()
    {
        $this->commands(LizPermissionCommand::class);
    }
    
    /**
     * @description:publish migration
     * @author: wuyanwen <wuyanwen1992@gmail.com>
     * @date:2018年1月13日
     */
    protected function registerMigration()
    {
        $stub = __DIR__ . '/../database/migrations/create_permissions_table.php';
        
        $migration = sprintf($this->app->databasePath() . '/migrations/%s_create_permissions_table.php', date('Y_m_d_His', time()));
        
        $this->publishes([ $stub=> $migration ], 'lizyu.migrations');
    }
}
