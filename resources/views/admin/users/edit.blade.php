@extends('admin.layouts.master')

@section('content')
<div class="page-content mainpage-content">
    <div class="container-fluid mt-5">
        <div class="row">
            <div class="col-xl-12 col-12">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title fs-4">Edit Student</h3>
                        <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
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
                                            <input type="{{ $field === 'email' ? 'email' : 'text' }}" name="{{ $field }}" class="form-control" value="{{ old($field, $user->$field) }}" placeholder="{{ $label }}" required>
                                            @error($field) <span class="text-danger">{{ $message }}</span> @enderror
                                        </div>
                                    @endforeach

                                    <div class="form-group mb-3">
                                        <label>DOB</label>
                                        <input type="date" name="dob" class="form-control" value="{{ old('dob', $user->dob) }}" required>
                                        @error('dob') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="form-group mb-3">
                                        <label>Graduate</label>
                                        <select name="graduate" class="form-select" required>
                                            <option disabled selected>Graduate</option>
                                            <option value="1"{{ old('graduate', $user->graduate) == 1 ? 'selected' : '' }}>UG</option>
                                            <option value="2"{{ old('graduate', $user->graduate) == 2 ? 'selected' : '' }}>PG</option>
                                        </select>
                                        @error('graduate') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="form-group mb-3">
                                        <label>Year of Passing</label>
                                        <input type="text" name="year_of_passing" class="form-control" value="{{ old('year_of_passing', $user->year_of_passing) }}" required>
                                        @error('year_of_passing') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="form-group mb-3">
                                        <label>Role</label>
                                        <select class="form-control" name="role_id" required>
                                            <option value="">Select Role</option>
                                            @foreach ($roles as $role)
                                                <option value="{{ $role->id }}" {{ $user->role_id == $role->id ? 'selected' : '' }}>
                                                    {{ $role->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('role_id') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="form-group mb-3">
                                        <label>Status</label>
                                        <select class="form-control" name="status" required>
                                            <option value="">Select Status</option>
                                            @foreach ([
                                                1 => 'Pending',
                                                2 => 'Approval',
                                                3 => 'Course Completed',
                                                4 => 'Test Completed',
                                            ] as $value => $label)
                                                <option value="{{ $value }}" {{ $user->status == $value ? 'selected' : '' }}>
                                                    {{ $label }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('status') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label>WhatsApp?</label>
                                        <select name="whatsapp_num" class="form-select" required>
                                            <option disabled selected>WhatsApp?</option>
                                            <option value="1"{{ old('whatsapp_num', $user->whatsapp_num) == 1 ? 'selected' : '' }}>Yes</option>
                                            <option value="2"{{ old('whatsapp_num', $user->whatsapp_num) == 2 ? 'selected' : '' }}>No</option>
                                        </select>
                                        @error('whatsapp_num') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="form-group mb-3">
                                        <label>Course</label>
                                        <select id="course_id" name="course_id" class="form-control" required>
                                            <option value="">Select Course</option>
                                            @foreach($courses as $id => $title)
                                                <option value="{{ $id }}" {{ old('course_id', $user->course_id) == $id ? 'selected' : '' }}>{{ $title }}</option>
                                            @endforeach
                                        </select>
                                        @error('course_id') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="form-group mb-3">
                                        <label>Batch</label>
                                        <select id="batch_id" name="batch_id" class="form-control" required>
                                            <option value="">Select Batch</option>
                                            @foreach($batches as $id => $name)
                                                <option value="{{ $id }}" {{ old('batch_id', $user->batch_id) == $id ? 'selected' : '' }}>{{ $name }}</option>
                                            @endforeach
                                        </select>
                                        @error('batch_id') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="form-group mb-3">
                                        <label>NRI</label>
                                        <select name="nri" class="form-select" required>
                                            <option disabled selected>NRI?</option>
                                            <option value="1" {{ old('nri', $user->nri) == 1 ? 'selected' : '' }}>Yes</option>
                                            <option value="2" {{ old('nri', $user->nri) == 2 ? 'selected' : '' }}>No</option>
                                        </select>
                                        @error('nri') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>

                                    @foreach ([
                                        'passport_photo_copy' => 'Passport Photo Copy (if NRI)',
                                        'photo_copy' => 'Photo Copy',
                                        'doc' => 'Document (10th, 12th, UG)',
                                        'id_proof_photo_copy' => 'ID Proof Photo Copy',
                                    ] as $fileField => $label)
                                    @php
                                        $filePath = $user->$fileField ? asset('storage/' . $user->$fileField) : null;
                                        $isPassport = $fileField === 'passport_photo_copy';
                                    @endphp
                                        <div class="form-group mb-3 {{ $fileField === 'passport_photo_copy' ? 'passport-field' : '' }}" style="{{ ($fileField === 'passport_photo_copy' && $user->nri != 1) ? 'display: none;' : '' }}">
                                            <label>{{ $label }}</label>
                                            <input type="file" name="{{ $fileField }}" class="form-control">
                                            @error($fileField) <span class="text-danger">{{ $message }}</span> @enderror
                                        </div>
                                        @if ($filePath)
                                            <div class="mt-2">
                                                <strong>Existing File:</strong><br>
                                                @if(Str::endsWith($filePath, ['jpg', 'jpeg', 'png']))
                                                    <img src="{{ $filePath }}" alt="{{ $label }}" style="max-height: 100px;">
                                                @else
                                                    <a href="{{ $filePath }}" target="_blank">View {{ $label }}</a>
                                                @endif
                                            </div>
                                        @endif
                                    @endforeach
                                </div>

                                <div class="form-group mb-3">
                                    <label>Address</label>
                                    <textarea class="form-control textarea" name="address" rows="5" placeholder="Enter The Address..">{{ old('address', $user->address) }}</textarea>
                                    @error('address') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <button class="btn btn-primary" type="submit">Update Stuent</button>
                        </form>
                    </div>
                </div>
            </div>
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
        function togglePassport() {
            if ($('select[name="nri"]').val() == '1') {
                $('.passport-field').show();
            } else {
                $('.passport-field').hide();
            }
        }

        $('select[name="nri"]').on('change', togglePassport);
        togglePassport(); // initial call
    });
</script>
@endsection
