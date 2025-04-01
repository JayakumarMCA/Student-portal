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
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Industry</label>
                                        <select class="form-control" name="industry_id" id="industry_select" >
                                            <option value="">Select Industry</option>
                                            @foreach ($industries as $industry)
                                                <option value="{{ $industry->id }}" {{$request->industry_id == $industry->id ? 'selected' : '' }}>
                                                    {{ $industry->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Product</label>
                                        <select class="form-control" name="product_id" >
                                            <option value="">Select Product</option>
                                            @foreach ($products as $product)
                                                <option value="{{ $product->id }}" {{$request->product_id == $product->id ? 'selected' : '' }}>
                                                    {{ $product->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Asset Type</label>
                                        <select class="form-control" id="asset_type_select" name="asset_type_id" >
                                            <option value="">Select Asset Type</option>
                                            @foreach ($assetTypes as $assetType)
                                                <option value="{{ $assetType->id }}" data-types="{{ $assetType->type }}" {{ $request->asset_type_id == $assetType->id ? 'selected' : '' }}>
                                                    {{ $assetType->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Utilization</label>
                                        <select class="form-control @error('utilization_id') is-invalid @enderror" name="utilization_id" >
                                            <option value="">Select Utilization</option>
                                            @foreach ($utilizations as $utilization)
                                                <option value="{{ $utilization->id }}" {{ $request->utilization_id == $utilization->id ? 'selected' : '' }}>
                                                    {{ $utilization->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Language</label>
                                        <select class="form-control" name="language_id" >
                                            <option value="">Select Language</option>
                                            @foreach ($languages as $language)
                                                <option value="{{ $language->id }}" {{ $request->language_id == $language->id ? 'selected' : '' }}>
                                                    {{ $language->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Country</label>
                                        <select class="form-control" name="country_id" >
                                            <option value="">Select Country</option>
                                            @foreach ($countries as $country)
                                                <option value="{{ $country->id }}" {{ $request->country_id == $country->id ? 'selected' : '' }}>
                                                    {{ $country->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <button class="btn btn-primary" type="submit" name="search" value="submit">Submit</button>
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
                                <h4 class="card-title">Assets List</h4>
                            </div>
                            @can('asset-create')
                                <div class="col-md-4 text-end">
                                    <a href="{{ route('assetdatas.create') }}" class="btn btn-primary text-end">Add New Asset</a>
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
                                            <th data-priority="1">File</th>
                                            <th data-priority="1">Industry</th>
                                            <th data-priority="1">Product</th>
                                            <th data-priority="1">Asset Type</th>
                                            <th data-priority="1">Utilization</th>
                                            <th data-priority="1">Language</th>
                                            <th data-priority="1">Country</th>
                                            <th data-priority="1">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($assets as $key => $asset)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $asset->title }}</td>
                                                <td>
                                                    <a href="{{ asset('storage/' . $asset->file) }}" target="_blank">View File</a>
                                                </td>
                                                <td>{{ $asset->industry->name ?? 'N/A' }}</td>
                                                <td>{{ $asset->product->name ?? 'N/A' }}</td>
                                                <td>{{ $asset->assetType->name ?? 'N/A' }}</td>
                                                <td>{{ $asset->utilization->name ?? 'N/A' }}</td>
                                                <td>{{ $asset->language->name ?? 'N/A' }}</td>
                                                <td>{{ $asset->country->name ?? 'N/A' }}</td>
                                                <td>
                                                    @can('asset-edit')
                                                        <a href="{{ route('assetdatas.edit', $asset->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                                    @endcan
                                                    @can('asset-delete')
                                                        <form action="{{ route('assetdatas.destroy', $asset->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                                        </form>
                                                    @endcan
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
 <script src="{{ asset('assets/libs/admin-resources/rwd-table/rwd-table.min.js')}}"></script>

<!-- Init js -->
<script src="{{ asset('assets/js/pages/table-responsive.init.js')}}"></script>
@endsection