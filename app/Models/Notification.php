<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    protected $table = "notifications";

    protected $fillable = [
        'user_id',
        'notification_head',
        'notification_body',
        'notification_type',
        'notification_status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
