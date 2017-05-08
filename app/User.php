<?php

namespace App;

use App\Notifications\EmailResetPassword;
use App\Notifications\EmailVerification;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable;
    use HasRoles;
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $dates = ['deleted_at'];

    public function verified()
    {
        $this->emailVerified = true;
        $this->save();
    }
    public function sendVerifyEmail()
    {
        $this->notify(new EmailVerification($this));
    }
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new EmailResetPassword($this, $token));
    }
}
