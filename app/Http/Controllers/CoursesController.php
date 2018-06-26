<?php

namespace App\Http\Controllers;

use App\BranchCourse;
use App\Course;
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
        if (auth()->user()->isDev()) {
            $courses = Course::all();

            return view('courses.index', compact('courses'));
        }
    }

    public function show(Course $course, Request $request)
    {
        return view('courses.show', compact('course'));
    }

    public function store(Request $request)
    {
        $newCourseData = $request->validate([
            'code' => 'required|min:2',
            'description' => 'required|min:5',
        ]);

        // add user id of admin who added this course
        $newCourseData['added_by'] = auth()->user()->id;

        try {
            Course::create($newCourseData);
        } catch (QueryException $queryException) {
            if ($queryException->errorInfo[1] == 1062) {
                $request->session()->flash('info', [
                    'title' => 'Impossible Request',
                    'type' => 'error',
                    'text' => 'You are trying to make a duplicate course, please review your course code or course details.',
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

        // create a copy of course with the remarks from administrator
        $courseRevisedCopy = Course::create([
            'course_id' => $course->id,
            'code' => $course->code,
            'description' => $course->description,
            'added_by' => auth()->user()->administrator->id,
        ]);

        // create history details
        HistoryDetail::create([
            'course_id' => $courseRevisedCopy->id,
            'updated_by' => auth()->user()->administrator->id,
            'remarks' => $request->remarks,
        ]);

        // soft delete the copy to make it a history item
        $courseRevisedCopy->delete();

        // finally, update the course to the updated values from administrator
        $course->code = strtolower($request->code);
        $course->description = strtolower($request->description);
        $course->save();

         // redirect_path depends on the page where the update request has been initiated
        return redirect($request->redirect_path);
    }

    public function destroy(Course $course, Request $request)
    {
        $remarks = $request->validate([
            'remarks' => 'required|min:10'
        ]);

        $course->deleted_by = auth()->user()->id;
        $course->remarks = $request->remarks;
        $course->save();

        $course->delete();

        return redirect()->route('courses.index');
    }
}
