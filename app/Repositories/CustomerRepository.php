<?php
namespace App\Repositories;

use App\Models\Customer;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class CustomerRepository extends BaseRepository
{
    public function __construct(Customer $customer)
    {
        $this->model = $customer;
    }

    public function list($perPage = 10)
    {
        $baseQuery = $this->query()->with([
            'transactions'
        ]);


        $query = QueryBuilder::for ($baseQuery)->allowedFilters([
        ])
            ->defaultSort('-created_at', '-updated_at')
            ->allowedSorts('created_at', 'updated_at', 'name');
        return $query->paginate($perPage)->appends(request()->query());
    }
}