<?php
namespace App\Repositories;

use App\Contracts\BaseRepositoryContract as ContractsBaseRepositoryContract;
use Exception;
use BadMethodCallException;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Rakhasa\Icore\Contracts\BaseRepositoryContract;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Traits\ForwardsCalls;
use Rakhasa\Icore\Enums\UserStatusEnum;

/**
 * Summary of BaseRepository
 * @author Yaden Mustopa
 * @copyright (c) 2023
 */
abstract class BaseRepository implements ContractsBaseRepositoryContract
{
    use ForwardsCalls;

    /**
     * @return Model
     */
    protected Model $model;

    /**
     * @return BaseRepository
     */
    protected $with = null;

    /**
     * @return Model
     */
    protected function make(): Model
    {
        return new $this->model;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function query(): Builder
    {
        $builder = $this->make()->newQuery();

        if ($this->with) {
            $builder->with($this->with);
        }

        return $builder;
    }

    /**
     * Accepts either the id or model. It's a safety method so that you can just pass arguments in
     * and receive the id back.
     *
     * @param $model
     *
     * @return mixed
     */
    protected function getId($model): int
    {
        return $model instanceof Model ? $model->getKey() : $model;
    }

    /**
     * mimic eloquent with() function
     *
     * @param  mixed $with
     *
     * @return BaseRepository
     */
    public function with($with): BaseRepository
    {
        $this->with = $with;

        return $this;
    }

    /**
     * load single model relation
     *
     * @param Model $model
     * @return Model
     */
    public function withModel(Model $model): Model
    {
        return $this->with ? $model->load($this->with) : $model;
    }

    /**
     * Accepts either the id or model. It's a safety method so that you can just pass arguments in
     * and receive the model back.
     *
     * @param $model
     *
     * @return \Illuminate\Database\Eloquent\Model|mixed|null
     */
    public function getOneById($model)
    {
        return $model instanceof Model ? $this->withModel($model) : $this->getOneBy('id', $model);
    }

    /**
     * Accepts either the id or model. It's a safety method so that you can just pass arguments in
     * and receive the model back but return exception if not found.
     *
     * @param $model
     *
     * @return \Illuminate\Database\Eloquent\Model|mixed|null
     */
    public function getOneByIdOrFail($model)
    {
        return $model instanceof Model ? $this->withModel($model) : $this->getOneByOrFail('id', $model);
    }

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
    public function persist(array $input, $model = null)
    {
        if ($model) {
            $model = $this->getOneById($model);
        } else {
            $model = $this->make();
        }

        if ($model instanceof $this->model) {
            $model->fill($input);

            if ($model->save()) {
                return $model;
            }
        }

        return null;
    }

    /**
     * create function
     *
     * @param array $data
     * @return Model
     */
    public function create(array $data): ?Model
    {
        return $this->model->create($data);
    }

    /**
     * update function
     *
     * @param Model $model
     * @param array $data
     * @return boolean|null
     */
    public function update($model, array $data): ?bool
    {
        if ($model instanceof Model) {
            return $model->update($data);
        }

        $id    = $model;
        $model = $this->make();

        return $model->newQuery()
            ->where($model->getKeyName(), $id)
            ->update($data);
    }

    /**
     * Delete the model.
     *
     * @param $model
     *
     * @return bool|null
     * @throws \Exception
     */
    public function delete($model): ?bool
    {
        if ($model instanceof Model) {
            return $model->delete();
        }

        $id    = $model;
        $model = $this->make();

        return $model->newQuery()
            ->where($model->getKeyName(), $id)
            ->delete();
    }

    /**
     * Helper method for retrieving models by a column or array of columns.
     * Example:
     * @method mixed getBy(id, $id)
     * @method mixed getBy(['id'=>$id, 'name'=>$name])
     * @method mixed getBy(['id'=>[$id1, $id2], 'name'=>$name])
     *
     * @return mixed
     */
    public function getBy(): ?Collection
    {
        $model = $this->query();

        if (\func_num_args() === 2) {
            list($column, $value) = \func_get_args();
            $method               = \is_array($value) ? 'whereIn' : 'where';
            $model                = $model->$method($column, $value);
        } elseif (\func_num_args() === 1) {
            $columns = func_get_arg(0);

            if (\is_array($columns)) {
                foreach ($columns as $column => $value) {
                    $method = \is_array($value) ? 'whereIn' : 'where';
                    $model  = $model->$method($column, $value);
                }
            }
        }

        return $model->get();
    }

    /**
     * Helper method for retrieving a model by a column or array of columns.
     * Example:
     * @method mixed getOneBy(id, $id)
     * @method mixed getOneBy(['id'=>$id, 'name'=>$name])
     * @method mixed getOneBy(['id'=>[$id1, $id2], 'name'=>$name])
     *
     * @return mixed
     */
    public function getOneBy(): ?Model
    {
        $model = $this->query();
        if (\func_num_args() === 2) {
            list($column, $value) = \func_get_args();

            $method = \is_array($value) ? 'whereIn' : 'where';
            $model  = $model->$method($column, $value);
        } elseif (\func_num_args() === 1) {
            $columns = \func_get_arg(0);


            if (\is_array($columns)) {
                foreach ($columns as $column => $value) {

                    $method = \is_array($value) ? 'whereIn' : 'where';
                    $model  = $model->$method($column, $value);
                }
            }
        }

        return $model->first();
    }

    /**
     * Helper method for retrieving a model by a column or array of columns and throw exception if not found.
     * Example:
     * @method mixed getOneBy(id, $id)
     * @method mixed getOneBy(['id'=>$id, 'name'=>$name])
     * @method mixed getOneBy(['id'=>[$id1, $id2], 'name'=>$name])
     *
     * @return mixed
     */
    public function getOneByOrFail(): ?Model
    {
        $model = $this->query();
        if (\func_num_args() === 2) {
            list($column, $value) = \func_get_args();

            $method = \is_array($value) ? 'whereIn' : 'where';
            $model  = $model->$method($column, $value);
        } elseif (\func_num_args() === 1) {
            $columns = \func_get_arg(0);


            if (\is_array($columns)) {
                foreach ($columns as $column => $value) {

                    $method = \is_array($value) ? 'whereIn' : 'where';
                    $model  = $model->$method($column, $value);
                }
            }
        }

        return $model->firstOrFail();
    }

    /**
     * Magic method handling for dynamic functions such as getByAddress() or getOneById().
     *
     * @param string $name
     * @param array  $arguments
     *
     * @return \Illuminate\Database\Eloquent\Collection|mixed|null
     */
    public function __call(string $name, array $arguments = [])
    {
        if (\count($arguments) > 1) {
            // TODO: Should probably throw an exception here
            return null;
        }

        if (in_array($name, ['first', 'count'])) {
            return $this->forwardCallTo($this->make(), $name, $arguments);
        }

        if (0 === strpos($name, 'getBy')) {
            return $this->getBy(Str::snake(substr($name, 5)), $arguments[0]);
        }

        if (0 === strpos($name, 'getOneBy') || 0 === strpos($name, 'getOneByOrFail')) {
            $column = Str::snake(substr($name, 8));

            return \call_user_func([$this->make(), 'where'], $column, $arguments[0])->firstOrFail();
        }

        if (!method_exists($this, $name)) {
            throw new BadMethodCallException(sprintf(
                'Call to undefined method %s::%s()', $this::class,
                $name
            ));
        }
    }

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
    public static function transaction(\Closure $callback, int $attempts = 1, string $connection = null)
    {
        if ($connection) {
            return DB::connection($connection)->transaction($callback, $attempts);
        }

        return DB::transaction($callback, $attempts);
    }

    /**
     * paginate function
     *
     * @param array $where
     * @param integer $perPage
     * @return LengthAwarePaginator
     */
    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return $this->query()->paginate($perPage);
    }

    /**
     * get repository model
     *
     * @return Model
     */
    public function model(): Model
    {
        return $this->model;
    }

    /**
     * Get a new factory instance for the model.
     *
     * @param  callable|array|int|null  $count
     * @param  callable|array  $state
     * @return \Illuminate\Database\Eloquent\Factories\Factory<static>
     */
    public function factory($count = null, $state = [])
    {
        return $this->model->factory($count = null, $state = []);
    }
}
