<?php
namespace App\Enums;

use App\Traits\EnumToArray;

/**
 * Summary of StatusEnum
 * @author Yaden Mustopa
 * @copyright (c) 2023
 */
enum StatusEnum: string
{
    use EnumToArray;
    case debit = 'D';
    case credit = 'C';
}
