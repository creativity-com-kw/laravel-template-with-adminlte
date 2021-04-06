<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventSchedule extends Model
{
    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime'
    ];

    public function event() {
        return $this->belongsTo('App\Event', 'event_id', 'id');
    }

    public function booking() {
        return $this->hasMany('App\Booking', 'event_schedule_id', 'id');
    }

    public function coach() {
        return $this->belongsTo('App\User', 'coach_id', 'id');
    }
}
