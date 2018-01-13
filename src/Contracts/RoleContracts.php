<?php

namespace Lizyu\Permission\Contracts;

interface RoleContracts
{
    public function store(array $role);
    
    public function delete(int $role_id);
    
    public function findById(int $role_id);
    
    public function update(array $role);
    
    public function findByName(string $name);
}