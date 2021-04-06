<?php

namespace App;

use App\Notifications\Admin\ResetPasswordNotification;
use App\Notifications\Admin\VerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable, HasApiTokens, HasRoles;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getFullNameAttribute() {
        return $this->attributes['full_name'] = $this->middle_name ? "{$this->first_name} {$this->middle_name} {$this->last_name}" : "{$this->first_name} {$this->last_name}";
    }

    public function getAvatarURLAttribute() {
        return $this->attributes['avatar_url'] = $this->avatar ? Storage::url($this->avatar) : null;
    }

    public function getDispPositionAttribute() {
        if ($this->coach_type == 1) {
            return $this->attributes['disp_position'] = 'Full-Time';
        } else if ($this->coach_type == 2) {
            return $this->attributes['disp_position'] = 'Part-Time';
        } else if ($this->coach_type == 3) {
            return $this->attributes['disp_position'] = 'Freelancer';
        } else {
            return $this->attributes['disp_position'] = null;
        }
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    /**
     * Send the email verification notification.
     *
     * @return void
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmail);
    }
}
