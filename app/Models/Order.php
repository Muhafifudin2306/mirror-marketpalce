<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'spk',
        'transaction_type',
        'transaction_method',
        'order_design',
        'preview_design',
        'paid_at',
        'payment_status',
        'order_status',
        'status_pengerjaan',
        'subtotal',
        'diskon_persen',
        'potongan_rp',
        'promocode_deduct',
        'deadline',
        'waktu_deadline',
        'express',
        'pickup_status',
        'kurir',
        'ongkir',
        'kebutuhan_proofing',
        'proof_qty',
        'notes',
    ];

    public function getOriginalPrice()
    {
        $orderProduct = $this->orderProducts->first();
        if (!$orderProduct || !$orderProduct->product) {
            return 0;
        }

        $basePrice = $orderProduct->product->price;
        
        $area = 1;
        if ($orderProduct->length && $orderProduct->width) {
            $unit = $orderProduct->product->additional_unit;
            if ($unit === 'cm') {
                $area = ($orderProduct->length / 100) * ($orderProduct->width / 100);
            } elseif ($unit === 'm') {
                $area = $orderProduct->length * $orderProduct->width;
            }
        }

        return $basePrice * $area;
    }

    public function getFinalPrice()
    {
        return $this->subtotal / ($this->orderProducts->first()->qty ?? 1);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderProducts()
    {
        return $this->hasMany(OrderProduct::class);
    }
}