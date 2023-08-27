<?php

namespace App\Repositories\Contracts;

/**
 * The interface for Eloquent repositories providing standard data manipulation methods.
 */
interface EloquentRepositoryInterface
{
    /**
     * Retrieve all records.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all();

    /**
     * Find a record by its ID.
     *
     * @param int $id
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function find($id);

    /**
     * Create a new record.
     *
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create(array $data);

    /**
     * Update a record by its ID.
     *
     * @param int $id
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function update($id, array $data);

    /**
     * Delete a record by its ID.
     *
     * @param int $id
     * @return bool
     */
    public function delete($id);
}
