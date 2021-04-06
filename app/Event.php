<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Event extends Model
{
    use SoftDeletes;

    public function eventSchedules() {
        return $this->hasMany('App\EventSchedule', 'event_id', 'id');
    }

    public function eventSchedule() {
        return $this->hasOne('App\EventSchedule', 'event_id', 'id');
    }

    public function bookings() {
        return $this->hasMany('App\Booking', 'event_id', 'id');
    }

    public function getImageURLAttribute() {
        return $this->attributes['image_url'] = $this->image ? Storage::url($this->image) : null;
    }
}
