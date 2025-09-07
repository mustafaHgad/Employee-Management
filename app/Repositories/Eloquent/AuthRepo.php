<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Repositories\Contracts\AuthRepoInterface;

class AuthRepo extends BaseRepo implements AuthRepoInterface
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }
    public function findByEmail(string $email): ?User
    {
        return $this->query()->where('email', $email)->first();
    }

}
