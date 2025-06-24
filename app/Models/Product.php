<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'uuid',
        'name',
        'label_id',
        'price',
        'additional_size',
        'additional_unit',
        'long_product',
        'width_product',
        'min_qty',
        'max_qty',
        'slug',
        'production_time',
        'description',
        'spesification_desc',
    ];

    protected $casts = [
        'price'            => 'decimal:2',
        'long_product'     => 'decimal:2',
        'width_product'    => 'decimal:2',
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = (string) Str::uuid();
            }
        });
    }

    public function label()
    {
        return $this->belongsTo(Label::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function orderProducts()
    {
        return $this->hasMany(OrderProduct::class);
    }

    public function discounts()
    {
        return $this->belongsToMany(Discount::class, 'discount_product', 'product_id', 'discount_id')
                    ->withTimestamps();
    }
}
