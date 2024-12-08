<?php

namespace App\Repositories\Contracts;


interface IUserRepository extends IModelRepository
{
    public function admins(array $attributes = ['*']);
    
    public function users(array $attributes = ['*']);
    
}
