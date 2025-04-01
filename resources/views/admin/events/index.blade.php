@extends('admin.layouts.master')
@section('css')
    <!-- Responsive Table css -->
    <link href="{{asset ('assets/libs/admin-resources/rwd-table/rwd-table.min.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
<div class="page-content mainpage-content">
    <div class="container-fluid mt-5">
        <div class="row">
            <div class="col-xl-12 col-12">
                <div class="card">
                    <div class="card-body">
                        <form class="custom-validation">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Title</label>
                                        <input type="text" class="form-control" name="title" value="{{ $request->title }}" placeholder="Enter Title" />
                                    </div>
                                </div>
                                <!-- Date -->
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Date</label>
                                        <input type="date" class="form-control" name="date" value="{{ $request->date }}" >
                                    </div>
                                </div>

                                <!-- Time -->
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Time</label>
                                        <input type="time" class="form-control" name="time" value="{{ $request->time }}" >
                                    </div>
                                </div>

                                <!-- Location -->
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Location</label>
                                        <input type="text" class="form-control" name="location" value="{{ $request->location }}" placeholder="Enter Location" >
                                    </div>
                                </div>
                                 <!-- Country -->
                                 <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Country</label>
                                        <select name="country_id" class="form-control" >
                                            <option value="">Select Country</option>
                                            @foreach($countries as $country)
                                                <option value="{{ $country->id }}" {{$request->country_id == $country->id ? 'selected' : '' }}>
                                                    {{ $country->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <!-- Language -->
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Language</label>
                                        <select name="language_id" class="form-control" >
                                            <option value="">Select Country</option>
                                            @foreach($languages as $language)
                                                <option value="{{ $language->id }}" {{ $request->language_id == $language->id ? 'selected' : '' }}>
                                                    {{ $language->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <button class="btn btn-primary" type="submit" value="submit">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- end card -->


            </div>
        </div>     
        <div class="row">
            <div class="col-xl-12 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <h4 class="card-title">Events List</h4>
                            </div>
                            @can('event-edit')
                                <div class="col-md-4 text-end">
                                    <a href="{{ route('events.create') }}" class="btn btn-primary text-end">Add New Event</a>
                                </div>
                            @endcan
                        </div>
                        <div class="table-rep-plugin mt-3">
                            <div class="table-responsive mb-0" data-pattern="priority-columns">
                                <table id="tech-companies-1" class="table">
                                    <thead>
                                        <tr>
                                            <th data-priority="1">#</th>
                                            <th data-priority="1">Title</th>
                                            <th data-priority="1">Image</th>
                                            <th data-priority="1">Date</th>
                                            <th data-priority="1">Time</th>
                                            <th data-priority="1">Location</th>
                                            <th data-priority="1">Country</th>
                                            <th data-priority="1">Language</th>
                                            <th data-priority="1">Status</th>
                                            <th data-priority="1">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($events as $key => $event)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $event->title }}</td>
                                                <td>
                                                    @if($event->image)
                                                        <img src="{{ asset('storage/' . $event->image) }}" width="50" height="50" alt="Event Image">
                                                    @else
                                                        No Image
                                                    @endif
                                                </td>

                                                <td>{{ $event->date }}</td>
                                                <td>{{ $event->time }}</td>
                                                <td>{{ $event->location }}</td>
                                                <td>{{ $event->country->name }}</td>
                                                <td>{{ $event->language->name }}</td>
                                                <td>{{ $event->status ? 'Active' : 'Inactive' }}</td>
                                                <td>
                                                    @can('event-edit')
                                                        <a href="{{ route('events.edit', $event->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                                    @endcan
                                                    <!-- <form action="{{ route('events.destroy', $event->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                                                    </form> -->
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
 <!-- Responsive Table js -->
 <script src="assets/libs/admin-resources/rwd-table/rwd-table.min.js"></script>

<!-- Init js -->
<script src="assets/js/pages/table-responsive.init.js"></script>
@endsection