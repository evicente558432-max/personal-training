<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable {
    protected $fillable = ['name', 'email', 'password', 'role'];

    protected $hidden = ['password'];

    public function trainer() {
        return $this->hasOne(Trainer::class);
    }

    public function bookings() {
        return $this->hasMany(Booking::class);
    }
}