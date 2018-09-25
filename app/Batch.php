<?php

namespace App;

use App\Traits\Historiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Batch extends Model
{
    use SoftDeletes, Historiable;

    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }

    public function corNumbers()
    {
    	return $this->cor_numbers? explode(',', $this->cor_numbers) : [];
    }

    public function hasCorNumber($corNumber)
    {
    	return str_contains($this->cor_numbers, $corNumber);
    }

    public function addCorNumber($corNumber)
    {
    	if ($this->cor_numbers) {
    		$this->cor_numbers = "{$this->cor_numbers},{$corNumber}";
    	} else {
    		$this->cor_numbers = $corNumber;
    	}

		$this->save();
    }
}
