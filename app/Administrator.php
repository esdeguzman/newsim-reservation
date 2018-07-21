<?php

namespace App;

use App\Traits\Historiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Administrator extends Model
{
    use SoftDeletes, Historiable;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    public function roles()
    {
        return $this->hasMany(AdministratorRole::class, 'administrator_id');
    }

    public function updatedBy()
    {
        return $this->hasOne(null, 'updated_by');
    }

    public function registeredReservation()
    {
        return $this->hasOne(null, 'registered_by');
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
