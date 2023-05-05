<?php
namespace App\Http\QueryFilters\Transaction;



use App\Http\QueryFilters\Filter as QueryFiltersFilter;
use App\Traits\InvokeCustomFilterTrait;

class DateRangeFilter extends QueryFiltersFilter
{
    use InvokeCustomFilterTrait;

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
