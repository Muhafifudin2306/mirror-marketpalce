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
        'preview',
        'variant_details',
        'selected_variants'
    ];

    protected $casts = [
        'selected_variants' => 'array'
    ];
    
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function getSelectedVariantsAttribute($value)
    {
        return $value ? json_decode($value, true) : [];
    }

    public function setSelectedVariantsAttribute($value)
    {
        $this->attributes['selected_variants'] = $value ? json_encode($value) : null;
    }

    public function getVariantDetailsFormatted()
    {
        if ($this->variant_details) {
            return $this->variant_details;
        }

        if ($this->selected_variants && is_array($this->selected_variants)) {
            $variants = ProductVariant::whereIn('id', $this->selected_variants)->get();
            $details = [];
            
            foreach ($variants as $variant) {
                $details[] = ucfirst($variant->category) . ': ' . $variant->value;
            }
            
            return implode(', ', $details);
        }

        return 'Produk Standar';
    }

    public function getTotalVariantPrice()
    {
        if (!$this->selected_variants || !is_array($this->selected_variants)) {
            return 0;
        }

        return ProductVariant::whereIn('id', $this->selected_variants)->sum('price');
    }
}