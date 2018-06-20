<?php

namespace App;

use App\Traits\HasHistory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OriginalPrice extends Model
{
    use SoftDeletes, HasHistory;

    protected $guarded = [];

    public function branchCourse()
    {
        return $this->belongsTo(BranchCourse::class);
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
