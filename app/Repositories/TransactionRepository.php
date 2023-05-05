<?php
namespace App\Repositories;

use App\Http\QueryFilters\Transaction\DateRangeFilter;
use App\Models\Transaction;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * Summary of TransactionRepository
 * @author Yaden Mustopa
 * @copyright (c) 2023
 */
class TransactionRepository extends BaseRepository
{
    public function __construct(Transaction $transaction)
    {
        $this->model = $transaction;
    }
    public function list($perPage = 10)
    {
        $baseQuery = $this->query()->with([
            'customer'
        ]);


        $query = QueryBuilder::for ($baseQuery)->allowedFilters([
            AllowedFilter::custom('date_range', new DateRangeFilter())
        ])
            ->defaultSort('-created_at', '-updated_at')
            ->allowedSorts('created_at', 'updated_at', 'name');
        return $query->paginate($perPage)->appends(request()->query());
    }
}
