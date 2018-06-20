<?php

namespace App;

use App\Traits\HasHistory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use SoftDeletes, HasHistory;

    protected $guarded = [];

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
