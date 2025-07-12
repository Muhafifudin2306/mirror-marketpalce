<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
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
        'is_live',
    ];

    protected $casts = [
        'price'            => 'decimal:2',
        'long_product'     => 'decimal:2',
        'width_product'    => 'decimal:2',
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
    
    public function activeDiscounts(): BelongsToMany
    {
        return $this->discounts()
                    ->where('start_discount', '<=', now())
                    ->where('end_discount', '>=', now());
    }

    public function hasActiveDiscount(): bool
    {
        return $this->activeDiscounts()->exists();
    }

    public function getDiscountedPrice(): float
    {
        $basePrice = (float) $this->price;
        $activeDiscounts = $this->activeDiscounts()->get();

        if ($activeDiscounts->isEmpty()) {
            return $basePrice;
        }

        $bestFinalPrice = $basePrice;

        foreach ($activeDiscounts as $discount) {
            if ($discount->discount_percent) {
                $discountAmount = $basePrice * ($discount->discount_percent / 100);
            } else {
                $discountAmount = (float) $discount->discount_fix;
            }

            $finalPrice = max(0, $basePrice - $discountAmount);
            
            if ($finalPrice < $bestFinalPrice) {
                $bestFinalPrice = $finalPrice;
            }
        }

        return $bestFinalPrice;
    }

    public function getBestDiscount()
    {
        $basePrice = (float) $this->price;
        $activeDiscounts = $this->activeDiscounts()->get();

        if ($activeDiscounts->isEmpty()) {
            return null;
        }

        $bestDiscount = null;
        $bestFinalPrice = $basePrice;

        foreach ($activeDiscounts as $discount) {
            if ($discount->discount_percent) {
                $discountAmount = $basePrice * ($discount->discount_percent / 100);
            } else {
                $discountAmount = (float) $discount->discount_fix;
            }

            $finalPrice = max(0, $basePrice - $discountAmount);
            
            if ($finalPrice < $bestFinalPrice) {
                $bestFinalPrice = $finalPrice;
                $bestDiscount = $discount;
            }
        }

        return $bestDiscount;
    }

    public function getDiscountAmount(): float
    {
        $basePrice = (float) $this->price;
        $discountedPrice = $this->getDiscountedPrice();
        
        return $basePrice - $discountedPrice;
    }

    public function getDiscountPercentage(): float
    {
        $basePrice = (float) $this->price;
        $discountAmount = $this->getDiscountAmount();
        
        if ($basePrice <= 0) {
            return 0;
        }
        
        return round(($discountAmount / $basePrice) * 100, 2);
    }

    public function getFormattedPrice(): string
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    public function getFormattedDiscountedPrice(): string
    {
        return 'Rp ' . number_format($this->getDiscountedPrice(), 0, ',', '.');
    }

    public function getFormattedDiscountAmount(): string
    {
        return 'Rp ' . number_format($this->getDiscountAmount(), 0, ',', '.');
    }

    public function getDiscountLabel(): string
    {
        $bestDiscount = $this->getBestDiscount();
        
        if (!$bestDiscount) {
            return '';
        }

        if ($bestDiscount->discount_percent) {
            return "-{$bestDiscount->discount_percent}%";
        } else {
            return "-" . number_format($bestDiscount->discount_fix, 0, ',', '.');
        }
    }

    public function getActiveDiscountsWithAmounts(): array
    {
        $basePrice = (float) $this->price;
        $activeDiscounts = $this->activeDiscounts()->get();
        $results = [];

        foreach ($activeDiscounts as $discount) {
            if ($discount->discount_percent) {
                $discountAmount = $basePrice * ($discount->discount_percent / 100);
                $type = 'percent';
                $value = $discount->discount_percent;
                $displayValue = "{$discount->discount_percent}%";
            } else {
                $discountAmount = (float) $discount->discount_fix;
                $type = 'fix';
                $value = $discount->discount_fix;
                $displayValue = "Rp " . number_format($discount->discount_fix, 0, ',', '.');
            }

            $finalPrice = max(0, $basePrice - $discountAmount);
            
            $results[] = [
                'discount' => $discount,
                'type' => $type,
                'value' => $value,
                'display_value' => $displayValue,
                'discount_amount' => $discountAmount,
                'final_price' => $finalPrice,
                'is_best' => false,
            ];
        }

        usort($results, function($a, $b) {
            return $a['final_price'] <=> $b['final_price'];
        });

        if (!empty($results)) {
            $results[0]['is_best'] = true;
        }

        return $results;
    }

    public function isOnSale(): bool
    {
        return $this->hasActiveDiscount();
    }
    
    public function getSaleBadge(): string
    {
        if (!$this->isOnSale()) {
            return '';
        }

        $percentage = $this->getDiscountPercentage();
        return "HEMAT {$percentage}%";
    }
}