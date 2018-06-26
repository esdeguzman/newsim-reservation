<?php

namespace App;

use App\Traits\Historiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OriginalPrice extends Model
{
    use SoftDeletes, Historiable;

    protected $guarded = [];

    public function branchCourse()
    {
        return $this->belongsTo(BranchCourse::class);
    }
}
