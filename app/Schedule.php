<?php

namespace App;

use App\Traits\Historiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Schedule extends Model
{
    use SoftDeletes, Historiable;

    protected $guarded = [];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function branchCourse()
    {
        return $this->belongsTo(BranchCourse::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function monthName()
    {
        $dateObject = \DateTime::createFromFormat('!m', $this->month);
        return $dateObject->format('F');
    }

    public function discountPercentage()
    {
        return $this->discount * 100 . '%';
    }
}
