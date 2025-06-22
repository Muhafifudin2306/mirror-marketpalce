<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Label extends Model
{
    protected $tables = 'labels';

    protected $fillable = ['name', 'size', 'unit', 'desc', 'type'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function finishings()
    {
        return $this->hasMany(Finishing::class);
    }
}
