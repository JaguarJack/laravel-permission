<?php

namespace Lizyu\Permission\Contracts;

interface PermissionContracts
{
    public function store(array $permission);
    
    public function delete(int $permission_id);
    
    public function findById(int $permission_id);
    
    public function update(array $permission);
    
    public function findByName(string $name);
}