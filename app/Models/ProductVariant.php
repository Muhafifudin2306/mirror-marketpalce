<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'category',
        'value',
        'price',
        'is_available'
    ];

    protected $casts = [
        'is_available' => 'boolean'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function getPriceNumericAttribute()
    {
        return (float) str_replace(',', '', $this->price);
    }

    public function getFormattedPriceAttribute()
    {
        $numericPrice = $this->getPriceNumericAttribute();
        if ($numericPrice > 0) {
            return '+' . number_format($numericPrice, 0, ',', '.');
        }
        return '';
    }

    public function scopeAvailable($query)
    {
        return $query->where('is_available', 1);
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('category')->orderBy('value');
    }
}