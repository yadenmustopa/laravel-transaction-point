<?php
namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait InvokeCustomFilterTrait
{
    /**
     * __invoke
     *
     * @param  mixed $query
     * @param  mixed $value
     * @param  mixed $property
     * @return void
     */
    public function __invoke(Builder $query, $value, string $property)
    {
        return $this->applyFilter($query, $value);
    }
}