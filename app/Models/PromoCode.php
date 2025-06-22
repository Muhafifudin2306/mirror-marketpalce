<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromoCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'code', 'discount_percent', 'discount_fix', 'max_discount', 'start_at', 'end_at', 'usage_limit',
    ];

    public function orders()
    {
    return $this->hasMany(Order::class, 'promo_code_id');
    }

    // public function usages()
    // {
    //     return $this->hasMany(PromoUsage::class);
    // }
}
