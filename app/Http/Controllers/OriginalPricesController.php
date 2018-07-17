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

    public function update(OriginalPrice $originalPrice, Request $request)
    {
        $updatedPriceData = $request->validate([
            'value' => 'required',
            'branch_course_id' => 'required',
            'updated_by' => 'required',
            'remarks' => 'required',
        ]);

        $updatedPrice = str_replace(',', '', $request->value);

        HistoryDetail::create([
            'original_price_id' => $originalPrice->id,
            'updated_by' => $request->updated_by,
            'remarks' => $request->remarks,
            'log' => "updated original price from $originalPrice->value to $updatedPrice",
        ]);

        $originalPrice->value = $updatedPrice;
        $originalPrice->save();

        return back();
    }
}
