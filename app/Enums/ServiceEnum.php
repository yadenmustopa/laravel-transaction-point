<?php
namespace App\Enums;


enum ServiceEnum: string
{
    case setorTunai = "Setor Tunai";
    case beliPulsa = "Beli Pulsa";
    case bayarListrik = "Bayar Listrik";
    case tarikTunai = "Tarik Tunai";
}