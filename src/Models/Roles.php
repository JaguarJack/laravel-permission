<?php

namespace Lizyu\Permission\Models;

use Illuminate\Database\Eloquent\Model;
use Lizyu\Permission\Models\Permissions;
use Lizyu\Permission\Contracts\RoleContract;

class Roles extends Model implements RoleContract
{
    //
    protected $fillable = [
        'name',
    ];
   
   /**
    * @description:role relate permissions
    * @author: wuyanwen <wuyanwen1992@gmail.com>
    * @date:2018年1月13日
    */
   public function permissions()
   {
       return $this->belongsToMany(Permissions::class, 'role_has_permissions');
   }
   
   /**
    * @description:role relate users
    * @author: wuyanwen <wuyanwen1992@gmail.com>
    * @date:2018年1月13日
    */
   public function users()
   {
       return $this->belongsToMany(config('auth.providers.' . config('auth.guards.admin.provider') . '.model'), 'user_has_roles');
   }
   
   /**
    * store role information
    * {@inheritDoc}
    * @see \Lizyu\Permission\Contracts\RoleContracts::store()
    */
   public function store(array $role)
   {
       foreach ($role as $attr => $value) {
           if ($value) $this->$attr = $value;
       }
       
       return $this->save();
   }
   
   /**
    * delete role information
    * {@inheritDoc}
    * @see \Lizyu\Permission\Contracts\RoleContracts::delete()
    */
   public function destory(int $id)
   {
       return $this->findById($id)->delete();
   }
   
   /**
    * find role by id
    * {@inheritDoc}
    * @see \Lizyu\Permission\Contracts\RoleContracts::findById()
    */
   public function findById(int $id)
   {
       return $this->find($id);
   }
   
   /**
    * update role information
    * {@inheritDoc}
    * @see \Lizyu\Permission\Contracts\RoleContracts::update()
    */
   public function updateBy(array $role, int $role_id)
   {
       $roleModel = $this->findById($role['id']);
       
       foreach ($role as $attr => $value) {
           if ($value) $roleModel->$attr = $value;
       }
       
       return $roleModel->save();
   }
   
   /**
    * @description:get the lastest role
    * @author: wuyanwen <wuyanwen1992@gmail.com>
    * @date:2018年1月21日
    * @return unknown
    */
   public function getLastestRole()
   {
       return $this->orderBy('id', 'desc')->first();
   }
   
   /**
    * find role information by name
    * {@inheritDoc}
    * @see \Lizyu\Permission\Contracts\RoleContracts::findByName()
    */
   public function findByName(string $name)
   {
       return $this->where('name', '=', $name)->first();
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
}
