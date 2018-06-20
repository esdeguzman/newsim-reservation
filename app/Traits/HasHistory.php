<?php

namespace App\Traits;

trait HasHistory
{
    public function history()
    {
        return $this->onlyTrashed()
            ->with('updatedBy')
            ->where(str_singular($this->getTable()) . '_id', $this->id)
            ->get();
    }
}