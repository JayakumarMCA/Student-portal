@extends('admin.layouts.master') @php $page_title = 'Create New Question'; $page_name = 'Create New Question'; @endphp @section('css')
@endsection @section('content')

<div class="content-page">
    <div class="content">
        <!-- Start Content-->
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('questions.index') }}">Back</a></li>
                                <li class="breadcrumb-item active">Add Question</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Add Question</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        @if(Session::has('message'))
                        <p>{{ Session::get('message') }}</p>
                        @endif @if ($message = Session::get('success'))
                        <div class="alert alert-success" role="alert">
                            {{ $message }}
                        </div>
                        @endif @if ($message = Session::get('error'))
                        <div class="alert alert-danger">
                            {{ $message }}
                        </div>
                        @endif @if (count($errors) > 0)
                        <div class="rounded-md flex items-center px-5 py-4 mb-2 bg-theme-6 text-white">
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                        <div class="card-body">
                            <h5 class="text-uppercase bg-light p-2 mt-0 mb-3">Question Details</h5>
                            {!! Form::open(array('route' => 'questions.store','method'=>'POST', 'id' => 'enquiryCreation','enctype'=>'multipart/form-data')) !!}
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="product-name" class="form-label">Course <span class="text-danger">*</span></label>
                                        <select id="course_id" name="course_id" class="form-control" required>
                                            <option value="">Select Course</option>
                                            @foreach($courses as $id => $title)
                                                <option value="{{ $id }}" {{ old('course_id', $batch->course_id ?? '') == $id ? 'selected' : '' }}>{{ $title }}</option>
                                            @endforeach
                                        </select>
                                        @error('course_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="product-name" class="form-label">Question For<span class="text-danger">*</span></label>
                                        <select class="form-select" name="question_type" id="question_type_id">
                                            <option value="">Select Question Type</option>
                                            <option value="1">True Or False</option>
                                            <option value="2">Multiple choose Question</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="mb-3">
                                        <label for="product-name" class="form-label">Question <span class="text-danger">*</span></label>
                                        <textarea class="form-control textarea" name="question" id="question" rows="5" placeholder="Enter The Question..">{{old('question')}}</textarea>
                                </div>
                                <div id="options"></div>
                                <input type="hidden" id="option_count" name="option_count" value="2" />
                            </div>
                        </div>
                    </div>
                    
                </div>
                <!-- end card -->
            </div>
            <!-- end col -->
        </div>
        <!-- end row -->
        <div class="row mb-5">
            <div class="col-12">
                <div class="text-center mb-3">
                    <button type="submit" class="btn w-sm btn-success waves-effect waves-light">Save</button>
                    <a href="{{ route('questions.index') }}"><button type="button" class="btn w-sm btn-danger waves-effect waves-light">Cancel</button></a>
                </div>
            </div>
            <!-- end col -->
        </div>
        {{ Form::close() }}

        <!-- end row -->
    </div>
    <!-- container -->
</div>
<!-- content -->

@endsection @section('js')
<script>
  $('#question_type_id').change(function(e) {
    let questionTypeId = $(this).val();

    var url = "{{ route('get_options', ':id') }}";
    url = url.replace(':id', questionTypeId);

    $.ajax({
        url: url,
        type: 'GET',
        success: function(res) {
            $('#options').html(res.html);
        },
        error: function(xhr, status, error) {
            // Handle errors here
            console.error(xhr.responseText);
        }
    });
});
</script>
@endsection