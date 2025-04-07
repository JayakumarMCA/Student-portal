<h4 class="mb-0 f-21 pl-3 pt-2 font-weight-normal text-capitalize border-top-grey">
    @lang('Options')
</h4>
<div class="row pl-20 pb-2" id="dynamic_rows">
    @if (isset($careeranswers) && !empty($careeranswers))
        @php
            $rowCount = 0;
        @endphp
        @foreach ($careeranswers as $options)
            @php
                $rowCount++;
            @endphp
            <div class="col-sm-11 row" id="optionRow_{{ $rowCount }}">
                <div class="col-sm-9">
                    <div class="form-group my-3">
                        <label for="option_text_label_{{ $rowCount }}" class="your-label-class"> Option{{ $rowCount }} </label>
                        <textarea name="option[{{ $rowCount }}]" id="option_{{ $rowCount }}-text" class="d-none">{{ strip_tags($options->option_text) }}</textarea>
                        <input type="text" name="option[{{ $rowCount }}]" id="option_{{ $rowCount }}" value="{{ strip_tags($options->option_text) }}" class="form-control"/>
                        <input type="radio" id="is_correct_{{ $rowCount }}" name="is_correct" value="{{ $rowCount }}" @if($options->is_correct == 1) checked @endif>
                        <label for="is_correct_{{ $rowCount }}" class="your-label-class">
                            {{ __('CorrectAnswer') }}
                        </label>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        @php
            $rowCount = 2;
        @endphp
        <div class="col-sm-12 row">
            <div class="col-md-9 ">
                <div class="form-group my-3">
                    <label for="option_text_label_1" class="your-label-class">
                        {{ __('Option 1') }}
                    </label>
                    <textarea name="option[1]" id="option_1-text" class="d-none"></textarea>
                    <input type="text" name="option[1]" id="option_1"  class="form-control"/>
                    <input type="radio" id="is_correct_1" name="is_correct" value="1">
                    <label for="is_correct_1" class="your-label-class">{{ __('CorrectAnswer') }}</label>
                </div>
            </div>
            
        </div>
        <div class="col-sm-12 row">
            <div class="col-md-9 ">
                <div class="form-group my-3 flex">
                    <label for="option_text_label_2" class="your-label-class">{{ __('Option 2') }}</label>
                    <textarea name="option[2]" id="option_2-text" class="d-none"></textarea>
                    <input type="text" name="option[2]" id="option_2" class="form-control" />
                    <input type="radio" id="is_correct_2" name="is_correct" value="2">
                    <label for="is_correct_2" class="your-label-class">
                        {{ __('CorrectAnswer') }}
                    </label>
                </div>
            </div>
            
        </div>
    @endif
</div>
<div class="row pl-20 pb-2">
    <div class="col-md-12">
        <a class="f-15 f-w-500" href="javascript:;" id="add-more-row"><i
                class="icons icon-plus font-weight-bold mr-1"></i>@lang('AddMore')</a>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    
    $(document).ready(function() {
        
    var optCount = parseInt("{{ $rowCount }}"); // Parse the value as an integer

    for (var k = 1; k <= optCount; k++) {
        if (k === optCount) {
            var rmButton = '<div class="col-sm-1 pt-5" id="rmButton_' + k + '">' +
                '<a href="javascript:removeRow(' + k +
                ')" class="d-flex align-items-center justify-content-center ml-3">' +
                '<i class="fa fa-times-circle f-20 text-lightest"></i></a>' +
                '</div>';
            $(rmButton).insertAfter($('#optionRow_' + k));
        }
    }

    $(document).on('click', '#add-more-row', function() {
        var i = $('#option_count').val();
        i++;
        let url = "{{ route('mcq/questions/mcq-option-html', ':count') }}";
        url = url.replace(':count', i);

        var rmButton = '<div class="col-sm-1 pt-5" id="rmButton_' + i + '">' +
            '<a href="javascript:removeRow(' + i +
            ')" class="d-flex align-items-center justify-content-center ml-3">' +
            '<i class="fa fa-times-circle f-20 text-lightest"></i></a>' +
            '</div>';

        var lastEle = i - 1;

        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
            success: function(res) {
                $('#dynamic_rows').append(res.html);
                if (lastEle > 2) {
                    $('#rmButton_' + lastEle).remove();
                }
                $(rmButton).insertAfter($('#optionRow_' + i));
                $('#option_count').val(i);
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', status, error);
            }
        });
    });

    init(RIGHT_MODAL);
});

function removeRow(rowNo) {
    $('#optionRow_' + rowNo + '').remove();
    $('#rmButton_' + rowNo + '').remove();
    var i = rowNo - 1;
    $('#option_count').val(i);
    if (i > 2) {
        var rmButton = '<div class="col-sm-1 pt-5" id="rmButton_' + i + '">' +
            '<a href="javascript:removeRow(' + i +
            ')" class="d-flex align-items-center justify-content-center ml-3">' +
            '<i class="fa fa-times-circle f-20 text-lightest"></i></a>' +
            '</div>';
        $(rmButton).insertAfter($('#optionRow_' + i));
    }
}

</script>

