<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BranchCourse extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function originalPrice()
    {
        return $this->hasOne(OriginalPrice::class);
    }
}
