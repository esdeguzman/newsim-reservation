<?php

namespace App\Http\Controllers;

use App\BranchCourse;
use App\HistoryDetail;
use App\Schedule;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SchedulesController extends Controller
{
    public function index(Request $request)
    {
        $view = null;
        if ($request->has('branch')) {
            $schedules = Schedule::whereHas('branch', function ($query) use ($request) {
                $query->where('name', $request->branch);
            })->get();

            $branchCourses = BranchCourse::with('originalPrice')->whereHas('branch', function ($query) use ($request) {
                $query->where('name', $request->branch);
            })->whereHas('originalPrice')->get();

            $view = view('branches.schedules', compact('schedules', 'branchCourses'));
        } else {
            $schedules = Schedule::all();

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
            'discount' => 'required',
            'added_by' => 'required',
        ]);

        $newBranchScheduleData['discount'] = str_replace('%', '', $newBranchScheduleData['discount']) / 100;

        try {
            Schedule::create($newBranchScheduleData);
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
        } elseif ($request->has('month') || $request->has('year')) {
            $request->validate([
                'month' => 'required_if:year,' . null,
                'year' => 'required_if:month,' . null,
                'updated_by' => 'required',
                'schedule_id' => 'required',
                'remarks' => 'required|min:10',
            ]);

            $schedule->month = $request->month? $request->month : $schedule->month;
            $schedule->year = $request->year? $request->year : $schedule->year;
            $schedule->status = 'updated training schedule';
            $schedule->save();
        } else {
            return back();
        }

        $scheduleOldCopy = Schedule::create([
            'schedule_id' => $schedule->id,
            'branch_id' => $schedule->branch_id,
            'branch_course_id' => $schedule->branch_course_id,
            'month' => $oldScheduleData['month'],
            'year' => $oldScheduleData['year'],
            'status' => $schedule->status,
            'discount' => $oldDiscount,
            'added_by' => auth()->user()->administrator->id,
        ]);

        $historyDetails = $this->createHistory($request, [
            'key' => 'schedule_id',
            'value' => $scheduleOldCopy->id
        ]);

        $scheduleOldCopy->delete();

        return back();
    }

    public function destroy(Schedule $schedule, Request $request)
    {
        $request->validate([
            'remarks' => 'required',
            'deleted_by' => 'required',
        ]);

        $schedule->delete();

        $url = url('admin/schedules');
        $params = $request->branch? "?branch={$request->branch}":'';

        return redirect($url . $params);
    }
}
