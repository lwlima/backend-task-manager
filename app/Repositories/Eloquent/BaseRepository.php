<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Interfaces\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class BaseRepository implements BaseRepositoryInterface
{
    /**
     * BaseRepository constructor
     *
     * @param Model $model
     */
    public function __construct(private readonly Model $model)
    {
    }

    /**
     * Get all models.
     *
     * @param array $columns
     * @param array $relations
     * @return Collection
     */
    public function all(array $columns = ['*'], array $relations = []): Collection
    {
        return $this->model->with($relations)->get($columns);
    }

    /**
     * Get all trashed models.
     *
     * @return Collection
     */
    public function allTrashed(): Collection
    {
        return $this->model->onlyTrashed()->get();
    }

    /**
     * Find model by id.
     *
     * @param int|string $id
     * @param array $columns
     * @param array $relations
     * @param array $appends
     * @return Model|null
     */
    public function find(int|string $id, array $columns = ['*'], array $relations = [], array $appends = []): ?Model
    {
        return $this->model->select($columns)->with($relations)->findOrFail($id)->append($appends);
    }

    /**
     * Find trashed model by id.
     *
     * @param int|string $id
     * @return Model|null
     */
    public function findWithTrashed(int|string $id): ?Model
    {
        return $this->model->withTrashed()->findOrFail($id);
    }

    /**
     * Find only trashed model by id.
     *
     * @param int|string $id
     * @return Model|null
     */
    public function findOnlyTrashed(int|string $id): ?Model
    {
        return $this->model->onlyTrashed()->findOrFail($id);
    }

    /**
     * Create a model.
     *
     * @param array $payload
     * @return Model|null
     */
    public function create(array $payload): ?Model
    {
        $model = $this->model->create($payload);
        return $model->fresh();
    }

    /**
     * Update existing model.
     *
     * @param int|string $id
     * @param array $payload
     * @return Model | false
     */
    public function update(int|string $id, array $payload): Model | false
    {
        $model = $this->find($id);
        return $model->update($payload) ? $model : false;
    }

    /**
     * Delete model by id.
     *
     * @param int|string $id
     * @return bool
     */
    public function delete(int|string $id): bool
    {
        return $this->find($id)->delete();
    }

    /**
     * Restore model by id.
     *
     * @param int|string $id
     * @return bool
     */
    public function restore(int|string $id): bool
    {
        return $this->findOnlyTrashed($id)->restore();
    }
}
