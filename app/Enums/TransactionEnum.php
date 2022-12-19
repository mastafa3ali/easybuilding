<?php

namespace App\Enums;

enum TransactionEnum: int
{
    case SELL = 1;
    case PURCHASE = 2;
    case CHARGE = 3;
    case WITHDRAWAL = 4;
}
