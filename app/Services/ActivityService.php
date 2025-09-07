<?php

namespace App\Services;

use App\Repositories\Contracts\ActivityRepoInterface;
use Illuminate\Support\Facades\Log;

class ActivityService
{
    public function __construct(protected ActivityRepoInterface $activityRepo){}

    public function log(string $action, ?int $userId = null , ?string $description = null): void
    {
        Log::info("User: {$userId},; Activity: {$action},; Description: {$description}");
        $this->activityRepo->create([
            'user_id'     => $userId,
            'action'      => $action,
            'description' => $description,
        ]);
    }
}
