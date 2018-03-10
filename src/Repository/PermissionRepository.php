<?php

namespace Lizyu\Permission\Repository;

use Lizyu\Permission\Models\Permissions;
use Lizyu\Permission\Contracts\PermissionContracts as Permission;

class PermissionRepository implements Permission, \ArrayAccess
{
    protected $permission;
    
    public function __construct(Permissions $permission)
    {
        $this->permission = $permission;
    }
    
    /**
     * create permission
     * {@inheritDoc}
     * @see \Lizyu\Permission\Contracts\PermissionContracts::store()
     */
    public function store(array $permission)
    {
        foreach ($permission as $attr => $value) {
            $this->permission->$attr = $value;
        }
        
        return $this->permission->save();
    }
    
    /**
     * delete permission
     * {@inheritDoc}
     * @see \Lizyu\Permission\Contracts\PermissionContracts::delete()
     */
    public function delete(int $id)
    {
        return self::findById($id)->delete();
    }
    
    
    public function findById(int $id)
    {
        return $this->permission::find($id);
    }
    
    /**
     * update permission info
     * {@inheritDoc}
     * @see \Lizyu\Permission\Contracts\PermissionContracts::update()
     */
    public function update(array $permission)
    {
        if ( ! isset($permission['id']) )  return false;
        
        $this->permission = self::findById($permission['id']);
        
        unset($permission['id']);
        
        foreach ($permission as $attr => $value) {
            $this->permission->$attr = $value;
        }
        
        return $this->permission->save();
    }
    
    /**
     * find permission by name
     * {@inheritDoc}
     * @see \Lizyu\Permission\Contracts\PermissionContracts::findByName()
     */
    public function findByName(string $name)
    {
        return $this->permission->where('name', '=', $name)->first();
    }
    
    /**
     * @description:获取最新权限
     * @author: wuyanwen <wuyanwen1992@gmail.com>
     * @date:2018年1月21日
     * @return unknown
     */
    public function getLastestPermission()
    {
        return $this->permission->orderBy('id', 'desc')->first();
    }
    
    /**
     * @description:Get all permissions
     * @author: wuyanwen <wuyanwen1992@gmail.com>
     * @date:2018年1月13日
     * @return unknown
     */
    public function getAll()
    {
        return $this->permission->orderBy('weight', 'desc')->get();
    }
    
    /**
     * @description:是否有子节点
     * @author: wuyanwen <wuyanwen1992@gmail.com>
     * @date:2018年3月8日
     * @param unknown $id
     */
    public function isHaveChildren(int $id)
    {
        return $this->permission->where('pid', '=', $id)->first();
    }
   /**
    * @description:Permission be owned some users
    * @author: wuyanwen <wuyanwen1992@gmail.com>
    * @date:2018年1月13日
    * @param unknown $user
    * @param unknown $permission
    * @return boolean
    */
    public function PermissionBeOwned($user, $permission)
    {
        if (is_numeric($permission)) {
            $owner = $this->findById($permission)->role->first()->user->first();
        }
        
        if (is_string($permission)) {
            return $this->findUserIdsByBehavior($permission)->contains($user->id) ? true : false;
        }
        
        return false;
    }
    
    /**
     * @description:根据行为名称获取
     * @author: wuyanwen <wuyanwen1992@gmail.com>
     * @date:2018年3月10日
     * @param string $behavior
     */
    public function findUserIdsByBehavior($behavior)
    {
        return $this->permission->where('behavior', $behavior)
                    ->leftjoin('role_has_permissions', 'permissions.id', '=', 'role_has_permissions.permissions_id')
                    ->leftjoin('user_has_roles', 'role_has_permissions.roles_id', '=', 'user_has_roles.roles_id')
                    ->select('user_has_roles.user_id')
                    ->distinct()
                    ->get();
    }
    
    /**
     * @description:删除权限关联
     * @author: wuyanwen <wuyanwen1992@gmail.com>
     * @date:2018年3月10日
     * @param unknown $permission
     */
    public function deletePermissionOfRole($permission)
    {
        return $this->findById($permission)->permissions()->detach();
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