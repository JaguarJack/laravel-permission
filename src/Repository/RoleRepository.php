<?php

namespace Lizyu\Permission\Repository;

use Lizyu\Permission\Models\Roles;
use Lizyu\Permission\Contracts\RoleContracts as Role;

class RoleRepository implements Role, \ArrayAccess
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
     * @description:get the lastest role
     * @author: wuyanwen <wuyanwen1992@gmail.com>
     * @date:2018年1月21日
     * @return unknown
     */
    public function getLastestRole()
    {
        return $this->role->orderBy('id', 'desc')->first();
    }
    
    /**
     * find role information by name
     * {@inheritDoc}
     * @see \Lizyu\Permission\Contracts\RoleContracts::findByName()
     */
    public function findByName(string $name)
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
    public function paginate(int $offset, int $limit)
    {
        return  $this->role->select('id', 'name', 'description', 'created_at')
                           ->offset($offset)
                           ->limit($limit)
                           ->get();
    }
    
    /**
     * @description:计算角色总数
     * @author: wuyanwen <wuyanwen1992@gmail.com>
     * @date:2018年1月21日
     * @return unknown
     */
    public function count()
    {
        return $this->role->count();
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
        return $this->findById($role_id)->permissions()->get();
    }
    
    /**
     * @description:delete role's permissions
     * @author: wuyanwen <wuyanwen1992@gmail.com>
     * @date:2018年1月13日
     * @param int $role_id
     * @param unknown $permission
     * @return unknown
     */
    public function deletePermissionsOfRole(int $role_id, $permissions = null)
    {
        return $this->findById($role_id)->permissions()->detach($permissions);
    }
    
    /**
     * @description:store role permisions
     * @author: wuyanwen <wuyanwen1992@gmail.com>
     * @date:2018年1月13日
     * @param int $role_id
     * @param unknown $permission
     * @return unknown
     */
    public function storePermissionsOfRole(int $role_id, $permissions = null)
    {
        $this->deletePermissionsOfRole($role_id, null);
        
        return $this->findById($role_id)->permissions()->attach($permissions);
    }
    
    /**
     * @description:删除角色用户关联
     * @author: wuyanwen <wuyanwen1992@gmail.com>
     * @date:2018年3月10日
     * @param int $role_id
     */
    public function deleteUserOfRole(int $role_id)
    {
        return $this->findById($role_id)->users()->detach();
    }
    
    public function offsetGet($offset)
    {
        return $this->$offset;
    }
    
    public function offsetExists($offset)
    {
        return isset($this->$offset) ? true : false;
    }
    
    public function offsetSet($offset, $value){}
    public function offsetUnset($offset){}
}