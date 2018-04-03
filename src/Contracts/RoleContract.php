<?php

namespace Lizyu\Permission\Contracts;

interface RoleContract
{
    public function store(array $role);
    
    public function destory(int $role_id);
    
    public function findById(int $role_id);
    
    public function updateBy(array $role, int $role_id);
    
    public function findByName(string $name);
    
}