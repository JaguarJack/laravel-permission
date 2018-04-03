<?php

namespace Lizyu\Permission\Contracts;

interface PermissionContract
{
    public function store(array $permission);
    
    public function destory(int $permission_id);
    
    public function findById(int $permission_id);
    
    public function updateBy(array $permission, int $permission_id);
    
    public function findByName(string $name);
}