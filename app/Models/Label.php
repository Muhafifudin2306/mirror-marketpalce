<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Label extends Model
{
    use HasFactory;

    protected $table = 'labels';

    protected $fillable = [
        'name',
        'type',
        'desc',
        'size',
        'unit',
    ];

    /**
     * Satu label bisa punya banyak produk.
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }
    
    public function finishings()
    {
        return $this->hasMany(Finishing::class);
    }
}
