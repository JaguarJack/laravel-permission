<?php

namespace Lizyu\Permission;

use Illuminate\Support\ServiceProvider;
use Lizyu\Permission\Commands\LizRoleCommand;
use Lizyu\Permission\Contracts\PermissionContract;
use Lizyu\Permission\Contracts\RoleContract;
use Lizyu\Permission\Models\Permissions;
use Lizyu\Permission\Models\Roles;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Gate;

class PermissionServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(Gate $gate)
    {
        //
        $this->reigsterCommand();
        $this->registerMigration();
        $this->bindRespository();
        $this->registerGate($gate);
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
    protected function bindRespository()
    {
        $this->app->bind(PermissionContract::class, Permissions::class);
        $this->app->bind(RoleContract::class, Roles::class);
    }
    
    /**
     * @description:register command
     * @author: wuyanwen <wuyanwen1992@gmail.com>
     * @date:2018年1月13日
     */
    protected function reigsterCommand()
    {
        $this->commands(LizRoleCommand::class);
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
    
    /**
     * @description:注册授权策略
     * @author: wuyanwen <wuyanwen1992@gmail.com>
     * @date:2018年3月10日
     * @param Gate $gate
     * @return \Illuminate\Contracts\Auth\Access\Gate
     */
    protected function  registerGate(Gate $gate)
    {
        return $gate->before(function(Authenticatable $user, string $permission){
                    return app(Permission::class)->PermissionBeOwned($user, $permission);
               });
    }
}
