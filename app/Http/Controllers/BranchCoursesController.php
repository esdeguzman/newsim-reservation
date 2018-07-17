<?php

namespace App\Http\Controllers;

use App\Branch;
use App\BranchCourse;
use App\Course;
use App\OriginalPrice;
use Illuminate\Http\Request;

class BranchCoursesController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'can.access']);
    }

    public function index(Request $request)
    {
        if ($request->has('filter')) {
            $branchCourses = BranchCourse::all();
            $courses = Course::all();

            return view('branch-courses.index', compact('branchCourses', 'courses'));
        } elseif ($request->has('branch')) {
            $branchCoursesIds = BranchCourse::whereHas('branch', function ($query) use ($request) {
                                    $query->where('name', $request->branch);
                                })->select('course_id')->get();

            $courses = Course::all();

            if ($branchCoursesIds->count() > 0) {
                $courses = Course::whereNotIn('id', $branchCoursesIds)->get();
            }

            $branch = Branch::where('name', $request->branch)->first();

            $branchCourses = BranchCourse::where('branch_id', $branch->id)->get()->sortByDesc('created_at');

            return view('branch-courses.index', compact('branchCourses', 'courses', 'branch'));
        }
    }

    public function show(BranchCourse $branchCourse, Request $request)
    {
        $originalPrice = null;
        $originalPrice = OriginalPrice::where('branch_course_id', $branchCourse->id)->first();

        return view('branch-courses.show', compact('branchCourse', 'originalPrice'));
    }

    public function store(Request $request)
    {
        $newBranchCourseDetails = $request->validate([
            'course_id' => 'required',
            'branch_id' => 'required',
        ]);

        $newBranchCourseDetails['added_by'] = auth()->user()->id;

        BranchCourse::create($newBranchCourseDetails);

        return back();
    }

    public function destroy(BranchCourse $branchCourse, Request $request)
    {
        $remarks = $request->validate([
            'remarks' => 'required|min:10'
        ]);

        $branchCourse->deleted_by = auth()->user()->id;
        $branchCourse->remarks = $request->remarks;
        $branchCourse->save();

        $branchCourse->delete();

        return redirect()->route('branch-courses.index', [
            'branch' => $branchCourse->branch->name
        ]);
    }
}
