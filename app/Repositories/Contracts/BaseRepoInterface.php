<?php

namespace App\Repositories\Contracts;


interface BaseRepoInterface
{
    public function query();
    public function firstOr(int $id);
    public function create(array $data);
    public function update(int $id, array $data);
    public function delete(int $id);
}
