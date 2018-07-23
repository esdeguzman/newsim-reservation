<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    //

    public function administrators()
    {
        return $this->hasMany(Administrator::class);
    }
}
