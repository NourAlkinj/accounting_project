<?php

namespace App\Enums;

enum StoringType: string
{
    case IN = "IN";
    case OUT = "OUT";
    case EXCHANGE = "EXCHANGE";
}
