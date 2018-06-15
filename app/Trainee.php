<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Trainee extends Model
{
    use SoftDeletes;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function fullName()
    {
        return $this->first_name . ' ' .$this->middle_name . ' ' .$this->last_name;
    }
}
