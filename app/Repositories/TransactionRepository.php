<?php
namespace App\Repositories;

use App\Models\Transaction;

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
}