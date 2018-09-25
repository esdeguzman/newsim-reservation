<?php

namespace App;

use App\Batch;
use App\Traits\Historiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Schedule extends Model
{
    use SoftDeletes, Historiable;

    protected $guarded = [];

    public function batch()
    {
        return $this->hasOne(Batch::class);
    }

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

    public function isFull()
    {
        $walkinApplicants = $this->batch->cor_numbers? explode(',', $this->batch->cor_numbers) : [];
        $totalRegisteredTrainees = count($walkinApplicants) + optional($this->reservations)->count();

        return $totalRegisteredTrainees >= $this->batch->capacity? true : false;
    }

    public function batches($year = 2018)
    {
        return Batch::whereHas('schedule', function ($query) {
                    $query->where('course_id', $this->course_id);
                })->whereYear('created_at', $year)->get();
    }

    public function hasReservations()
    {
        $reservations = optional($this->whereHas('reservations', function ($query) {
                    $query->whereIn('status', ['paid', 'registered']);
                }))->count();

        return $corNumbers = optional($this->whereHas('batch', function ($query) {
                    $query->where('cor_numbers', '!=', null)
                    ->where('cor_numbers', '!=', '')
                    ->where('id', $this->batch->id);
                }))->count();

        return ($reservations > 0) or ($corNumbers > 0)? true : false;
    }

    public function hasWalkinApplicants()
    {
        return $this->batch->cor_numbers? true : false;
    }

    public function paidReservations()
    {
        return $this->whereHas('reservations', function ($query) {
                    $query->whereIn('status', ['paid', 'registered']);
                })->whereHas('batch', function ($query) {
                    $query->where('id', $this->batch->id);
                });
    }

    public function hasReservationCode($code)
    {
        return optional($this->whereHas('reservations', function ($query) use ($code) {
                    $query->where('code', $code);
                }))->count() > 0? true : false;
    }
}
