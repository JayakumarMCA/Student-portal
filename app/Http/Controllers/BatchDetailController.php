<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use App\Models\BatchDetail;
use Illuminate\Http\Request;

class BatchDetailController extends Controller
{
    /**
     * Display a listing of the batch details.
     */
    public function index(Request $request)
    {
        $query = BatchDetail::with('batch');
        if (isset($request->search)) {
            if (isset($request->batch_id)) {
                $batch_id = $request->batch_id;
                $query->where('batch_details.batch_id',$batch_id);
            }
            if (isset($request->date)) {
                $date = $request->date;
                $query->where('batch_details.date',$date);
            }
            if (isset($request->start_time)) {
                $start_time = $request->start_time;
                $query->where('batch_details.start_time',$start_time);
            }
        }
        $batchDetails = $query->get();
        $batches = Batch::pluck('name', 'id');
        return view('admin.batch_details.index', compact('batchDetails','batches'));
    }

    /**
     * Show the form for creating a new batch detail.
     */
    public function create()
    {
        $batches = Batch::pluck('name', 'id');
        return view('admin.batch_details.create', compact('batches'));
    }

    /**
     * Store a newly created batch detail in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'batch_id' => 'required|exists:batches,id',
            'link' => 'required|url',
            'date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'to_time' => 'required|date_format:H:i|after:start_time',
            'video' => 'nullable|file|mimes:mp4,avi,mov|max:10240',
        ]);

        if ($request->hasFile('video')) {
            $validated['video'] = $request->file('video')->store('videos', 'public');
        }

        BatchDetail::create($validated);

        return redirect()->route('batch-details.index')->with('success', 'Batch detail added successfully.');
    }

    /**
     * Show the form for editing the specified batch detail.
     */
    public function edit(BatchDetail $batchDetail)
    {
        $batches = Batch::pluck('name', 'id');
        return view('admin.batch_details.edit', compact('batchDetail', 'batches'));
    }

    /**
     * Update the specified batch detail in storage.
     */
    public function update(Request $request, BatchDetail $batchDetail)
    {
        $validated = $request->validate([
            'batch_id' => 'required|exists:batches,id',
            'link' => 'required|url',
            'date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'to_time' => 'required|date_format:H:i|after:start_time',
            'video' => 'nullable|file|mimes:mp4,avi,mov|max:10240',
        ]);

        if ($request->hasFile('video')) {
            $validated['video'] = $request->file('video')->store('videos', 'public');
        }

        $batchDetail->update($validated);

        return redirect()->route('batch-details.index')->with('success', 'Batch detail updated successfully.');
    }

    /**
     * Remove the specified batch detail from storage.
     */
    public function destroy(BatchDetail $batchDetail)
    {
        $batchDetail->delete();
        return redirect()->route('batch-details.index')->with('success', 'Batch detail deleted successfully.');
    }
}

