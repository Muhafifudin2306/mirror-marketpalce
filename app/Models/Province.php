<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    protected $fillable = ['id', 'nama', 'latitude', 'longitude'];
    public $incrementing = false;

    public function regencies()
    {
        return $this->hasMany(Regency::class);
    }

    public function districts()
    {
        return $this->hasMany(District::class);
    }

    public function villages()
    {
        return $this->hasMany(Village::class);
    }
}
