@extends('admin.layouts.master')

@section('css')
    <link href="{{ asset('assets/libs/admin-resources/rwd-table/rwd-table.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
<div class="page-content mainpage-content">
    <div class="container-fluid mt-5">
        
        <!-- Search Filter -->
        <div class="row">
            <div class="col-xl-12 col-12">
                <div class="card">
                    <div class="card-body">
                        <form class="custom-validation">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Name</label>
                                        <input type="text" class="form-control" name="name" value="{{ request('name') }}" />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="course_id" class="form-label">Course</label>
                                        <select id="course_id" name="course_id" class="form-control" required>
                                            <option value="">Select Course</option>
                                            @foreach($courses as $id => $title)
                                                <option value="{{ $id }}" {{ old('course_id') == $id ? 'selected' : '' }}>{{ $title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <button class="btn btn-primary" type="submit" name="search" value="search">Search</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Course List -->
        <div class="row">
            <div class="col-xl-12 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <h4 class="card-title">Course Master</h4>
                            </div>
                            <div class="col-md-4 text-end">
                                <a href="{{ route('batches.create') }}" class="btn btn-primary">Add New Course</a>
                            </div>
                        </div>

                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        <div class="table-rep-plugin mt-3">
                            <div class="table-responsive mb-0" data-pattern="priority-columns">
                            <table id="course-table" class="table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Course</th>
                                        <th>Name</th>
                                        <th>From Date</th>
                                        <th>To Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($batches as $batch)
                                        <tr>
                                            <td>{{ $batch->id }}</td>
                                            <td>{{ $batch->course->title }}</td>
                                            <td>{{ $batch->name }}</td>
                                            <td>{{ \Carbon\Carbon::parse($batch->from_date)->format('d-m-Y') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($batch->to_date)->format('d-m-Y') }}</td>
                                            <td>
                                                <a href="{{ route('batches.edit', $batch->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                                <form action="{{ route('batches.destroy', $batch->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>
@endsection

@section('js')
    <script src="{{ asset('assets/libs/admin-resources/rwd-table/rwd-table.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/table-responsive.init.js') }}"></script>
@endsection
