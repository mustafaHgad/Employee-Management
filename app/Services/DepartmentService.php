<?php

namespace App\Services;

use App\Models\Department;
use App\Repositories\Contracts\DepartmentRepoInterface;

class DepartmentService
{
    public function __construct(protected DepartmentRepoInterface $departmentRepo, protected ActivityService $activityLogger){}


    public function list()
    {
        return $this->departmentRepo->all();
    }

    public function view(int $id)
    {
        return $this->departmentRepo->firstOr($id);
    }

    public function create(array $data, ?int $userId = null)
    {
        $department = $this->departmentRepo->create($data);

        $this->activityLogger->log('department_created',$userId,"Department '{$department->name}' created (id: {$department->id})");

        return $department;
    }

    public function update(int $id, array $data, ?int $userId = null)
    {
        $department =$this->departmentRepo->firstOr($id);
        $this->departmentRepo->update($id, $data);

        $this->activityLogger->log('department_updated',$userId,"Department '{$department->name}' updated (id: {$department->id})");

        return $department;
    }

    public function delete(int $id, ?int $userId = null): void
    {
        $department = $this->departmentRepo->firstOr($id);

        $this->departmentRepo->delete($department->id);

        $this->activityLogger->log('department_deleted',$userId,"Department '{$department->name}' deleted (id: {$department->id})");
    }

}
