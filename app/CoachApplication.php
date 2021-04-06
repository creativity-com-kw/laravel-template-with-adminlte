<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class CoachApplication extends Model
{
    use SoftDeletes;

    public function getFullNameAttribute() {
        return $this->attributes['full_name'] = $this->middle_name ? "{$this->first_name} {$this->middle_name} {$this->last_name}" : "{$this->first_name} {$this->last_name}";
    }

    public function getAvatarURLAttribute() {
        return $this->attributes['avatar_url'] = $this->avatar ? Storage::url($this->avatar) : null;
    }
}
