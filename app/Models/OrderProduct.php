<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
     protected $fillable = [
        'order_id',
        'jenis_cetakan',
        'jenis_bahan',
        'panjang',
        'lebar',
        'jumlah_pesanan',
        'jenis_finishing',
        'desain',
        'preview',
        'subtotal'
    ];
}
