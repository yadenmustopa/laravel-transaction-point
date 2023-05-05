<?php

namespace App\Models;

use App\Casts\EpochToDateCast;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasUuids, HasFactory;
    protected $casts = [
        'amount'           => 'integer',
        'transaction_date' => EpochToDateCast::class
    ];

    protected $dates = [
        "transaction_date"
    ];

    protected $fillable = [
        'customer_id',
        'amount',
        'status',
        'description',
        'transaction_date'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }
}
