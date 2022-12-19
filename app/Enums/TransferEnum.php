<?php

namespace App\Enums;

enum TransferEnum: int
{
    case QR = 1;
    case VODAFONECASH = 2;
    case ETISALATCASH = 3;
    case ORANGECASH = 4;
}
