<?php

namespace App\Repositories\Eloquent;

use App\Models\ActivityLog;
use App\Repositories\Contracts\ActivityRepoInterface;

class ActivityRepo extends BaseRepo implements ActivityRepoInterface
{
    public function __construct(ActivityLog $model)
    {
        parent::__construct($model);
    }
}
