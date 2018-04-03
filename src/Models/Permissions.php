<?php

namespace Lizyu\Permission\Models;

use Illuminate\Database\Eloquent\Model;
use Lizyu\Permission\Models\Roles;
use Lizyu\Permission\Contracts\PermissionContract;

class Permissions extends Model implements PermissionContract
{
    
    protected $table = 'permissions';
    
    //
    protected $fillable = [
        'name', 'controller', 'function', 'weight',
    ];
    
    /**
     * @description:pemission relate role
     * @author: wuyanwen <wuyanwen1992@gmail.com>
     * @date:2018年1月13日
     */
    public function permissions()
    {
        return $this->belongsToMany(Roles::class, 'role_has_permissions');
    }
    
    /**
     * create permission
     * {@inheritDoc}
     * @see \Lizyu\Permission\Contracts\PermissionContracts::store()
     */
    public function store(array $permission)
    {
        foreach ($permission as $attr => $value) {
             $this->$attr = $value;
        }
        
        return $this->save();
    }
    
    /**
     * delete permission
     * {@inheritDoc}
     * @see \Lizyu\Permission\Contracts\PermissionContracts::delete()
     */
    public function destory(int $id)
    {
        return $this->findById($id)->delete();
    }
    
    
    public function findById(int $id)
    {
        return $this->find($id);
    }
    
    /**
     * update permission info
     * {@inheritDoc}
     * @see \Lizyu\Permission\Contracts\PermissionContracts::update()
     */
    public function updateBy(array $permission, int $permission_id)
    {
        $permissionModel = $this->findById($permission_id);
        
        foreach ($permission as $attr => $value) {
             $permissionModel->$attr = $value;
        }
        
        return $permissionModel->save();
    }
    
    /**
     * find permission by name
     * {@inheritDoc}
     * @see \Lizyu\Permission\Contracts\PermissionContracts::findByName()
     */
    public function findByName(string $name)
    {
        return $this->where('name', '=', $name)->first();
    }
    
    /**
     * @description:获取最新权限
     * @author: wuyanwen <wuyanwen1992@gmail.com>
     * @date:2018年1月21日
     * @return unknown
     */
    public function getLastestPermission()
    {
        return $this->orderBy('id', 'desc')->first();
    }
    
    /**
     * @description:Get all permissions
     * @author: wuyanwen <wuyanwen1992@gmail.com>
     * @date:2018年1月13日
     * @return unknown
     */
    public function getAllPermissions()
    {
        return $this->orderBy('weight', 'desc')->get();
    }
    
    /**
     * @description:是否有子节点
     * @author: wuyanwen <wuyanwen1992@gmail.com>
     * @date:2018年3月8日
     * @param unknown $id
     */
    public function isHaveChildren(int $id)
    {
        return $this->where('pid', '=', $id)->first();
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
            return $this->findUserIdsByBehavior($permission)->contains('user_id', $user->id) ? true : false;
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
        return $this->where('behavior', $behavior)
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
    
    
}
