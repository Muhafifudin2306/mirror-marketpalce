<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
