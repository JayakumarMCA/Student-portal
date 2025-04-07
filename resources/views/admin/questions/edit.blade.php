@extends('admin.layouts.master') @php $page_title = 'Edit Question'; $page_name = 'Edit Question'; @endphp @section('content')

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
                        @if(count($errors) > 0) @foreach($errors->all() as $error)
                        <div class="alert alert-danger">{{ $error }}</div>
                        @endforeach @endif
                        <div class="card-body">
                            <h5 class="text-uppercase bg-light p-2 mt-0 mb-3">Question Details</h5>
                            <form action="{{ route('questions.update',$question->id) }}" method="POST" id="courseCategory" class="new-added-form" enctype="multipart/form-data">
                                @csrf @method('PUT')

                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="product-name" class="form-label">Course <span class="text-danger">*</span></label>
                                            <select id="course_id" name="course_id" class="form-control" required>
                                                <option value="">Select Course</option>
                                                @foreach($courses as $id => $title)
                                                    <option value="{{ $id }}" {{ old('course_id', $question->course_id ?? '') == $id ? 'selected' : '' }}>{{ $title }}</option>
                                                @endforeach
                                            </select>
                                            @error('course_id')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="product-name" class="form-label">Question Type <span class="text-danger">*</span></label>
                                            <select class="form-select" name="question_type" id="question_type">
                                                <option value="">Select Question Type</option>
                                                <option value="1" {{ $question->question_type==1 ? 'selected' : '' }}>True Or False</option>
                                                <option value="2" {{ $question->question_type==2 ? 'selected' : '' }}>Multiple choose Question</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="product-name" class="form-label">Question <span class="text-danger">*</span></label>
                                        <textarea class="textarea form-control" name="question" id="question" rows="5" placeholder="Enter The Question..">{{ $question->question_text }}</textarea>
                                    </div>
                                </div>
                                <div id="options">
                                    @php
                                        $rowCount = 0;
                                    @endphp
                                    @if ($question->question_type == 1)
                                        @include('admin.questions.option-types.mcq')
                                    @else
                                        @if (isset($careeranswers) && !empty($careeranswers))
                                            @foreach ($careeranswers as $options)
                                                @php
                                                    $rowCount++;
                                                @endphp
                                                <div class="col-sm-11 row" id="optionRow_{{ $rowCount }}">
                                                    <div class="col-sm-9">
                                                        <div class="form-group my-3">
                                                            <label for="option_text_label_{{ $rowCount }}" class="form-label">
                                                                Option {{$rowCount }}
                                                            </label>
                                                            <input type="text" class="form-control" id="option_{{ $rowCount }}" readonly value="{{ strip_tags($options->option_text) }}">
                                                            <textarea name="option[{{ $rowCount }}]" id="option_{{ $rowCount }}-text" class="d-none">{{ strip_tags($options->option_text) }}</textarea>
                                                            
                                                            <label for="is_correct_{{ $rowCount }}" class="form-check-label">
                                                                <input type="radio" id="is_correct_{{ $rowCount }}" name="is_correct" value="{{ $rowCount }}" {{ $options->is_correct == 1 ? 'checked' : '' }}>
                                                                correctAnswer
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                    @endif
                                </div>
                                <input type="hidden" id="option_count" name="option_count" value="{{ count($careeranswers) }}" />
                                <div class="row">
                                    <div class="col-12">
                                        <div class="text-center mb-3">
                                            <button type="submit" class="btn w-sm btn-success waves-effect waves-light">Save</button>
                                            <a href="{{ route('questions.index') }}"><button type="button" class="btn w-sm btn-danger waves-effect waves-light">Cancel</button></a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection @section('js')
<script>
    $('#question_type').change(function(e) {
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
