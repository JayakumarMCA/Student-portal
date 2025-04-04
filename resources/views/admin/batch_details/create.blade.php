@extends('admin.layouts.master')

@section('css')
    <!-- Add any additional CSS here -->
@endsection

@section('content')
<div class="page-content mainpage-content">
    <div class="container-fluid mt-5">

        <!-- Add Batch Detail Form -->
        <div class="row">
            <div class="col-xl-12 col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Add New Batch Detail</h4>

                        <form action="{{ route('batch-details.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="batch_id" class="form-label">Batch</label>
                                        <select id="batch_id" name="batch_id" class="form-control @error('batch_id') is-invalid @enderror" required>
                                            <option value="">Select Batch</option>
                                            @foreach($batches as $id => $name)
                                                <option value="{{ $id }}" {{ old('batch_id') == $id ? 'selected' : '' }}>{{ $name }}</option>
                                            @endforeach
                                        </select>
                                        @error('batch_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="link" class="form-label">Link</label>
                                        <input type="url" id="link" name="link" class="form-control @error('link') is-invalid @enderror" value="{{ old('link') }}" required>
                                        @error('link')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="date" class="form-label">Date</label>
                                        <input type="date" id="date" name="date" class="form-control @error('date') is-invalid @enderror" value="{{ old('date') }}" required>
                                        @error('date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="start_time" class="form-label">Start Time</label>
                                        <input type="time" id="start_time" name="start_time" class="form-control @error('start_time') is-invalid @enderror" value="{{ old('start_time') }}" required>
                                        @error('start_time')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="to_time" class="form-label">End Time</label>
                                        <input type="time" id="to_time" name="to_time" class="form-control @error('to_time') is-invalid @enderror" value="{{ old('to_time') }}" required>
                                        @error('to_time')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="video" class="form-label">Video URL</label>
                                        <input type="file" id="video" name="video" class="form-control @error('video') is-invalid @enderror" value="{{ old('video') }}">
                                        @error('video')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="text-end">
                                <button type="submit" class="btn btn-primary">Save</button>
                                <a href="{{ route('batch-details.index') }}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@section('js')
    <!-- Add any additional JS here -->
@endsection
