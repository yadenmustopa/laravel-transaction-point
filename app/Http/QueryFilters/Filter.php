<?php
namespace App\Http\QueryFilters;

use App\Traits\InvokeCustomFilterTrait;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

abstract class Filter implements \Spatie\QueryBuilder\Filters\Filter
{
    use InvokeCustomFilterTrait;
    /**
     * handle
     *
     * @param  mixed $request
     * @param  mixed $next
     * @return void
     */
    public function handle($request, Closure $next)
    {
        if (!request()->has($this->filterName())) {
            return $next($request);
        }
        $builder = $next($request);
        return $this->applyFilter($builder);
    }

    abstract protected function applyFilter($builder, $value = '');

    /**
     * filterName
     *
     * @param  string $name
     * @return string
     */
    protected function filterName($name = ""): string
    {
        if ($name) {
            return $name;
        }
        $base_name = class_basename(static::class);
        $base_name = str_replace('Filter', '', $base_name);
        return camelToDashCase($base_name);
    }
}