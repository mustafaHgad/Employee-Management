<?php

namespace App\Repositories\Contracts;

interface AuthRepoInterface extends BaseRepoInterface
{
    public function findByEmail(string $email);
}
