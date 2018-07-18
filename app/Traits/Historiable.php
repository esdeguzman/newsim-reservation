<?php

namespace App\Traits;

use App\HistoryDetail;

trait Historiable
{
    public function history()
    {
        return $this->historyDetails->sortByDesc('created_at');
    }

    public function historyDetails()
    {
        return $this->hasMany(HistoryDetail::class);
    }

    public function hasHistory()
    {
        return HistoryDetail::where(str_singular($this->getTable()) . '_id', $this->id)->count() > 0? true : false;
    }
}