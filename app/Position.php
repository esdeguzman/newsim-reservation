<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Position extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function administrators()
    {
        return $this->hasMany(Administrator::class);
    }
}
