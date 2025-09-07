<?php

namespace App\Repositories\Eloquent;

use App\Models\Department;
use App\Repositories\Contracts\DepartmentRepoInterface;

class DepartmentRepo extends BaseRepo implements DepartmentRepoInterface
{
    public function __construct(Department $model)
    {
        parent::__construct($model);
    }

    public function all(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->query()->orderBy('name')->get();
    }

}
