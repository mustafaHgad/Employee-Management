<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Contracts\BaseRepoInterface;
use Illuminate\Database\Eloquent\Model;

class BaseRepo implements BaseRepoInterface
{
    protected Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function query(): \Illuminate\Database\Eloquent\Builder
    {
        return $this->model->newQuery();
    }

    public function firstOr(int $id)
    {
        return $this->query()->findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data): bool
    {
        $item = $this->query()->findOrFail($id);
        return $item->update($data);
    }

    public function delete(int $id): bool
    {
        $item = $this->query()->findOrFail($id);
        return $item->forceDelete();
    }
}
