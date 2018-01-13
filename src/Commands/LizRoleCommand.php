<?php

namespace Lizyu\Permission\Commands;

use Illuminate\Console\Command;
use Lizyu\Permission\Contracts\RoleContracts as Role;

class LizRoleCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:role {option} {new_name} {old_name?}';
    
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Role Option (create && update && delete)';
    
    protected $option = ['create', 'update', 'delete'];
    
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }
    
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        $option = $this->argument('option');
        
        if ( ! $option ) return $this->error('please input option');
        
        if ( ! in_array($option, $this->option)) {
            return $this->error('option is right? (create && update && delete)');
        }
        
        return $this->{$this->argument('option')}();
        
    }
    
    
    protected function create()
    {
        $roleService = app(Role::class);
        $new_role_name = $this->getNewRoleName();
        
        if ($roleService->findByName($this->argument('new_name'))) {
            return $this->error('the role is Exist');
        }
        
        return $roleService->store([
            'name' => $new_role_name,
        ]) ? $this->info('create role success') : $this->error('create role faild');
    }
    
    protected function update()
    {
        $old_role_name = $this->getOldRoleName();
        $new_role_name = $this->getNewRoleName();
        
        $role = app(Role::class)->findByName($this->argument('old_name'));
        
        if ( ! $role ) return $this->error('role is not exist');
        
        $role->name = $new_role_name;
        
        return $role->save() ? $this->info('update role success') : $this->error('update role faild');
    }
    
    protected function delete()
    {
        $role_name = $this->argument('new_name');
        
        if ( ! $role_name ) {
            return $this->error('please input role name');    
        }
        
        $role = app(Role::class)->findByName($this->argument($role_name));
        
        if ( ! $role ) return $this->error('Role Is Not Exist');
        
        return $role->delete() ? $this->info('delete role success') : $this->error('delete role faild');
    }
    
    protected function getNewRoleName()
    {
        return $this->argument('new_name') ?  : $this->error('please input the new role name');
    }
    
    protected function getOldRoleName()
    {
        return $this->argument('old_name') ?  : $this->error('please input the new old name');
    }
}
