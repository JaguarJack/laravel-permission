<?php

namespace Lizyu\Permission\Traits;

use Lizyu\Permission\Contracts\PermissionContracts as Permission;

trait PermissionTrait
{
    public function permission()
    {
        return app(Permission::class);
    }
}