<?php
namespace App\Http\QueryFilters\SpatieCustom\Campaign;


use App\Http\QueryFilters\Filter as QueryFiltersFilter;
use App\Traits\InvokeCustomFilterTrait;
use App\Traits\SetPipelineTrait;
use Spatie\QueryBuilder\Filters\Filter;

class DateRangeFilter extends QueryFiltersFilter
{
    use SetPipelineTrait, InvokeCustomFilterTrait;

    /**
     * @param mixed $builder
     * @return mixed
     */
    protected function applyFilter($builder, $filters = [])
    {
        if (!is_array($filters) && count($filters) == 3) {
            return $builder;
        }
        $column     = $filters[0];
        $start_date = epochToDate($filters[1]); // start
        $end_date   = epochToDate($filters[2]); // end
        return $builder->whereBetween($column, [$start_date, $end_date]);
    }
}