<?php

namespace App;

use App\Traits\Historiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Position extends Model
{
    use SoftDeletes, Historiable;

    protected $guarded = [];

    public function administrators()
    {
        return $this->hasMany(Administrator::class);
    }
}
