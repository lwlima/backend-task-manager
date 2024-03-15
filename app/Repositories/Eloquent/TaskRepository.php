<?php

namespace App\Repositories\Eloquent;
use App\Models\Task;
use App\Repositories\Interfaces\TaskRepositoryInterface;

class TaskRepository extends BaseRepository implements TaskRepositoryInterface
{
    public function __construct(Task $model)
    {
        parent::__construct($model);
    }
}
