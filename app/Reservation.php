<?php

namespace App;

use function App\Helper\computePayment;
use App\Traits\Historiable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reservation extends Model
{
    use SoftDeletes, Historiable;

    protected $guarded = [];

    public function paymentTransactions()
    {
        return $this->hasMany(PaymentTransaction::class);
    }

    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }

    public function trainee()
    {
        return $this->belongsTo(Trainee::class);
    }

    public function confirmedBy()
    {
        return $this->belongsTo(Administrator::class, 'confirmed_by');
    }

    public function registeredBy()
    {
        return $this->belongsTo(Administrator::class, 'registered_by');
    }

    public function hasPaymentTransactions()
    {
        return $this->paymentTransactions->count() > 0? true : false;
    }

    public function generateCode($schedule)
    {
        return 'R' . $this->prependZeroes(auth()->user()->trainee->id) . Carbon::now()->year . '-'
                    . strtoupper($schedule->branchCourse->branch->code)
                    . $this->prependZeroes(Reservation::where('branch_id', $schedule->branchCourse->branch->id)
                                                                    ->withTrashed()->whereYear('created_at', now()->year)
                                                                    ->get()->count() + 1);
    }

    private function prependZeroes($number)
    {
        $numberWithZeroes = null;

        if ($number < 10) $numberWithZeroes = "000{$number}";
        elseif ($number < 100) $numberWithZeroes = "00{$number}";
        elseif ($number < 1000) $numberWithZeroes = "0{$number}";
        elseif ($number > 1000) $numberWithZeroes = $number;

        return $numberWithZeroes;
    }

    public function isExpired()
    {
        return $this->status == 'expired'? true : false;
    }

    public function hasRefund()
    {
        if ($this->paymentTransactions->contains('status', 'confirmed') &&
            ! $this->historyDetails->contains('remarks', 'refunded excess payment')) return true;

        return false;
    }

    public function hasExcessPayment()
    {
        $totalPayment = $this->paymentTransactions->pluck('received_amount')->sum();
        if ($totalPayment > computePayment($this->original_price, $this->discount)) return true;

        return false;
    }

    public function isPaidOrExpiredButCancelled()
    {
        if ($this->paymentTransactions->contains('status', 'confirmed') &&
            ($this->status == 'cancelled' || $this->status == 'expired')) return true;

        return false;
    }
}
