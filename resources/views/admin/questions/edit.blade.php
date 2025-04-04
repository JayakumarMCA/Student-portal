@extends('layouts.master') @php $page_title = 'Edit Question'; $page_name = 'Edit Question'; @endphp @section('css')
<link rel="stylesheet" href="{{ asset('admin/assets/css/select2.min.css') }}" />
<style>
    .select2-selection__choice {
        background-color: #e31e24 !important;
    }
    .select2-selection__choice__remove {
        color: #121111fc !important;
    }
    .remove {
        display: flex;
        align-items: center;
    }
</style>
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
                                <li class="breadcrumb-item"><a href="{{ route('mcqquestions.index') }}">Back</a></li>
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
                            <form action="{{ route('mcqquestions.update',$career_question->id) }}" method="POST" id="courseCategory" class="new-added-form" enctype="multipart/form-data">
                                @csrf @method('PUT')

                                <div class="row">
                                    <div class="mb-3">
                                            <label for="product-name" class="form-label">Question <span class="text-danger">*</span></label>
                                            <textarea class="textarea form-control" name="question" id="question" rows="5" placeholder="Enter The Question..">{{$career_question->question}}</textarea>
                                            
                                    </div>
                                    <div class="col-lg-6">
                                        
                                        <!-- <div class="mb-3">
                                            <label for="product-name" class="form-label">Level <span class="text-danger">*</span></label>
                                            {!! Form::select('level_id', $career_levels,$career_question->level_id, array('class' => 'form-select','id'=>'level_id')) !!}
                                        </div> -->
                                        <div class="mb-3">
                                            <label for="product-name" class="form-label">Default Score <span class="text-danger">*</span></label>
                                            <input type="text" name="default_score" id="default_score" value="{{$career_question->default_score}}"  class="form-control" placeholder="Default Score" >
                                        </div>
                                        <div class="mb-3">
                                            <label for="product-name" class="form-label">Brand <span class="text-danger">*</span></label>
                                            {!! Form::select('brand_id', $brands,$career_question->brand_id, array('class' => 'form-select','id'=>'brand_id')) !!}
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="product-name" class="form-label">Status<span class="text-danger">*</span></label>
                                            <select name="status" class="form-select" id>
                                                <option value="">-- Select Status--</option>
                                                <option value="1" @if($career_question->status==1) selected @endif>Active</option>
                                                <option value="2" @if($career_question->status==2) selected @endif>InActive</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="product-name" class="form-label">Question Type <span class="text-danger">*</span></label>
                                            {!! Form::select('question_type_id', $question_types,$career_question->question_type_id, array('class' => 'form-select','id'=>'question_type_id','placeholder' => 'Please Select Question Type')) !!}
                                        </div>
                                        <div class="mb-3">
                                            <label for="product-name" class="form-label">Test Template <span class="text-danger">*</span></label>
                                            {!! Form::select('test_template_id', $test_templates,$career_question->test_template_id, array('class' => 'form-select','id'=>'test_template_id','placeholder' => 'Select Test Template')) !!}
                                        </div>
                                        <div class="mb-3">
                                            <label for="product-name" class="form-label">Created By<span class="text-danger">*</span></label>
                                            <input type="text" name="created_by" id="created_by" value="{{ $users[$career_question->created_by] ?? '' }}" class="form-control" readonly />
                                        </div>
                                        
                                    </div>
                                </div>
                                <div id="options">
                                    @php
                                        $rowCount = 0;
                                    @endphp
                                    @if ($career_question->question_type_id == 1)
                                        @include('admin.mcqquestions.option-types.mcq')
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
                                                            <input type="text" class="form-control" id="option_{{ $rowCount }}" readonly value="{{ strip_tags($options->answer_value) }}">
                                                            <textarea name="option[{{ $rowCount }}]" id="option_{{ $rowCount }}-text" class="d-none">{{ strip_tags($options->answer_value) }}</textarea>
                                                            
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
                                            <a href="{{ route('mcqquestions.index') }}"><button type="button" class="btn w-sm btn-danger waves-effect waves-light">Cancel</button></a>
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
<script src="{{ asset('assets/js/jquery.validate.js') }}"></script>
<script src="{{ asset('admin/assets/js/select2.min.js') }}"></script>
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
<script>
    $("#brand_id").change(function(){
         $("#custom_preloader").show();
        var data = { id : $(this).val()};
        var url = '/ajax/get-mcq-stream';
        $.get(url, data, function(response){ 
            var citySelect = $('#stream_id');
            citySelect.empty();
            citySelect.append("<option value=''>Select Stream</option>");
            $.each(response.data, function (index, element) {
               var option = new Option(element, index, false, false);
                citySelect.append(option);
            });
        });
      })
$("#enquiryCreation").validate({
            rules: {
                question        : "required",
                default_score   : "required",
                question_type_id: "required",
                stream_id       : "required",
                level_id        : "required"
            },
            messages: {
                question        : "Please Enter Question",
                default_score   : "Please Enter Score",
                question_type_id: "Please Select Question Type",
                stream_id       : "Please Select Category",
                level_id        : "Please Select Level"
            },
        });
</script>
<script>
    $("#myselect2").select2({
        width: "100%",
        placeholder: "Select an Option",
        allowClear: true,
    });
</script>
@include('admin.shared.tinyMCEFront') @endsection
