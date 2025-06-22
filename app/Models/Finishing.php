<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Finishing extends Model
{
    use HasFactory;

    protected $table = 'finishings';

    protected $fillable = [
        'label_id',
        'finishing_name',
        'finishing_price',
    ];

    public function label()
    {
        return $this->belongsTo(Label::class);
    }
}
