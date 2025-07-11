<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $fillable = ['slug', 'content', 'banner', 'user_id', 'title', 'blog_type', 'is_live'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
