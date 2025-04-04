@extends('admin.layouts.master')

@section('css')
    <!-- Include any additional CSS files here -->
@endsection

@section('content')
<div class="page-content mainpage-content">
    <div class="container-fluid mt-5">
        
        <!-- Search Filter -->
        <div class="row">
            <div class="col-xl-12 col-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('questions.index') }}" method="GET">
                            <div class="row">
                                <!-- Question Text Search -->
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Question</label>
                                        <input type="text" class="form-control" name="question" value="{{ request('question') }}" placeholder="Search by question text" />
                                    </div>
                                </div>
                                <!-- Course Filter -->
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="course_id" class="form-label">Course</label>
                                        <select id="course_id" name="course_id" class="form-control">
                                            <option value="">All Courses</option>
                                            @foreach($courses as $id => $title)
                                                <option value="{{ $id }}" {{ request('course_id') == $id ? 'selected' : '' }}>{{ $title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <!-- Date Range Filter -->
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Date Range</label>
                                        <div class="d-flex">
                                            <input type="date" class="form-control me-2" name="from_date" value="{{ request('from_date') }}" placeholder="From Date" />
                                            <input type="date" class="form-control" name="to_date" value="{{ request('to_date') }}" placeholder="To Date" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <button class="btn btn-primary" type="submit">Search</button>
                                <a href="{{ route('questions.index') }}" class="btn btn-secondary">Reset</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Questions List -->
        <div class="row">
            <div class="col-xl-12 col-12">
                <div class="card">
                    <div class="card-body">
                        <!-- Header Section -->
                        <div class="row mb-3">
                            <div class="col-md-8">
                                <h4 class="card-title">Questions</h4>
                            </div>
                            <div class="col-md-4 text-end">
                                <a href="{{ route('questions.create') }}" class="btn btn-primary">Add New Question</a>
                            </div>
                        </div>

                        <!-- Success Message -->
                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        <!-- Questions Table -->
                        <div class="table-responsive">
                            <table class="table table-centered mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Course</th>
                                        <th>Question</th>
                                        <th>Created At</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($questions as $question)
                                        <tr>
                                            <td>{{ $question->id }}</td>
                                            <td>{{ $question->course->title ?? 'N/A' }}</td>
                                            <td>{{ $question->text }}</td>
                                            <td>{{ $question->created_at->format('d-m-Y') }}</td>
                                            <td>
                                                <a href="{{ route('questions.edit', $question->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                                <form action="{{ route('questions.destroy', $question->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">No questions found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>
@endsection

@section('js')
    <!-- Include any additional JS files here -->
@endsection
