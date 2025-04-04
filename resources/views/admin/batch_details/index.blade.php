@extends('admin.layouts.master')

@section('css')
    <!-- Add any additional CSS here -->
@endsection

@section('content')
<div class="page-content mainpage-content">
    <div class="container-fluid mt-5">

        <!-- Filter Form -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form method="GET" action="{{ route('batch-details.index') }}">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="batch_id" class="form-label">Batch</label>
                                        <select id="batch_id" name="batch_id" class="form-control @error('batch_id') is-invalid @enderror" required>
                                            <option value="">Select Batch</option>
                                            @foreach($batches as $id => $name)
                                                <option value="{{ $id }}" {{ request('batch_id') == $id ? 'selected' : '' }}>{{ $name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="date" class="form-label">Date</label>
                                        <input type="date" id="date" name="date" class="form-control" value="{{ request('date') }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="start_time" class="form-label">Start Time</label>
                                        <input type="time" id="start_time" name="start_time" class="form-control" value="{{ request('start_time') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 text-end">
                                    <button type="submit" class="btn btn-primary" name="search" value="search">Filter</button>
                                    <a href="{{ route('batch-details.index') }}" class="btn btn-secondary">Reset</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Batch Details List -->
        <div class="row">
            <div class="col-xl-12 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-8">
                                <h4 class="card-title">Batch Details</h4>
                            </div>
                            <div class="col-md-4 text-end">
                                <a href="{{ route('batch-details.create') }}" class="btn btn-primary">Add New Batch Detail</a>
                            </div>
                        </div>

                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        <div class="table-responsive">
                            <table id="course-table" class="table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Batch Name</th>
                                        <th>Link</th>
                                        <th>Date</th>
                                        <th>Start Time</th>
                                        <th>End Time</th>
                                        <th>Video</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($batchDetails as $detail)
                                        <tr>
                                            <td>{{ $detail->id }}</td>
                                            <td>{{ $detail->batch->name }}</td>
                                            <td><a href="{{ $detail->link }}" target="_blank">View Link</a></td>
                                            <td>{{ \Carbon\Carbon::parse($detail->date)->format('d-m-Y') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($detail->start_time)->format('H:i') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($detail->to_time)->format('H:i') }}</td>
                                            <td>
                                                @if($detail->video)
                                                    <a href="{{ $detail->video }}" target="_blank">View Video</a>
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('batch-details.edit', $detail->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                                <form action="{{ route('batch-details.destroy', $detail->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this batch detail?')">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center">No batch details found.</td>
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
    <!-- Add any additional JS here -->
@endsection
