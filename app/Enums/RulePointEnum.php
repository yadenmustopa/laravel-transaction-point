<?php
namespace App\Enums;

use App\Traits\EnumToArray;

enum RulePointEnum: int
{
    use EnumToArray;
    case beliPulsa = 1000;
    case bayarListrik = 2000;
}