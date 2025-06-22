<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'phone', 'province', 'city', 'address', 'postal_code', 'role', 'email', 'password',
    ];

    protected $appends = ['first_name', 'last_name'];

    public function getFirstNameAttribute(): string
    {
        return explode(' ', $this->name)[0];
    }

    public function getLastNameAttribute(): string
    {
        $parts = explode(' ', $this->name);
        array_shift($parts);
        return implode(' ', $parts);
    }

    public function setFirstNameAttribute($value): void
    {
        $last = $this->last_name;
        $this->attributes['name'] = trim($value . ' ' . $last);
    }

    public function setLastNameAttribute($value): void
    {
        $first = $this->first_name;
        $this->attributes['name'] = trim($first . ' ' . $value);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function chats()
    {
        return $this->hasMany(Chat::class);
    }
}
