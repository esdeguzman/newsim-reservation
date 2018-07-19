<?php

namespace App;

use function App\Helper\trainee;
use App\Traits\Historiable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Trainee extends Model
{
    use SoftDeletes, Historiable;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function fullName()
    {
        return $this->first_name . ' ' .$this->middle_name . ' ' .$this->last_name;
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function hasReservations()
    {
        return Reservation::where('trainee_id', trainee()->id)->withTrashed()->get()->count() > 0? true : false;
    }
}
