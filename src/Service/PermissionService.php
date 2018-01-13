<?php

namespace Lizyu\Permission\Service;

use Lizyu\Permission\Models\Permissions;
use Lizyu\Permission\Contracts\PermissionContracts as Permission;

class PermissionService implements Permission, \ArrayAccess
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
     * @description:Get all permissions
     * @author: wuyanwen <wuyanwen1992@gmail.com>
     * @date:2018年1月13日
     * @return unknown
     */
    public function getAll()
    {
        return $this->permission->get();
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
            $owner = $this->findByName($permission)->role->first()->user->first();
        }
        
        return $user->name == $owner->name;
    }
    
    
    public function offsetGet($offset)
    {
        return $this->permission;
    }
    
    public function offsetExists($offset){}
    public function offsetSet($offset, $value){}
    public function offsetUnset($offset){}
    
}