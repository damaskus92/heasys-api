<?php

namespace App\Enums;

enum StatusEnum: int
{
    case PROCESS = 0;
    case SUCCESS = 1;

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
