<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface BaseRepositoryInterface
{
    /**
     * Get all models.  
     *
     * @param array $columns
     * @param array $relations
     * @return Collection
     */
    public function all(array $columns = ['*'], array $relations = []): Collection;

    /**
     * Get all trashed models.
     *
     * @return Collection
     */
    public function allTrashed(): Collection;

    /**
     * Find model by id.
     *
     * @param int|string $id
     * @param array $columns
     * @param array $relations
     * @param array $appends
     * @return Model|null
     */
    public function find(
        int | string $id,
        array $columns = ['*'],
        array $relations = [],
        array $appends = []
    ): ?Model;

    /**
     * Find trashed model by id.
     *
     * @param int|string $id
     * @return Model|null
     */
    public function findWithTrashed(int | string $id): ?Model;

    /**
     * Find only trashed model by id.
     *
     * @param int|string $id
     * @return Model|null
     */
    public function findOnlyTrashed(int | string $id): ?Model;

    /**
     * Create a model.
     *
     * @param array $payload
     * @return Model|null
     */
    public function create(array $payload): ?Model;

    /**
     * Update existing model.
     *
     * @param int|string $id
     * @param array $payload
     * @return Model | false
     */
    public function update(int | string $id, array $payload): Model | false;

    /**
     * Delete model by id.
     *
     * @param int|string $id
     * @return bool
     */
    public function delete(int | string $id): bool;

    /**
     * Restore model by id.
     *
     * @param int|string $id
     * @return bool
     */
    public function restore(int | string $id): bool;
}
