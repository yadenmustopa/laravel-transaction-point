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

    /**
     * Summary of totalTransactionPerGroup
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function totalTransactionPerGroup()
    {
        return $this->transactions()->selectRaw('description, sum(amount) as total')
            ->groupBy('description')
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
            $points[] = Point::get($totalTransaction->description, $totalTransaction->total);
        }
        return (int) (count($points) > 0) ? array_sum($points) : 0;
    }
}