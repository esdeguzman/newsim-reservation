<?php

namespace App\Traits;

use App\HistoryDetail;

trait Historiable
{
    public function history()
    {
        return $this->onlyTrashed()
            ->where(str_singular($this->getTable()) . '_id', $this->id)
            ->get()
            ->sortByDesc('created_at');
    }

    public function historyDetails()
    {
        return $this->hasOne(HistoryDetail::class);
    }

    public function hasHistory()
    {
        return $this->onlyTrashed()->where(str_singular($this->getTable()) . '_id', $this->id)->count() > 0? true : false;
    }
}