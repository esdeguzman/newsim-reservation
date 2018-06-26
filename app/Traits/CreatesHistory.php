<?php

namespace App\Traits;

use App\HistoryDetail;

trait CreatesHistory {

    public function createHistory($request, $related_id_array)
    {
        return HistoryDetail::create([
                $related_id_array['key'] => $related_id_array['value'],
                'remarks' => $request->remarks,
                'updated_by' => $request->updated_by,
            ]);
    }
}