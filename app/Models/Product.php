<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $tables = 'products';

    protected $fillable = [
        'label_id',
        'price',
        'name',
        'min_qty',
        'max_qty',
        'long_product',
        'width_product',
        'additional_size',
        'additional_unit',
        'price_per_size'
    ];

    public function label()
    {
        return $this->belongsTo(Label::class);
    }
}
