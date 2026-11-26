<?php

namespace App\Enums;

enum PaymentStatus: string
{
    case Pending = 'pending';
    case Paid = 'paid';
    case Failed = 'failed';

    public function label(): string
    {
        return ucfirst($this->value);
    }

    public function badgeClasses(): string
    {
        return match ($this) {
            self::Pending => 'bg-orange-50 border border-orange-200 text-orange-600',
            self::Paid => 'bg-blue-50 border border-blue-200 text-blue-600',
            self::Failed => 'bg-red-50 border border-red-200 text-red-600',
        };
    }
}
