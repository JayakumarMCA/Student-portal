@extends('admin.layouts.master')

@section('css')
    <!-- Add any additional CSS here -->
@endsection

@section('content')
<div class="page-content mainpage-content">
    <div class="container-fluid mt-5">

        <!-- Edit Batch Detail Form -->
        <div class="row">
            <div class="col-xl-12 col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Edit Batch Detail</h4>

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('batch-details.update', $batchDetail->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="batch_id" class="form-label">Batch</label>
                                        <select id="batch_id" name="batch_id" class="form-control @error('batch_id') is-invalid @enderror" required>
                                            <option value="">Select Batch</option>
                                            @foreach($batches as $id => $name)
                                                <option value="{{ $id }}" {{ (old('batch_id') ?? $batchDetail->batch_id) == $id ? 'selected' : '' }}>{{ $name }}</option>
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
                                        <input type="url" id="link" name="link" class="form-control @error('link') is-invalid @enderror" value="{{ old('link', $batchDetail->link) }}" required>
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
                                        <input type="date" id="date" name="date" class="form-control @error('date') is-invalid @enderror" value="{{ old('date', optional($batchDetail->date)->format('Y-m-d')) }}" required>
                                        @error('date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="start_time" class="form-label">Start Time</label>
                                        <input type="time" id="start_time" name="start_time" class="form-control @error('start_time') is-invalid @enderror" value="{{ old('start_time',  optional($batchDetail->start_time)->format('H:i')) }}" required>
                                        @error('start_time')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="to_time" class="form-label">End Time</label>
                                        <input type="time" id="to_time" name="to_time" class="form-control @error('to_time') is-invalid @enderror" value="{{ old('to_time',  optional($batchDetail->to_time)->format('H:i')) }}" required>
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
                                        <input type="file" id="video" name="video" class="form-control @error('video') is-invalid @enderror" value="{{ old('video', $batchDetail->video) }}">
                                        @error('video')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="text-end">
                                <button type="submit" class="btn btn-primary">Update</button>
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
