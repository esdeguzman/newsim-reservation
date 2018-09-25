<?php

namespace App\Http\Controllers;

use App\Batch;
use App\BranchCourse;
use App\HistoryDetail;
use App\Reservation;
use App\Schedule;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function App\Helper\admin;
use function App\Helper\prefixedUrl;
use function App\Helper\toPercentage;

class SchedulesController extends Controller
{
    public function index(Request $request)
    {
        $view = null;
        if ($request->has('branch')) {
            $schedules = Schedule::whereHas('branch', function ($query) use ($request) {
                                        $query->where('name', $request->branch);
                                    })->whereYear('created_at', now()->year)->get();

            $branchCourses = BranchCourse::with('originalPrice')->whereHas('branch', function ($query) use ($request) {
                                                $query->where('name', $request->branch);
                                            })
                                ->whereHas('originalPrice')
                                ->whereYear('created_at', now()->year)->get();

            $view = view('branches.schedules', compact('schedules', 'branchCourses'));
        } else {
            $schedules = Schedule::whereYear('created_at', now()->year)->get();

            $view = view('schedules.index', compact('schedules'));
        }

        return $view;
    }

    public function show(Schedule $schedule, Request $request)
    {
        $view = null;
        $branch = $request->branch;

        if ($request->has('branch')) {
            $view = view('branches.schedules-show', compact('schedule', 'branch'));
        } else {
            $view = view('schedules.show', compact('schedule', 'branch'));
        }

        return $view;
    }

    public function store(Request $request)
    {
        $newBranchScheduleData = $request->validate([
            'branch_id' => 'required',
            'course_id' => 'required',
            'branch_course_id' => 'required',
            'month' => 'required',
            'year' => 'required',
            'day_part' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'capacity' => 'required',
            'discount' => 'required',
            'added_by' => 'required',
        ]);

        $newBranchScheduleData['discount'] = str_replace('%', '', $newBranchScheduleData['discount']) / 100;

        try {
            $schedule = Schedule::create(array_except($newBranchScheduleData, ['day_part', 'capacity', 'start_date', 'end_date']));

            $batch = new Batch();
            $batch_number = Batch::whereHas('schedule', function ($query) use ($request) {
                                        $query->where('course_id', $request->course_id);
                                    })
                                ->where('day_part', $request->day_part)
                                ->whereDate('start_date', $request->start_date)
                                ->whereYear('created_at', now()->year)->get()->count() + 1;

            $batch->number = $batch_number;
            $batch->schedule_id = $schedule->id;
            $batch->day_part = $request->day_part;
            $batch->start_date = $request->start_date;
            $batch->end_date = $request->end_date;
            $batch->capacity = $request->capacity;
            $batch->save();
        } catch (QueryException $queryException) {
            $error = $queryException->errorInfo[1];

            /*
              $error data structure
              0 : "23000"
              1 : 1062
              2 : "Duplicate entry '1-12' for key 'schedules_branch_course_id_month_unique'"
            */

            switch ($error) {
                case 1062 :
                    $request->session()->flash('info', [
                        'title' => 'Schedule Not Created!',
                        'type' => 'error',
                        'text' => 'You are trying to create a duplicate schedule, please check your data',
                        'confirmButtonColor' => '#DD6B55',
                        'confirmButtonText' => 'I WILL CHECK IT',
                    ]);
                    break;
                default :
                    $request->session()->flash('info', [
                        'title' => 'Schedule Not Created!',
                        'type' => 'error',
                        'text' => 'An error has occurred, please try adding it again',
                        'confirmButtonColor' => '#DD6B55',
                        'confirmButtonText' => 'OH! LET ME TRY AGAIN',
                    ]);
            }

            return back()->withInput();
        }

        return back();
    }

    public function update(Schedule $schedule, Request $request)
    {
        $oldDiscount = $schedule->discount;

        $oldScheduleData = [
            'month' => $schedule->month,
            'year' => $schedule->year,
        ];

        $oldBatchData = [
            'day_part' => $schedule->batch->day_part,
            'start_date' => $schedule->batch->start_date,
            'end_date' => $schedule->batch->end_date,
            'capacity' => $schedule->batch->capacity,
        ];

        if ($request->has('discount')) {
            $request->validate([
               'discount' => 'required',
               'updated_by' => 'required',
               'schedule_id' => 'required',
               'remarks' => 'required|min:10',
            ]);

            $schedule->discount = str_replace('%', '', $request->discount) / 100;
            $schedule->status = 'updated discount';
            $schedule->save();
        } elseif ($request->has('month')) {
            $request->validate([
                'month' => 'required_if:year,' . null,
                'year' => 'required_if:month,' . null . '|min:' . now()->year . '|max:2028|numeric',
                'day_part' => 'required',
                'start_date' => 'required',
                'end_date' => 'required',
                'capacity' => 'required',
                'updated_by' => 'required',
                'schedule_id' => 'required',
                'remarks' => 'required|min:10',
            ]);

            $schedule->month = $request->month? $request->month : $schedule->month;
            $schedule->year = $request->year? $request->year : $schedule->year;
            $schedule->status = 'updated training schedule';
            $schedule->save();

            $batch = $schedule->batch;
            $batch->day_part = $request->day_part? $request->day_part : $batch->day_part;
            $batch->start_date = $request->start_date? $request->start_date : $batch->start_date;
            $batch->end_date = $request->end_date? $request->end_date : $batch->end_date;
            $batch->capacity = $request->capacity? $request->capacity : $batch->capacity;
            $batch->save();
        } else {
            return back();
        }

        HistoryDetail::create([
            'schedule_id' => $schedule->id,
            'updated_by' => admin()->id,
            'remarks' => $request->remarks,
            'log' => "month:" . $oldScheduleData['month'] .
                        "|year:" . $oldScheduleData['year'] . "|discount:" . toPercentage($oldDiscount) .
                        "|day_part:" . $oldBatchData['day_part'] . "|capacity:" . $oldBatchData['capacity'],
        ]);

        return back();
    }

    public function close(Schedule $schedule, Request $request)
    {
        $request->validate([
            'remarks' => 'required',
        ]);

        HistoryDetail::create([
            'schedule_id' => $schedule->id,
            'updated_by' => admin()->id,
            'remarks' => $request->remarks,
            'log' => "Training schedule has been closed. Please refer to remarks",
        ]);

        $schedule->status = 'closed';
        $schedule->save();

        $params = str_contains(url()->previous(), 'branch')? "?branch={$schedule->branch->name}":'/';

        return redirect(prefixedUrl() .'/schedules'. $params);
    }

    public function reOpen(Schedule $schedule, Request $request)
    {
        $request->validate([
            'remarks' => 'required',
        ]);

        $reservationsCount = optional($schedule->reservations)->count();

        if ($reservationsCount < $schedule->batch->capacity and Carbon::parse($schedule->batch->start_date)->gte(now()->startOfDay())) {
            HistoryDetail::create([
                'schedule_id' => $schedule->id,
                'updated_by' => admin()->id,
                'remarks' => $request->remarks,
                'log' => "Training schedule has been re-opened. Please refer to remarks",
            ]);

            $schedule->status = 're-opened';
            $schedule->save();
        } elseif ($reservationsCount == $schedule->batch->capacity) {
            $request->session()->flash('info', [
                'title' => 'Schedule Impossible To Re-Open!',
                'type' => 'error',
                'text' => 'Schedule capacity has been reached!',
                'confirmButtonColor' => '#DD6B55',
                'confirmButtonText' => 'CONTINUE',
            ]);
        } elseif (Carbon::parse($schedule->batch->start_date)->lte(now()->startOfDay())) {
            $request->session()->flash('info', [
                'title' => 'Schedule Impossible To Re-Open!',
                'type' => 'error',
                'text' => 'Schedule has already been started!',
                'confirmButtonColor' => '#DD6B55',
                'confirmButtonText' => 'CONTINUE',
            ]);
        }

        $params = str_contains(url()->previous(), 'branch')? "?branch={$schedule->branch->name}":'/';

        return redirect(prefixedUrl() .'/schedules'. $params);
    }

    public function destroy(Schedule $schedule, Request $request)
    {
        $request->validate([
            'remarks' => 'required',
        ]);

        if($schedule->hasReservations()) {
            HistoryDetail::create([
                'schedule_id' => $schedule->id,
                'updated_by' => admin()->id,
                'remarks' => $request->remarks,
                'log' => "tried to delete schedule",
            ]);

            $request->session()->flash('info', [
                'title' => 'Fatal Error!',
                'type' => 'error',
                'text' => 'Schedule cannot be deleted! Please move any reservations/cor number attached to it, and try again.',
                'confirmButtonColor' => '#DD6B55',
                'confirmButtonText' => 'CONTINUE',
            ]);

            return back();
        } else {
            HistoryDetail::create([
                'schedule_id' => $schedule->id,
                'updated_by' => admin()->id,
                'remarks' => $request->remarks,
                'log' => "deleted schedule",
            ]);

            $schedule->status = 'deleted';
            $schedule->save();
            $schedule->delete();
        }

        $params = str_contains(url()->previous(), 'branch')? "?branch={$schedule->branch->name}":'/';

        return redirect(prefixedUrl() .'/schedules'. $params);
    }

    public function moveTrainee(Schedule $schedule, Request $request)
    {
        $request->validate([
            'move' => 'required',
            'batch_id' => 'required',
            'remarks' => 'required|min:10'
        ],
        [
            'move.required' => 'To continue, please select cor# or reservation code that needs to be moved.'
        ]);

        $newBatch = Batch::find($request->batch_id);

        if (str_contains($schedule->batch->cor_numbers, $request->move)) {
            $batch = $schedule->batch;
            $oldCorNumbers = explode(',', $batch->cor_numbers);
            $updatedCorNumbers = array_where($oldCorNumbers, function ($value, $key) use ($request) {
                return ($value != $request->move);
            });

            if ($newBatch->hasCorNumber($request->move)) {
                $request->session()->flash('info', [
                    'title' => 'Impossible request',
                    'type' => 'error',
                    'text' => 'COR# already exists on the target batch.',
                    'confirmButtonColor' => '#DD6B55',
                    'confirmButtonText' => 'CONTINUE',
                ]);
            } else {
                $newBatch->addCorNumber($request->move);
                $batch->cor_numbers = implode(',', $updatedCorNumbers);
                $batch->save();

                HistoryDetail::create([
                    'schedule_id' => $schedule->id,
                    'updated_by' => admin()->id,
                    'remarks' => $request->remarks,
                    'log' => 'Moved ' . $request->move . ' from ' . $batch->schedule->monthName()
                                .' '. \Carbon\Carbon::parse($batch->start_date)->day
                                .' - '. \Carbon\Carbon::parse($batch->end_date)->day
                                .', '. $batch->schedule->year .': Batch '.  $batch->number
                                .' - '. strtoupper($batch->day_part) . ' to ' . $newBatch->schedule->monthName()
                                .' '. \Carbon\Carbon::parse($newBatch->start_date)->day
                                .' - '. \Carbon\Carbon::parse($newBatch->end_date)->day
                                .', '. $newBatch->schedule->year .': Batch '.  $newBatch->number
                                .' - '. strtoupper($newBatch->day_part),
                ]);
            }
        } elseif ($schedule->hasReservationCode($request->move)) {
            $reservation = Reservation::where('code', $request->move)->first();
            $reservation->schedule_id = $newBatch->schedule_id;
            $reservation->save();
        } else {
            $request->session()->flash('info', [
                'title' => 'Fatal Error!',
                'type' => 'error',
                'text' => 'The system have received a non-existent trainee identifier. Try refreshing the page before moving trainee to a new batch',
                'confirmButtonColor' => '#DD6B55',
                'confirmButtonText' => 'CONTINUE',
            ]);
        }

        // check if request->move is in the batch->cor_numbers of current schedule if found remove it
        // else query reservation via request->move if found update its schedule id to new id via queried batch
        // else return back show error
        return back();
    }
}
