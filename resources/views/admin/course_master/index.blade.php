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
                                        <label class="form-label">Title</label>
                                        <input type="text" class="form-control" name="title" value="{{ request('title') }}" />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Type</label>
                                        <select class="form-control" name="type">
                                            <option value="">Select Type</option>
                                            <option value="1" {{ request('type') == 1 ? 'selected' : '' }}>UG</option>
                                            <option value="2" {{ request('type') == 2 ? 'selected' : '' }}>PG</option>
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
                                <a href="{{ route('course_master.create') }}" class="btn btn-primary">Add New Course</a>
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
                                            <th>#</th>
                                            <th>Title</th>
                                            <th>Type</th>
                                            <th>Duration</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($courses as $key => $course)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $course->title }}</td>
                                                <td>{{ $course->type == 1 ? 'UG' : 'PG' }}</td>
                                                <td>{{ $course->duration }}</td>
                                                <td>
                                                    <span class="badge {{ $course->status==1 ? 'bg-success' : 'bg-danger' }}">
                                                        {{ $course->status==1 ? 'Active' : 'Inactive' }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <a href="{{ route('course_master.edit', $course->id) }}" class="btn btn-sm btn-warning">Edit</a>

                                                    <form action="{{ route('course_master.destroy', $course->id) }}" method="POST" style="display:inline-block;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
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
