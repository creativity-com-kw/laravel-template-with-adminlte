<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    public function employee()
    {
        return $this->belongsTo('App\Department');
    }
}
