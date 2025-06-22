<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Finishing extends Model
{
    protected $tables = 'finishings';

    protected $fillable = [
        'label_id',
        'finishing_price',
        'finishing_name'
    ];

    public function label()
    {
        return $this->belongsTo(Label::class);
    }
}
