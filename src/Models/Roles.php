<?php

namespace Lizyu\Permission\Models;

use Illuminate\Database\Eloquent\Model;
use Lizyu\Permission\Models\Permissions;

class Roles extends Model
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
       $this->belongsToMany(Permissions::class, 'role_has_permissions');
   }
   
   /**
    * @description:role relate users
    * @author: wuyanwen <wuyanwen1992@gmail.com>
    * @date:2018年1月13日
    */
   public function users()
   {
       $this->belongsToMany(config('providers.' . config('guards.web.provider') . '.model'), 'user_has_roles');
   }
}
