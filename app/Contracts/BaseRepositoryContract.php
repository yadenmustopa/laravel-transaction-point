<?php
namespace App\Contracts;



use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * Summary of BaseRepositoryContract
 * @author Yaden Mustopa
 * @copyright (c) 2023
 */
interface BaseRepositoryContract
{
    /**
     * Accepts either the id or model. It's a safety method so that you can just pass arguments in
     * and receive the model back.
     *
     * @param $model
     *
     * @return \Illuminate\Database\Eloquent\Model|mixed|null
     */
    public function getOneById($model);

    /**
     * Persist the model data.
     *
     * Pass in an array of input, and either an existing model or an id. Passing null to the
     * second argument will create a new instance.
     *
     * @param array $input
     * @param null  $model
     *
     * @return \Illuminate\Database\Eloquent\Model|mixed|null
     */
    public function persist(array $input, $model = null);

    /**
     * Create the model.
     *
     * @param array $data
     *
     * @return Collection|null
     * @throws \Exception
     */
    public function create(array $data): ?Model;

    /**
     * Delete the model.
     *
     * @param mixed $model
     * @param array $data
     *
     * @return Collection|null
     * @throws \Exception
     */
    public function update($model, array $data): ?bool;

    /**
     * Delete the model.
     *
     * @param $model
     *
     * @return bool|null
     * @throws \Exception
     */
    public function delete($model): ?bool;

    /**
     * Helper method for retrieving models by a column or array of columns.
     *
     * @return mixed
     */
    public function getBy(): ?Collection;

    /**
     * Helper method for retrieving a model by a column or array of columns.
     *
     * @return mixed
     */
    public function getOneBy(): ?Model;

    /**
     * Perform a transaction.
     *
     * @param \Closure    $callback
     * @param int         $attempts
     * @param string|null $connection
     *
     * @return mixed
     * @throws \Exception|\Throwable
     */
    public static function transaction(Closure $callback, int $attempts = 1, string $connection = null);

    /**
     * mimic eloquent with() function
     *
     * @param  mixed $with
     *
     * @return self
     */
    public function with($with): self;
}