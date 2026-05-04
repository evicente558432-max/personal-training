<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model {
    protected $fillable = ['trainer_id', 'date', 'start_time', 'end_time', 'status'];

    public function trainer() {
        return $this->belongsTo(Trainer::class);
    }

    public function booking() {
        return $this->hasOne(Booking::class);
    }
}