<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model {
    protected $fillable = ['schedule_id', 'user_id', 'status'];

    public function schedule() {
        return $this->belongsTo(Schedule::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}