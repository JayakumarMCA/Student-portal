@extends('admin.layouts.master')
@php
    $page_title = 'Techdata || Asset';
    $page_name = 'Techdata || Asset';
@endphp
@section('css')
<style>
    .app-search .form-control {
        border-radius: 0px !important;
    }
</style>
@endsection
@section('content')
<div class="page-content mainpage-content mb-5">
    <img class="img-fluid w-100" style="margin-top: 10px;" src="{{ asset('assets/images/techbanner.png')}}" />

    <div class="container-fluid mt-5 maincontpad">
        <div class="row">
            <!-- Filter Bar -->
            <div class="col-12 col-lg-3">
                <!-- Filter Wrapper -->
                <div class="filter-container">
                    <button class="topcustombtn btn btn-primary d-md-none waves-effect waves-light" data-bs-toggle="offcanvas" data-bs-target="#filterDrawer">
                        Open Filters <i class="ri-filter-2-line align-middle ms-1"></i>
                    </button>

                    <!-- Filters -->
                    <div class="filters" id="filters">
                        <!-- Industry Filter -->
                        <div class="mb-2 filterborder pb-4">
                            <label class="fw-bold">Industry</label>
                            @foreach($industries as $id => $industry)
                                <div class="form-check d-flex gap-2 align-items-center">
                                    <input class="form-check-input filter-option" type="checkbox" data-filter="industry" value="{{$industry->id}}" />
                                    <label class="form-check-label ratinglabel">{{$industry->name}}</label>
                                </div>
                            @endforeach
                        </div>
                        <!-- Product Filter -->
                        <div class="mb-2 filterborder pb-4">
                            <label class="fw-bold">Product</label>
                            @foreach($products as $product)
                                <div class="form-check d-flex gap-2 align-items-center">
                                    <input class="form-check-input filter-option" type="checkbox" data-filter="product" value="{{ $product->id ?? ''}}" />
                                    <label class="form-check-label ratinglabel">{{ $product->name ?? ''}}</label>
                                </div>
                            @endforeach
                        </div>

                        <!-- Asset Type Filter -->
                        <div class="mb-2 filterborder pb-4">
                            <label class="fw-bold">Asset Type</label>
                            @foreach($assetTypes as $assettype)
                                <div class="form-check d-flex gap-2 align-items-center">
                                    <input class="form-check-input filter-option" type="checkbox" data-filter="asset_type" value="{{ $assettype->id ?? '' }}" />
                                    <label class="form-check-label ratinglabel">{{ $assettype->name ?? '' }}</label>
                                </div>
                            @endforeach
                        </div>

                        <!-- Utilization Filter -->
                        <div class="mb-2 filterborder pb-4">
                            <label class="fw-bold">Utilization</label>
                            @foreach($utilizations as $utilization)
                                <div class="form-check d-flex gap-2 align-items-center">
                                    <input class="form-check-input filter-option" type="checkbox" data-filter="utilization" value="{{ $utilization->id ?? '' }}" />
                                    <label class="form-check-label ratinglabel">{{ $utilization->name ?? '' }}</label>
                                </div>
                            @endforeach
                        </div>

                        <!-- Language Filter -->
                        <div class="mb-2 filterborder pb-4">
                            <label class="fw-bold">Language</label>
                            <select class="form-select" id="language">
                                <option value="">Choose Language</option>
                                @foreach($languages as $language)
                                    <option value="{{$language->id ?? ''}}">{{$language->name ?? ''}}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Country Filter -->
                        <div class="mb-2">
                            <label class="fw-bold">Country</label>
                            <select class="form-select" id="country">
                                <option value="">Select Country</option>
                                @foreach($countries as $county)
                                    <option value="{{ $county->id ?? '' }}">{{ $county->name ?? '' }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Mobile Offcanvas Drawer -->
                <div class="offcanvas offcanvas-start" id="filterDrawer">
                    <div class="offcanvas-header">
                        <h5 class="offcanvas-title">Filters</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
                    </div>
                    <div class="offcanvas-body">
                        <div id="filterPlaceholder"></div>
                    </div>
                </div>
            </div>
            <!-- Filter Bar -->

            <div class="col-12 col-lg-9">
                <!-- Page Title -->
                <div class="row mt-lg-0 mt-4">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h3 class="mb-sm-0">Exclusive Assets for Partners</h3>

                            <form class="app-search d-none d-lg-block w-25">
                                <div class="position-relative">
                                    <input type="text" id="search_event" class="form-control border" placeholder="Search...">
                                    <span class="ri-search-line"></span>
                                </div>
                            </form>
                            
                            <div class="page-title-right">
                                <div class="d-flex gap-3">
                                    <button class="topcustombtn btn btn-primary waves-effect waves-light" id="bulk-download-btn">Download <i class="ri-download-line align-middle ms-1"></i></button>
                                    <button class="topcustombtn btn btn-primary waves-effect waves-light" id="send-email-btn">Email <i class="ri-mail-line align-middle ms-1"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Asset List -->
                <div class="row mb-4" id="asset-list">
                    <!-- Assets will be dynamically loaded here -->
                </div>

                <!-- Pagination -->
                <div id="pagination">
                    <!-- Pagination links will be dynamically loaded here -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
<script>
    $(document).ready(function() {
        function fetchAssets(page = 1) {
            let filters = {
                industry: [],
                product: [],
                asset_type: [],
                utilization: [],
                language: $('#language').val() || "",
                country: $('#country').val() || "",
                page: page,
                search_query: $('#search_event').val().trim()
            };
            $('.filter-option:checked').each(function() {
                let filterName = $(this).data('filter');
                filters[filterName].push($(this).val());
            });
            $.ajax({
                url: "{{ route('fetch.asset') }}",
                method: "GET",
                data: filters,
                beforeSend: function() {
                    $('#asset-list').html('<p class="text-center">Loading assets...</p>');
                },
                success: function(response) {
                    if (!response.data || response.data.length === 0) {
                        $('#asset-list').html('<p class="text-center">No assets found.</p>');
                        $('#pagination').html('');
                        return;
                    }

                    // Render assets
                    let assetsHtml = '';
                    $.each(response.data, function(index, asset) {
                        assetsHtml += `
                            <div class="col-12 col-md-3 col-lg-3 mb-4">
                                <div class="card">
                                    <img class="w-100" src="{{ asset('storage/') }}/${asset.file}" />
                                    <div class="card-body">
                                        <h5 class="card-title">${asset.title}</h5>
                                    </div>
                                    <div class="card-footer">
                                        <div class="form-check d-flex gap-2 align-items-center justify-content-between">
                                            <input class="form-check-input asset-checkbox" type="checkbox" value="${asset.id}" />
                                            <button type="button" class="custombtn download-single" data-file="{{ asset('storage/') }}/${asset.file}" data-id="${asset.id}">Download <i class="ri-download-line align-middle ms-2"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                    });

                    $('#asset-list').html(assetsHtml);
                    $('#pagination').html(response.pagination);
                },
                error: function(xhr) {
                    console.error("AJAX Error:", xhr.responseText);
                    $('#asset-list').html('<p class="text-center text-danger">Failed to load assets.</p>');
                }
            });
        }
        $(document).on('change', '.filter-option, #language, #country', function() {
            fetchAssets();
        });
        $('#search_event').on('input', function() {
            fetchAssets(); // Fetch events on search input
        });
        $(document).on('click', '.download-single', function() {
            let asset_id = $(this).data('id'); 
            let fileUrl = $(this).data('file');
            $.ajax({
                url: "{{ route('fetch.downloadasset') }}",
                method: "POST",
                data: { asset_id: asset_id, _token: "{{ csrf_token() }}" },
                xhrFields: {
                    responseType: 'blob'
                },
                success: function(response) {
                    let blob = new Blob([response], { type: response.type });
                    let link = document.createElement('a');
                    link.href = window.URL.createObjectURL(blob);
                    link.download = fileUrl.split('/').pop();
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                },
                error: function(xhr) {
                    console.error("Single Download Error:", xhr.responseText);
                    alert("Failed to download the file.");
                }
            });
        });
        $('#bulk-download-btn').on('click', function() {
            let selectedAssets = [];
            $('.asset-checkbox:checked').each(function() {
                selectedAssets.push($(this).val());
            });
            if (selectedAssets.length === 0) {
                alert('Please select at least one asset to download.');
                return;
            }
            $.ajax({
                url: "{{ route('bulk.download.asset') }}",
                method: "POST",
                data: { asset_ids: selectedAssets, _token: "{{ csrf_token() }}" },
                xhrFields: {
                    responseType: 'blob'
                },
                success: function(response) {
                    let blob = new Blob([response], { type: 'application/zip' });
                    let link = document.createElement('a');
                    link.href = window.URL.createObjectURL(blob);
                    link.download = 'assets.zip';
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                },
                error: function(xhr) {
                    console.error("Bulk Download Error:", xhr.responseText);
                    alert("Failed to generate bulk download.");
                }
            });
        });
        $(document).on('click', '.pagination a', function(e) {
            e.preventDefault();
            let page = $(this).attr('href').split('page=')[1];
            fetchAssets(page);
        });
        fetchAssets();
        $('#send-email-btn').on('click', function() {
            let selectedAssets = [];
            $('.asset-checkbox:checked').each(function() {
                selectedAssets.push($(this).val());
            });

            if (selectedAssets.length === 0) {
                alert('Please select at least one asset to send via email.');
                return;
            }

            let userEmail = prompt('Enter recipient email:');
            if (!userEmail || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(userEmail)) {
                alert('Please enter a valid email address.');
                return;
            }

            $.ajax({
                url: "{{ route('send.asset.email') }}",
                method: "POST",
                data: {
                    asset_ids: selectedAssets,
                    email: userEmail,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    alert("Email sent successfully with attachments");
                },
                error: function(xhr) {
                    console.error("Email Error:", xhr.responseText);
                    alert("Failed to send email.");
                }
            });
        });
    });
</script>
@endsection