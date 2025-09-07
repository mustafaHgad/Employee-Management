<?php

namespace App\Repositories\Contracts;

interface EmployeeRepoInterface extends BaseRepoInterface
{
    public function paginateWithDepartment(int $perPage = 10, ?int $departmentId = null);
    public function allWithDepartment(?int $departmentId = null);

}
