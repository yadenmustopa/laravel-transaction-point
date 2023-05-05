<?php
namespace App\Enums;

use App\Traits\EnumToArray;

enum ServiceEnum: string
{
    use EnumToArray;
    case setorTunai = "Setor Tunai";
    case beliPulsa = "Beli Pulsa";
    case bayarListrik = "Bayar Listrik";
    case tarikTunai = "Tarik Tunai";
}
