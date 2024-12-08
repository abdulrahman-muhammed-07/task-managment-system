<?php

namespace App\Repositories\SQL;


use App\Models\User;
use App\Repositories\SQL\AbstractModelRepository;
use App\Repositories\Contracts\IUserRepository;
use Illuminate\Support\Facades\Auth;

class UserRepository extends AbstractModelRepository implements IUserRepository
{
    /**
     * @param User $model
     */
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function admins(array $attributes = ['*'])
    {
        return $this->model->admin()->get($attributes);
    }

    public function users(array $attributes = ['*'])
    {
        return cache()->remember(
            'users',
            86400,
            fn () =>
            User::where('type', '=', User::USER)->get($attributes)
        );
    }
}
