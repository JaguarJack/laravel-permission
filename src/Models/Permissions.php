<?php

namespace Lizyu\Permission\Models;

use Illuminate\Database\Eloquent\Model;
use Lizyu\Permission\Models\Roles;

class Permissions extends Model
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
    
}
