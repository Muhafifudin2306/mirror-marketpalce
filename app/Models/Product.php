<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'discount_percent',
        'discount_fix',
        'start_discount',
        'end_discount',
        'slug',
        'production_time',
        'description',
        'spesification_desc',
    ];

    protected $casts = [
        'price'            => 'decimal:2',
        'long_product'     => 'decimal:2',
        'width_product'    => 'decimal:2',
        'discount_percent' => 'decimal:2',
        'discount_fix'     => 'decimal:2',
        'start_discount'   => 'datetime',
        'end_discount'     => 'datetime',
    ];

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
