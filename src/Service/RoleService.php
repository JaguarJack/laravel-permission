<?php

namespace Lizyu\Permission\Service;

use Lizyu\Permission\Models\Roles;
use Lizyu\Permission\Contracts\RoleContracts as Role;

class RoleService implements Role
{
    protected $role;
    
    public function __construct(Roles $role)
    {
        $this->role = $role;
    }
    
    /**
     * store role information
     * {@inheritDoc}
     * @see \Lizyu\Permission\Contracts\RoleContracts::store()
     */
    public function store(array $role)
    {
        foreach ($role as $attr => $value) {
            $this->role->$attr = $value;
        }
        
        return $this->role->save();
    }
    
    /**
     * delete role information
     * {@inheritDoc}
     * @see \Lizyu\Permission\Contracts\RoleContracts::delete()
     */
    public function delete(int $id)
    {
        return self::findById($id)->delete();
    }
    
    /**
     * find role by id
     * {@inheritDoc}
     * @see \Lizyu\Permission\Contracts\RoleContracts::findById()
     */
    public function findById(int $id)
    {
        return $this->role::find($id);
    }
    
    /**
     * update role information
     * {@inheritDoc}
     * @see \Lizyu\Permission\Contracts\RoleContracts::update()
     */
    public function update(array $role)
    {
        if ( ! isset($role['id']) )  return false;
        
        $this->role= self::findById($role['id']);
        
        unset($role['id']);
        
        foreach ($role as $attr => $value) {
            $this->role->$attr = $value;
        }
        
        return $this->role->save();
    }
    
    /**
     * find role information by name
     * {@inheritDoc}
     * @see \Lizyu\Permission\Contracts\RoleContracts::findByName()
     */
    public function findByName($name)
    {
        return $this->role->where('name', '=', $name)->first();
    }
    
    /**
     * @description:get roles
     * @author: wuyanwen <wuyanwen1992@gmail.com>
     * @date:2018年1月13日
     * @param int $limit
     * @return unknown
     */
    public function paginate(int $limit)
    {
        return $this->role->paginate($limit);
    }
    
    /**
     * @description:get role's permissions
     * @author: wuyanwen <wuyanwen1992@gmail.com>
     * @date:2018年1月13日
     * @param int $role_id
     * @return unknown
     */
    public function getPermissionsOfRole(int $role_id)
    {
        return $this->findById($role_id)->get();
    }
    
    /**
     * @description:delete role's permissions
     * @author: wuyanwen <wuyanwen1992@gmail.com>
     * @date:2018年1月13日
     * @param int $role_id
     * @param unknown $permission
     * @return unknown
     */
    public function deletePermissionsOfRole(int $role_id, $permission = null)
    {
        return $this->findById($role_id)->detach($permission);
    }
    
    /**
     * @description:store role permisions
     * @author: wuyanwen <wuyanwen1992@gmail.com>
     * @date:2018年1月13日
     * @param int $role_id
     * @param unknown $permission
     * @return unknown
     */
    public function storePermissionsOfRole(int $role_id, $permission = null)
    {
        $this->deletePermissionsOfRole($role_id, $permission);
        
        return $this->findById($role_id)->attach($permission);
    }
}