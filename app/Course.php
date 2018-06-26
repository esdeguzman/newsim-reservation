<?php

namespace App;

use App\Traits\Historiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use SoftDeletes, Historiable;

    protected $guarded = [];
}
