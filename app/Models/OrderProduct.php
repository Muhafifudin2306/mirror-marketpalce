<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    use HasFactory;

    protected $table = 'order_products';

    protected $fillable = [
        'order_id',
        'product_id',
        'material_type',
        'finishing_type',
        'length',
        'width',
        'qty',
        'subtotal',
        'jenis_cetakan',
        'jenis_bahan',
        'panjang',
        'lebar',
        'jumlah_pesanan',
        'jenis_finishing',
        'desain',
        'preview'
    ];
    
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}