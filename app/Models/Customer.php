<?php

namespace App\Models;

use App\Casts\EpochToDate;
use App\Libraries\Point;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasUuids, HasFactory;

    protected $fillable = [
        'name',
    ];


    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'customer_id', 'id');
    }

    public function transactionsDesc()
    {
        return $this->hasMany(Transaction::class, 'customer_id', 'id')->orderByDesc('created_at');
    }

    /**
     * Summary of totalTransactionPerGroup
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function totalTransactionPerGroup()
    {
        return $this->transactions()->selectRaw('description,customer_id, sum(amount) as total')
            ->groupBy('description', 'customer_id')
            ->get();
    }

    /**
     * Summary of getPointAttribute
     * @return float|int
     */
    public function getPointAttribute()
    {
        $totalTransactions = $this->totalTransactionPerGroup();
        $points            = [];
        foreach ($totalTransactions as $totalTransaction) {
            if ($totalTransaction->customer_id === "99184343-6c73-4709-8a41-b3edf31309e3") {
                var_dump($totalTransaction->toArray());
            }
            $points[] = Point::get($totalTransaction->description, $totalTransaction->total);
        }
        return (int) (count($points) > 0) ? array_sum($points) : 0;
    }
}
