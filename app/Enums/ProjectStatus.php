<?php

namespace App\Enums;

enum ProjectStatus: string
{
    case PENDING = 'pending';
    case ONGOING = 'ongoing';
    case COMPLETED = 'completed';
    case CANCELED = 'canceled';

    public static function values(): array
    {
        return [
            self::PENDING->value,
            self::ONGOING->value,
            self::COMPLETED->value,
            self::CANCELED->value,
        ];
    }
}