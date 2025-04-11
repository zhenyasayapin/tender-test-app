<?php

namespace App\Enum;

enum TenderStatusEnum: string
{
    case OPEN = 'Открыто';
    case CLOSED = 'Закрыто';
    case CANCELLED = 'Отменено';
}