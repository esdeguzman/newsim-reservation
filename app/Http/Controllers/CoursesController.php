<?php

namespace App\Http\Controllers;

use App\BranchCourse;
use App\Course;
use function App\Helper\admin;
use function App\Helper\user;
use App\HistoryDetail;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class CoursesController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'can.access']);
    }

    public function index(Request $request)
    {
        if (auth()->user()->isDev() or user()->isAdmin()) {
            $courses = Course::withTrashed()->get()->sortBy('status');

            return view('courses.index', compact('courses'));
        }
    }

    public function show($course, Request $request)
    {
        $course = Course::withTrashed()->where('id', $course)->first();
        return view('courses.show', compact('course'));
    }

    public function store(Request $request)
    {
        $newCourseData = $request->validate([
            'code' => 'required|min:2',
            'description' => 'required|min:5',
            'added_by' => 'required',
        ]);

        try {
            Course::create($newCourseData);
        } catch (QueryException $queryException) {
            if ($queryException->errorInfo[1] == 1062) {
                $request->session()->flash('info', [
                    'title' => 'Impossible Request',
                    'type' => 'error',
                    'text' => 'You are trying to make a duplicate course, please review your course code or course' .
                    'details. If your are trying to add a course that has been deleted, you can restore it instead.',
                    'confirmButtonColor' => '#DD6B55',
                    'confirmButtonText' => 'I WILL CHECK IT',
                ]);

                return back()->withInput();
            }
        }

        return redirect()->route('courses.index');
    }

    public function update(Course $course, Request $request)
    {
        $updatedCourseData = $request->validate([
            'code' => 'required|min:2',
            'description' => 'required',
            'remarks' => 'required',
        ]);

        HistoryDetail::create([
            'course_id' => $course->id,
            'updated_by' => auth()->user()->administrator->id,
            'remarks' => $request->remarks,
            'log' => "code:$course->code|description:$course->description",
        ]);

        // finally, update the course to the updated values from administrator
        $course->code = strtolower($request->code);
        $course->description = strtolower($request->description);
        $course->save();

         // redirect_path depends on the page where the update request has been initiated
        return redirect($request->redirect_path);
    }

    public function destroy(Course $course, Request $request)
    {
        $request->validate([
            'remarks' => 'required|min:10'
        ]);

        HistoryDetail::create([
            'course_id' => $course->id,
            'updated_by' => admin()->id,
            'remarks' => $request->remarks,
            'log' => "deleted course",
        ]);

        $course->delete();

        return redirect()->route('courses.index');
    }

    public function restore($course, Request $request)
    {
        $request->validate([
            'remarks' => 'required|min:10'
        ]);

        $course = Course::withTrashed()->where('id', $course)->first();
        $course->deleted_at = null;
        $course->status = 'restored';
        $course->save();

        HistoryDetail::create([
            'course_id' => $course->id,
            'updated_by' => admin()->id,
            'remarks' => $request->remarks,
            'log' => "restored course",
        ]);

        return redirect()->route('courses.show', $course->id);
    }
}
