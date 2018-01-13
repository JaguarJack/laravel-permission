<?php

namespace Lizyu\Permission\Traits;

use Lizyu\Permission\Models\Roles;

trait RoleTrait
{
    /**
     * @description:user relate roles
     * @author: wuyanwen <wuyanwen1992@gmail.com>
     * @date:2018年1月13日
     */
    public function roles()
    {
        $this->belongsToMany(Roles::class, 'user_has_roles');
    }
    
    /**
     * @description:get user's roles
     * @author: wuyanwen <wuyanwen1992@gmail.com>
     * @date:2018年1月13日
     * @return unknown
     */
    public function getRolesOfUser()
    {
        return $this->roles()->get();
    }
    
    /**
     * @description:store user's role
     * @author: wuyanwen <wuyanwen1992@gmail.com>
     * @date:2018年1月13日
     * @param unknown $roles
     * @return unknown
     */
    public function storeRolesOfUser($roles)
    {
        $this->deleteRolesOfUser();
        
        return $this->roles()->attach($roles);
    }
    
    /**
     * @description:delete user's role
     * @author: wuyanwen <wuyanwen1992@gmail.com>
     * @date:2018年1月13日
     * @param unknown $roles
     * @return unknown
     */
    public function deleteRolesOfUser($roles = null)
    {
        return $this->roles()->detach($roles);
    }
    
    public function hasRole($role)
    {
        
    }
}