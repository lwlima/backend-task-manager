<?php

namespace App\Services;

use App\Models\Task;
use App\Repositories\Eloquent\TaskRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;

class TaskService
{
    /**
     * TaskService constructor
     *
     * @param TaskRepository $repository
     */
    public function __construct(private readonly TaskRepository $repository)
    {
    }

    /**
     * Get all tasks
     *
     * @param array $columns
     * @param array $relations
     * @return Collection
     */
    public function getAllTasks(array $columns = ['*'], array $relations = []): Collection
    {
        return $this->repository->all($columns, $relations);
    }

    /**
     * Create a task.
     *
     * @param array $payload
     * @return Task|null
     */
    public function createTask(array $payload): ?Task
    {
        return $this->repository->create($payload);
    }

    /**
     * Update existing task.
     *
     * @param int|string $id
     * @param array $payload
     * @return bool
     */
    public function updateTask(int $id, array $payload): Task | false
    {
        $task = $this->repository->find($id);
        if ($task->status_id == 2 && $payload['status_id'] == 2) {
            unset($payload['started_at']);
            unset($payload['finished_at']);
            unset($payload['isStarted']);
            unset($payload['isFinished']);
            return $this->repository->update($id, $payload);
        }

        if ($payload['isStarted'])
            unset($payload['finished_at']);

        if ($payload['isFinished']) {
            unset($payload['started_at']);
            $payload['worked_hours'] = $this->getWorkedHours($task, $payload);
        }

        unset($payload['isStarted']);
        unset($payload['isFinished']);

        return $this->repository->update($id, $payload);
    }

    protected function getWorkedHours(Task $task, array $payload): string
    {
        $explodedWorkedHours = explode(':', $task->worked_hours);
        $explodedDiff = explode(':', $payload['finished_at']->diff($task->started_at)->format('%H:%i:%s'));

        $seconds = $explodedWorkedHours[2] + $explodedDiff[2];
        $minutes = $seconds > 59 ? $explodedWorkedHours[1] + $explodedDiff[1] + intval($seconds / 60) : $explodedWorkedHours[1] + $explodedDiff[1];
        $hours = $minutes > 59 ? $explodedWorkedHours[0] + $explodedDiff[0] + intval($minutes / 60) : $explodedWorkedHours[0] + $explodedDiff[0];

        $explodedWorkedHours[2] = $seconds > 59 ? $seconds % 60 : $seconds;
        $explodedWorkedHours[1] = $minutes > 59 ? $minutes % 60 : $minutes;
        $explodedWorkedHours[0] = $hours;
        return implode(':', $explodedWorkedHours);
    }

    /**
     * Delete task by id.
     *
     * @param int|string $id
     * @return bool
     */
    public function deleteTask(int $id): bool
    {
        return $this->repository->delete($id);
    }
}
