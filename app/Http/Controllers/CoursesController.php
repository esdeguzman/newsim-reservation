<?php

namespace App\Http\Controllers;

use App\BranchCourse;
use App\Course;
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
        $courseHistory = $course->history();

        return view('courses.show', compact('course', 'courseHistory'));
    }

    public function store(Request $request)
    {
        $newCourseData = $request->validate([
            'code' => 'required|min:2|unique:courses',
            'description' => 'required|unique:courses,description',
        ]);

        // add user id of admin who added this course
        $newCourseData['added_by'] = auth()->user()->id;

        Course::create($newCourseData);

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
            'remarks' => $request->remarks,
            'added_by' => auth()->user()->id,
            'updated_by' => auth()->user()->id,
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
