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
        'has_category'
    ];

    protected $casts = [
        'price'            => 'decimal:2',
        'long_product'     => 'decimal:2',
        'width_product'    => 'decimal:2',
        'has_category' => 'boolean',
    ];

    public function label()
    {
        return $this->belongsTo(Label::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function availableVariants()
    {
        return $this->hasMany(ProductVariant::class)->where('is_available', true);
    }

    public function getVariantsByCategoryAttribute()
    {
        return $this->variants->groupBy('category');
    }

    public function hasVariants()
    {
        return $this->has_category && $this->variants()->exists();
    }

    public function getMinVariantPrice()
    {
        if (!$this->hasVariants()) {
            return 0;
        }
        
        $variants = $this->variants()->get();
        if ($variants->isEmpty()) {
            return 0;
        }
        
        $prices = $variants->map(function($variant) {
            return (float) str_replace(',', '', $variant->price);
        });
        
        return $prices->min();
    }

    public function getMaxVariantPrice()
    {
        if (!$this->hasVariants()) {
            return 0;
        }
        
        $variants = $this->variants()->get();
        if ($variants->isEmpty()) {
            return 0;
        }
        
        $prices = $variants->map(function($variant) {
            return (float) str_replace(',', '', $variant->price);
        });
        
        return $prices->max();
    }

    public function getPriceRangeAttribute()
    {
        if (!$this->hasVariants()) {
            return 'Rp ' . number_format($this->price, 0, ',', '.');
        }

        $minPrice = $this->price + $this->getMinVariantPrice();
        $maxPrice = $this->price + $this->getMaxVariantPrice();

        if ($minPrice == $maxPrice) {
            return 'Rp ' . number_format($minPrice, 0, ',', '.');
        }

        return 'Rp ' . number_format($minPrice, 0, ',', '.') . ' - ' . number_format($maxPrice, 0, ',', '.');
    }

    public function getMinimumPrice()
    {
        if (!$this->hasVariants()) {
            return $this->price;
        }

        return $this->price + $this->getMinVariantPrice();
    }

    public function getMaximumPrice()
    {
        if (!$this->hasVariants()) {
            return $this->price;
        }

        return $this->price + $this->getMaxVariantPrice();
    }

    public function calculateFinalPrice($selectedVariants = [])
    {
        $basePrice = $this->getDiscountedPrice();
        $variantPrice = 0;

        if (!empty($selectedVariants) && $this->hasVariants()) {
            foreach ($selectedVariants as $variantId) {
                $variant = $this->variants()->find($variantId);
                if ($variant && $variant->is_available == 1) {
                    $variantPrice += (float) str_replace(',', '', $variant->price);
                }
            }
        }

        return $basePrice + $variantPrice;
    }

    public function getAvailableCategories()
    {
        return $this->variants()
            ->select('category')
            ->distinct()
            ->pluck('category')
            ->toArray();
    }

    public function getVariantsByCategory($category)
    {
        return $this->variants()->where('category', $category)->get();
    }

    public function hasAvailableVariantsInAllCategories()
    {
        if (!$this->hasVariants()) {
            return true;
        }

        $categories = $this->getAvailableCategories();
        
        foreach ($categories as $category) {
            $hasAvailable = $this->variants()
                ->where('category', $category)
                ->where('is_available', 1)
                ->exists();
                
            if (!$hasAvailable) {
                return false;
            }
        }
        
        return true;
    }

    public function scopeLive($query)
    {
        return $query->where('is_live', true);
    }

    public function scopeWithVariants($query)
    {
        return $query->where('has_category', true)->has('variants');
    }

    public function scopeSingleProducts($query)
    {
        return $query->where('has_category', false);
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