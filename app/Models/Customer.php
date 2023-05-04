<?php

namespace App\Models;

use App\Casts\EpochToDate;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasUuids, HasFactory;

    protected $fillable = [
        'name',
    ];

}
