@extends('admin.layouts.master')

@section('content')
<div class="page-content mainpage-content">
    <div class="container-fluid mt-5">
        <div class="row">
            <div class="col-xl-12 col-12">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title fs-4">{{ isset($batch) ? 'Edit Batch' : 'Add Batch' }}</h3>

                        <form action="{{ isset($batch) ? route('batches.update', $batch->id) : route('batches.store') }}" method="POST">
                            @csrf
                            @isset($batch)
                                @method('PUT')
                            @endisset
                            <div class="row">
                                <!-- Course Selection -->
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="course_id" class="form-label">Course</label>
                                        <select id="course_id" name="course_id" class="form-control" required>
                                            <option value="">Select Course</option>
                                            @foreach($courses as $id => $title)
                                                <option value="{{ $id }}" {{ old('course_id', $batch->course_id ?? '') == $id ? 'selected' : '' }}>{{ $title }}</option>
                                            @endforeach
                                        </select>
                                        @error('course_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <!-- Batch Name -->
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Batch Name</label>
                                        <input id="name" type="text" class="form-control" name="name" value="{{ old('name', $batch->name ?? '') }}" required>
                                        @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <!-- From Date -->
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="from_date" class="form-label">From Date</label>
                                        <input id="from_date" type="date" class="form-control" name="from_date" value="{{ old('from_date', $batch->from_date ?? '') }}" required>
                                        @error('from_date')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <!-- To Date -->
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="to_date" class="form-label">To Date</label>
                                        <input id="to_date" type="date" class="form-control" name="to_date" value="{{ old('to_date', $batch->to_date ?? '') }}" required>
                                        @error('to_date')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">{{ isset($batch) ? 'Update Batch' : 'Create Batch' }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
