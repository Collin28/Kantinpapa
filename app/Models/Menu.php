<?php

namespace App\Models;

use Database\Factories\MenuFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['category_id', 'name', 'description', 'price', 'img_url', 'is_available', 'stock'])]
class Menu extends Model
{
    /** @use HasFactory<MenuFactory> */
    use HasFactory;

    protected $attributes = [
        'is_available' => true,
        'stock' => 0,
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'is_available' => 'boolean',
            'stock' => 'integer',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function isSoldOut(): bool
    {
        return ! $this->is_available || $this->stock <= 0;
    }

    public function formattedPrice(): string
    {
        return 'Rp '.number_format((float) $this->price, 0, ',', '.');
    }

    public function imageUrl(): string
    {
        if (! $this->img_url) {
            return 'https://images.unsplash.com/photo-1544025162-d76694265947?q=80&w=800';
        }

        if (str_starts_with($this->img_url, 'http')) {
            return $this->img_url;
        }

        return asset('storage/'.$this->img_url);
    }
}
