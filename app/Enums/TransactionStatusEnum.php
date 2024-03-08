<?php

namespace App\Enums;

enum TransactionStatusEnum: int
{
    case PENDING = 1;
    case APPROVED = 2;
    case CANCELED = 3;
}
