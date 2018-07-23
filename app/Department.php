<?php

namespace App;

use App\Traits\Historiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
    use SoftDeletes, Historiable;

    protected $guarded = [];

    public function administrators()
    {
        return $this->hasMany(Administrator::class);
    }
}
