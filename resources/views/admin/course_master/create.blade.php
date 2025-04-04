@extends('admin.layouts.master')

@section('content')
<div class="page-content mainpage-content">
    <div class="container-fluid mt-5">
        <div class="row">
            <div class="col-xl-12 col-12">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title fs-4">Add User</h3>

                        <form action="{{ route('course_master.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <!-- Course Type -->
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="type" class="form-label">Course Type</label>
                                        <select id="type" name="type" class="form-control @error('type') is-invalid @enderror" required>
                                            <option value="">Select Type</option>
                                            <option value="1" {{ old('type') == '1' ? 'selected' : '' }}>Undergraduate (UG)</option>
                                            <option value="2" {{ old('type') == '2' ? 'selected' : '' }}>Postgraduate (PG)</option>
                                        </select>
                                        @error('type')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Title -->
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="title" class="form-label">Title</label>
                                        <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" 
                                            name="title" value="{{ old('title') }}" required />
                                        @error('title')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Duration -->
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="duration" class="form-label">Duration</label>
                                        <input id="duration" type="text" class="form-control @error('duration') is-invalid @enderror" 
                                            name="duration" value="{{ old('duration') }}" placeholder="e.g., 3 Years" required />
                                        @error('duration')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Description -->
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="description" class="form-label">Description</label>
                                        <textarea id="description" class="form-control @error('description') is-invalid @enderror" 
                                                name="description" rows="4">{{ old('description') }}</textarea>
                                        @error('description')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Status -->
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="status" class="form-label">Status</label>
                                        <select name="status" class="form-control @error('status') is-invalid @enderror" required>
                                            <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Active</option>
                                            <option value="2" {{ old('status') == '2' ? 'selected' : '' }}>Inactive</option>
                                        </select>
                                        @error('status')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <div class="col-md-12">
                                    <button class="btn btn-primary" type="submit">Add Course</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
