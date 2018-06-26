<?php

namespace App\Http\Controllers;

use App\HistoryDetail;
use App\OriginalPrice;
use Illuminate\Http\Request;

class OriginalPricesController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'can.access']);
    }

    public function store(Request $request)
    {
        $newOriginalPriceValue = $request->validate([
            'value' => 'required',
            'added_by' => 'required',
            'branch_course_id' => 'required',
        ]);

        $newOriginalPriceValue['value'] = str_replace(',', '', $request->value);

        OriginalPrice::create($newOriginalPriceValue);

        return back();
    }

    public function update(OriginalPrice $original_price, Request $request)
    {
        $updatedPriceData = $request->validate([
            'value' => 'required',
            'branch_course_id' => 'required',
            'updated_by' => 'required',
            'remarks' => 'required',
        ]);

        $updatedPrice = str_replace(',', '', $request->value);

        // create a copy of course with the remarks from administrator
        $originalPriceRevisedCopy = OriginalPrice::create([
            'branch_course_id' => $request->branch_course_id,
            'original_price_id' => $original_price->id,
            'value' => $original_price->value,
            'added_by' => auth()->user()->id,
        ]);

        // create history details
        HistoryDetail::create([
            'original_price_id' => $originalPriceRevisedCopy->id,
            'updated_by' => $request->updated_by,
            'remarks' => $request->remarks,
        ]);

        // soft delete the copy to make it a history item
        $originalPriceRevisedCopy->delete();

        // finally, update the original price to the updated values from administrator
        $original_price->value = $updatedPrice;
        $original_price->save();

        return back();
    }
}
