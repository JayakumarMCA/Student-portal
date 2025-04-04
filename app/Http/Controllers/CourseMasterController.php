<?php
namespace App\Http\Controllers;

use App\Models\CourseMaster;
use Illuminate\Http\Request;

class CourseMasterController extends Controller
{
    public function index(Request $request)
    {
        // $courses = CourseMaster::all();
        $query = CourseMaster::orderBy('id','ASC');
        if (isset($request->search)) {
            if (isset($request->title)) {
                $title = $request->title;
                $title = trim($request->title, '"');
                $query->where('course_masters.title', 'like', '%' . $title . '%');
            }
            if (isset($request->type)) {
                $type = $request->type;
                $type = trim($request->type, '"');
                $query->where('course_masters.type',$type);
            }
        }
        $courses=$query->get();
        return view('admin.course_master.index', compact('courses'));
    }

    public function create()
    {
        return view('admin.course_master.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:1,2',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'duration' => 'required|string|max:100',
            'status' => 'required|boolean',
        ]);

        CourseMaster::create($request->all());

        return redirect()->route('course_master.index')->with('success', 'Course created successfully.');
    }

    public function edit(CourseMaster $courseMaster)
    {
        return view('admin.course_master.edit', compact('courseMaster'));
    }

    public function update(Request $request, CourseMaster $course)
    {
        $request->validate([
            'type' => 'required|in:1,2',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'duration' => 'required|string|max:100',
            'status' => 'required|boolean',
        ]);

        $course->update($request->all());

        return redirect()->route('course_master.index')->with('success', 'Course updated successfully.');
    }

    public function destroy(CourseMaster $course)
    {
        $course->delete();
        return redirect()->route('course_master.index')->with('success', 'Course deleted.');
    }
}

