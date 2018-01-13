<?php

namespace Lizyu\Permission\Traits;

use Lizyu\Permission\Contracts\RoleContracts as Role;

Trait RoleTrait
{
    public function role()
    {
        return app(Role::class);
    }
}