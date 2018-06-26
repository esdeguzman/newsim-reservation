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

    public function details()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function originalPrice()
    {
        return $this->hasOne(OriginalPrice::class);
    }
}
