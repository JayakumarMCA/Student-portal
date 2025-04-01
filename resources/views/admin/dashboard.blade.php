@extends('admin.layouts.master')

@php
    $page_title = 'Techdata || Dashboard';
    $page_name = 'Techdata || Dashboard';
@endphp

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Dashboard</h4>

                        <!-- <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Layouts</a></li>
                                        <li class="breadcrumb-item active">Topbar Light</li>
                                    </ol>
                                </div> -->
                    </div>
                </div>
            </div>
            <!-- end page title -->
            @can('dashboard-view')
                <div class="row">
                    <div class="col-sm-6 col-lg-4">
                        <div class="card text-center">
                            <div class="card-body">
                                <h4 class="card-title text-muted">Total Users</h4>
                                <h2 class="mt-3 mb-2"><i class="mdi mdi-account-group-outline text-success me-2"></i><b>{{ $getUser ?? '' }}</b></h2>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-lg-4">
                        <div class="card text-center">
                            <div class="card-body p-t-10">
                                <h4 class="card-title text-muted mb-0">Total Assets in portal</h4>
                                <h2 class="mt-3 mb-2"><i class="mdi mdi-database-edit-outline text-success me-2"></i><b>{{ $getAsset ?? '' }}</b></h2>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-lg-4">
                        <div class="card text-center">
                            <div class="card-body p-t-10">
                                <h4 class="card-title text-muted mb-0">Total Events in portal</h4>
                                <h2 class="mt-3 mb-2"><i class="mdi mdi-chart-bell-curve text-success me-2"></i><b>{{ $getEvent ?? '' }}</b></h2>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- end row -->

                <div class="row">

                    <!-- <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="mt-0 card-title">Utilization</h4>
                                <div class="morris-charts" id="morris-donut-example" style="height: 300px;"></div>
                            </div>
                        </div>
                    </div> -->

                    <!-- <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="mt-0 card-title">Industry</h4>
                                <div id="morris-bar-example" style="height: 300px;"></div>
                            </div>
                        </div>
                    </div> -->
                    <div class="col-lg-6">
                                <div class="card">
                                    <div class="card-body">
        
                                        <h4 class="card-title mb-4">Bar Chart</h4>

                                        <div class="row text-center">
                                            <div class="col-4">
                                                <h5 class="mb-0">2541</h5>
                                                <p class="text-muted text-truncate">Activated</p>
                                            </div>
                                            <div class="col-4">
                                                <h5 class="mb-0">84845</h5>
                                                <p class="text-muted text-truncate">Pending</p>
                                            </div>
                                            <div class="col-4">
                                                <h5 class="mb-0">12001</h5>
                                                <p class="text-muted text-truncate">Deactivated</p>
                                            </div>
                                        </div>
        
                                        <canvas id="bar" height="300"></canvas>
        
                                    </div>
                                </div>
                            </div>
                    <div class="col-lg-4">
                        <div class="card card-h-90">
                            <div class="card-body">
                                <h4 class="mb-4 mt-0 card-title">Leader Board: </h4>
                                <p class="font-600 mb-1">Partner User 1 <span
                                        class="text-primary float-end"><b>100</b></span></p>
                                <div class="progress  mb-3">
                                    <div class="progress-bar progress-bar-primary " role="progressbar"
                                        aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"
                                        style="width: 100%;">
                                    </div><!-- /.progress-bar .progress-bar-danger -->
                                </div><!-- /.progress .no-rounded -->
                                <p class="font-600 mb-1">Partner User 2 <span
                                        class="text-primary float-end"><b>80</b></span></p>
                                <div class="progress  mb-3">
                                    <div class="progress-bar progress-bar-primary " role="progressbar"
                                        aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"
                                        style="width: 80%;">
                                    </div><!-- /.progress-bar .progress-bar-pink -->
                                </div><!-- /.progress .no-rounded -->
                                <p class="font-600 mb-1">Partner User 3 <span
                                        class="text-primary float-end"><b>70</b></span></p>
                                <div class="progress  mb-3">
                                    <div class="progress-bar progress-bar-primary " role="progressbar"
                                        aria-valuenow="70" aria-valuemin="0" aria-valuemax="100"
                                        style="width: 70%;">
                                    </div><!-- /.progress-bar .progress-bar-info -->
                                </div><!-- /.progress .no-rounded -->
                                <p class="font-600 mb-1">Partner User 4 <span
                                        class="text-primary float-end"><b>69</b></span></p>
                                <div class="progress  mb-3">
                                    <div class="progress-bar progress-bar-primary " role="progressbar"
                                        aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"
                                        style="width: 69%;">
                                    </div><!-- /.progress-bar .progress-bar-warning -->
                                </div><!-- /.progress .no-rounded -->
                                <p class="font-600 mb-1">Partner User 5 <span
                                        class="text-primary float-end"><b>50</b></span></p>
                                <div class="progress  mb-3">
                                    <div class="progress-bar progress-bar-primary " role="progressbar"
                                        aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"
                                        style="width: 50%;">
                                    </div><!-- /.progress-bar .progress-bar-warning -->
                                </div><!-- /.progress .no-rounded -->
                                <!-- <p class="font-600 mb-1"> Daily Visits<span
                                        class="text-primary float-end"><b>40%</b></span></p>
                                <div class="progress  mb-0">
                                    <div class="progress-bar progress-bar-primary " role="progressbar"
                                        aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"
                                        style="width: 40%;">
                                    </div>
                                </div> -->
                            </div>
                        </div>
                    </div>
                </div>
            @endcan
        </div>
    </div>
    <!-- End Page-content -->
@endsection
