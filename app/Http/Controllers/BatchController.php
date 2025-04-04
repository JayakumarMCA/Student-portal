<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use App\Models\CourseMaster;
use App\Http\Requests\StoreBatchRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class BatchController extends Controller
{
    public function index()
    {
        $query = Batch::with('course');
        if (isset($request->search)) {
            if (isset($request->name)) {
                $name = $request->name;
                $name = trim($request->name, '"');
                $query->where('batches.name', 'like', '%' . $name . '%');
            }
            if (isset($request->course_id)) {
                $course_id = $request->course_id;
                $course_id = $request->course_id;
                $query->where('batches.course_id',$course_id);
            }
        }
        $batches=$query->get();
        $courses = CourseMaster::pluck('title', 'id');
        return view('admin.batches.index', compact('batches','courses'));
    }

    public function create()
    {
        $courses = CourseMaster::pluck('title', 'id');
        return view('admin.batches.create', compact('courses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:course_masters,id',
            'name' => 'required|string|max:255',
            'from_date' => 'required|date',
            'to_date' =>'required|date|after_or_equal:from_date',
        ]);
        $fromDate = Carbon::parse($request->input('from_date'));
        $toDate = Carbon::parse($request->input('to_date'));
        if (!$toDate->equalTo($fromDate->copy()->addMonths(6))) {
            return redirect()->back()
                ->withErrors(['to_date' => 'The To Date must be within six months of the From Date.'])->withInput();
        }
        Batch::create($request->all());
        return redirect()->route('batches.index')->with('success', 'Batch created successfully.');
    }

    public function edit(Batch $batch)
    {
        $courses = CourseMaster::pluck('title', 'id');
        return view('admin.batches.edit', compact('batch', 'courses'));
    }

    public function update(Request $request, Batch $batch)
    {
        $request->validate([
            'course_id' => 'required|exists:course_masters,id',
            'name' => 'required|string|max:255',
            'from_date' => 'required|date',
            'to_date' => 'required|date|after_or_equal:from_date',
        ]);
        $batch->update($request->all());
        return redirect()->route('batches.index')->with('success', 'Batch updated successfully.');
    }

    public function destroy(Batch $batch)
    {
        $batch->delete();
        return redirect()->route('batches.index')->with('success', 'Batch deleted successfully.');
    }
}

