<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentTransaction extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function reservation()
    {
        return $this->belongsTo(Reservation::class)->withTrashed();
    }
}
