<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function administrator()
    {
        return $this->hasOne(Administrator::class);
    }

    public function trainee()
    {
        return $this->hasOne(Trainee::class);
    }

    public function updatedCourse()
    {
        return $this->hasOne(Course::class, 'updated_by');
    }

    public function isDev()
    {
        return $this->administrator->roles->where('role_id', 1)->count() > 0 ? true: false;
    }
}
