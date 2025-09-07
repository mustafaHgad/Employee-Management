<?php

namespace App\Repositories\Eloquent;

use App\Models\Employee;
use App\Repositories\Contracts\EmployeeRepoInterface;

class EmployeeRepo extends BaseRepo implements EmployeeRepoInterface
{
    public function __construct(Employee $model)
    {
        parent::__construct($model);
    }

    public function paginateWithDepartment(int $perPage = 10, ?int $departmentId = null): \Illuminate\Pagination\LengthAwarePaginator
    {
        $query = $this->query()->with('department')->orderByDesc('id');

        if ($departmentId) {
            $query->where('department_id', $departmentId);
        }

        return $query->paginate($perPage);
    }

    public function allWithDepartment(?int $departmentId = null): \Illuminate\Database\Eloquent\Collection
    {
        $query = $this->query()->with('department')->orderByDesc('id');

        if ($departmentId) {
            $query->where('department_id', $departmentId);
        }

        return $query->get();
    }
}
