<?php

namespace Lizyu\Permission\Traits;

trait HasPermissionsTrait
{
    /**
     * @description:获取用户权限
     * @author: wuyanwen <wuyanwen1992@gmail.com>
     * @date:2018年3月10日
     * @param int $user_id
     */
    public function getUserOfPermissions(int $user_id)
    {
        return $this->where('users.id', $user_id)
                    ->join('user_has_roles', 'users.id', '=', 'user_has_roles.user_id')
                    ->join('role_has_permissions', 'user_has_roles.roles_id', '=', 'role_has_permissions.roles_id')
                    ->join('permissions', 'permissions.id', '=', 'role_has_permissions.permissions_id')
                    ->select('permissions.*')
                    ->orderBy('permissions.weight', 'DESC')
                    ->distinct()
                    ->get();
    }
}