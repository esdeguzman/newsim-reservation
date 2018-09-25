<?php

namespace App\Http\Controllers;

use App\Batch;
use App\HistoryDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use function App\Helper\admin;

class BatchesController extends Controller
{
    public function update(Batch $batch, Request $request)
    {
        $request->validate(
            [
                'cor_numbers' => 'required_if:adjusting_process,add_registered_walkins',
                'capacity' => 'required_if:adjusting_process,adjust_maximum_capacity',
                'remarks' => 'required|min:10'
            ],
            [
                'cor_numbers.required_if' => 'COR number/s is/are required if adjusting process is "Add registered walk-in applicants"',
                'capacity.required_if' => 'Capacity is required is adjusting process is "Adjust maximum capacity"',
            ]
        );


        $oldCapacity = $batch->capacity;
        $corNumbers = $batch->cor_numbers? explode(',', $batch->cor_numbers) : [];
        $totalRegistered = optional($batch->schedule->reservations)->count() + count($corNumbers);

        /*
         * Possible scenario where adjusting available slots is approved:
         *
         * 1. Capacity is not yet reached
         * 2. Schedule has not started yet
         */

        if ($request->capacity) {
            if (optional($batch->schedule->reservations)->count() < $request->capacity) {
                if (Carbon::now()->gte(Carbon::parse($batch->start_date)->startOfDay())) {
                    $request->session()->flash('info', [
                        'title' => 'Schedule capacity not saved!',
                        'type' => 'error',
                        'text' => 'You are trying to set the capacity of a schedule that is already starting/started.',
                        'confirmButtonColor' => '#DD6B55',
                        'confirmButtonText' => 'CONTINUE',
                    ]);


                    HistoryDetail::create([
                        'schedule_id' => $batch->schedule->id,
                        'updated_by' => admin()->id,
                        'remarks' => $request->remarks,
                        'log' => "An admin tried to change batch capacity from {$oldCapacity} to {$batch->capacity} but the schedule is already starting/started. Please refer to responsible tab.",
                    ]);

                    return back();
                }

                if ($totalRegistered > $request->capacity) {
                    $request->session()->flash('info', [
                        'title' => 'Schedule capacity not saved!',
                        'type' => 'error',
                        'text' => 'You are trying to set the capacity less than the actual number of registered trainee.',
                        'confirmButtonColor' => '#DD6B55',
                        'confirmButtonText' => 'I WILL CHECK IT',
                    ]);


                    HistoryDetail::create([
                        'schedule_id' => $batch->schedule->id,
                        'updated_by' => admin()->id,
                        'remarks' => $request->remarks,
                        'log' => "An admin tried to change batch capacity from {$oldCapacity} to {$batch->capacity}. Please refer to responsible tab.",
                    ]);
                } elseif ($totalRegistered <= $request->capacity) {
                    $batch->capacity = $request->capacity;
                    $batch->save();

                    HistoryDetail::create([
                        'schedule_id' => $batch->schedule->id,
                        'updated_by' => admin()->id,
                        'remarks' => $request->remarks,
                        'log' => "Batch capacity has been changed from {$oldCapacity} to {$batch->capacity}",
                    ]);

                    $request->session()->flash('info', [
                        'title' => 'Schedule successfully updated!',
                        'type' => 'success',
                        'text' => 'Schedule capacity has been updated and saved!',
                        'confirmButtonColor' => '#DD6B55',
                        'confirmButtonText' => 'CONTINUE',
                    ]);
                }
            }
        } elseif ($request->cor_numbers) {
            $oldCorNumbers = $batch->cor_numbers;

            $batch->cor_numbers = $request->cor_numbers;
            $batch->save();

            HistoryDetail::create([
                'schedule_id' => $batch->schedule->id,
                'updated_by' => admin()->id,
                'remarks' => $request->remarks,
                'log' => "Added new registered trainee from TMS, changes are as follows: old COR#s {$oldCorNumbers} to new COR#s {$batch->cor_numbers}",
            ]);
        }

        return back();
    }
}