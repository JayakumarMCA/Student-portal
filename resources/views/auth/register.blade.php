@extends('auth.layouts.master')

@php
    $page_title = 'Register';
    $page_name = 'Register';
@endphp

@section('css')
<style>
    .wrapper-margin {
        margin: 2% auto !important;
    }
</style>
@endsection

@section('content')
<body class="auth-body-bg loginbg">
    <div class="accountbg"></div>
    <div class="wrapper-page login-wrapper wrapper-margin">
        <h1 class="text-center mt-0 text-white fs-1 mb-3">
            <img class="d-block m-auto mb-2" src="{{ asset('assets/images/st.png') }}" /> 
            <b>Student Registration</b> 
            <img class="d-block m-auto mt-2" src="{{ asset('assets/images/st.png') }}" />
        </h1>
        <div class="card">
            <div class="card-body">
                <h4 class="text-center text-color"><b>Sign Up</b></h4>
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" class="form-horizontal mt-3">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            @foreach ([
                                'name' => 'Name',
                                'email' => 'Email',
                                'mobile' => 'Mobile',
                                'father_name' => "Father's Name",
                                'mother_name' => "Mother's Name",
                            ] as $field => $label)
                            <div class="form-group mb-3">
                                <label>{{ $label }}</label>
                                <input type="{{ $field === 'email' ? 'email' : 'text' }}" name="{{ $field }}" class="form-control" value="{{ old($field) }}" placeholder="{{ $label }}" required>
                                @error($field) <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            @endforeach

                            <!-- Date of Birth -->
                            <div class="form-group mb-3">
                                <label>DOB</label>
                                <input type="date" name="dob" class="form-control" value="{{ old('dob') }}" placeholder="DOB" required>
                                @error('dob') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            
                            <!-- Graduate -->
                            <div class="form-group mb-3">
                                <label>Graduate</label>
                                <select name="graduate" class="form-select" required>
                                    <option disabled selected>Graduate</option>
                                    <option value="1"{{ old('graduate')==1 ? 'selected' : '' }}>UG</option>
                                    <option value="2"{{ old('graduate')==2 ? 'selected' : '' }}>PG</option>
                                </select>
                                @error('graduate') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <!-- Year of Passing -->
                            <div class="form-group mb-3">
                                <label>Year of Passing (10th/12th/UG)</label>
                                <input type="text" name="year_of_passing" class="form-control" placeholder="Year of Passing (10th/12th/UG)" value="{{ old('year_of_passing') }}" required>
                                @error('year_of_passing') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <!-- WhatsApp -->
                            <div class="form-group mb-3">
                                <label>WhatsApp?</label>
                                <select name="whatsapp_num" class="form-select" required>
                                    <option disabled selected>WhatsApp?</option>
                                    <option value="1"{{ old('whatsapp_num')==1 ? 'selected' : '' }}>Yes</option>
                                    <option value="2"{{ old('whatsapp_num')==2 ? 'selected' : '' }}>No</option>
                                </select>
                                @error('whatsapp_num') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <!-- Course -->
                            <div class="form-group mb-3">
                                <label>Course</label>
                                <select id="course_id" name="course_id" class="form-control" required>
                                    <option value="">Select Course</option>
                                    @foreach($courses as $id => $title)
                                        <option value="{{ $id }}" {{ old('course_id', $batch->course_id ?? '') == $id ? 'selected' : '' }}>{{ $title }}</option>
                                    @endforeach
                                </select>
                                @error('course_id') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <!-- Batch -->
                            <div class="form-group mb-3">
                                <label>Batch</label>
                                <select id="batch_id" name="batch_id" class="form-control" required>
                                    <option value="">Select Batch</option>
                                </select>
                                @error('batch_id') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            
                            <!-- NRI -->
                            <div class="form-group mb-3">
                                <label>NRI</label>
                                <select name="nri" class="form-select" required>
                                    <option disabled selected>NRI?</option>
                                    <option value="1">Yes</option>
                                    <option value="2">No</option>
                                </select>
                                @error('nri') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <!-- File Uploads -->
                            @foreach ([
                                'passport_photo_copy' => 'Passport Photo Copy (if NRI)',
                                'photo_copy' => 'Photo Copy',
                                'doc' => 'Document (10th, 12th, UG)',
                                'id_proof_photo_copy' => 'ID Proof Photo Copy',
                            ] as $fileField => $label)
                                <div class="form-group mb-3 {{ $fileField === 'passport_photo_copy' ? 'passport-field' : '' }}" style="{{ $fileField === 'passport_photo_copy' ? 'display: none;' : '' }}">
                                    <label>{{ $label }}</label>
                                    <input
                                        type="file"
                                        name="{{ $fileField }}"
                                        class="form-control"
                                        {{ str_contains($fileField, 'passport') ? '' : 'required' }}
                                    >
                                    @error($fileField) <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            @endforeach
                        </div>
                        <div class="form-group mb-3">
                            <label>Address</label>
                            <textarea class="form-control textarea" name="address" id="address" rows="5" placeholder="Enter The Address..">{{old('Address')}}</textarea>
                            @error('Address') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="form-group text-center mt-4">
                        <button type="submit" class="btn btn-primary btn-block btn-lg waves-effect waves-light w-50">Register</button>
                    </div>

                    <div class="form-group mt-3 mb-0 text-center">
                        <a href="/" class="">Already have an account?</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('js')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $('#course_id').on('change', function () {
        var courseId = $(this).val();
        if (courseId) {
            $.ajax({
                url: '{{ url("get-batches") }}/' + courseId,
                type: 'GET',
                dataType: 'json',
                success: function (data) {
                    $('#batch_id').empty().append('<option value="">Select Batch</option>');
                    $.each(data, function (key, value) {
                        $('#batch_id').append('<option value="' + key + '">' + value + '</option>');
                    });
                }
            });
        } else {
            $('#batch_id').html('<option value="">Select Batch</option>');
        }
    });
    $(document).ready(function () {
        $('select[name="nri"]').on('change', function () {
            if ($(this).val() == '1') {
                $('.passport-field').show();
            } else {
                $('.passport-field').hide();
            }
        });

        // If old input exists (after validation fails)
        @if (old('nri') == 1)
            $('.passport-field').show();
        @endif
    });
</script>
@endsection
