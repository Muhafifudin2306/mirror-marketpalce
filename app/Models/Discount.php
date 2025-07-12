<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Discount extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'discount_percent', 'discount_fix', 'start_discount', 'end_discount',
    ];

    protected $casts = [
      'start_discount' => 'datetime',
      'end_discount'   => 'datetime',
    ];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'discount_product')
                    ->withTimestamps();
    }

    public function isActive(): bool
    {
        $now = now();
        return $this->start_discount <= $now && $this->end_discount >= $now;
    }

    public function scopeActive($query)
    {
        return $query->where('start_discount', '<=', now())
                    ->where('end_discount', '>=', now());
    }
}
