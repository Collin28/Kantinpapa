<?php

namespace App\Enums;

enum OrderStatus: string
{
    case Pending = 'pending';
    case Paid = 'paid';
    case Preparing = 'preparing';
    case Ready = 'ready';
    case Completed = 'completed';
    case Cancelled = 'cancelled';

    public function label(): string
    {
        return ucfirst($this->value);
    }

    public function badgeClasses(): string
    {
        return match ($this) {
            self::Pending => 'bg-orange-50 border border-orange-200 text-orange-600',
            self::Paid => 'bg-indigo-50 border border-indigo-200 text-indigo-600',
            self::Preparing => 'bg-amber-50 border border-amber-200 text-amber-600',
            self::Ready => 'bg-purple-50 border border-purple-200 text-purple-600',
            self::Completed => 'bg-emerald-50 border border-emerald-200 text-emerald-600',
            self::Cancelled => 'bg-rose-50 border border-rose-200 text-rose-600',
        };
    }
}
