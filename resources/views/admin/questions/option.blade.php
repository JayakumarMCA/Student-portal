<div class="col-sm-11 row" id="optionRow_{{ $rowCount }}">
    <div class="col-md-9">
        <div class="form-group my-3">
        <label for="option_text_{{ $rowCount }}">Option {{$rowCount}} </label>
        <textarea name="option[{{ $rowCount }}]" id="option_{{ $rowCount }}-text" class="d-none"></textarea>
        <input type="text" name="option[{{ $rowCount }}]" id="option_{{ $rowCount }}"  class="form-control" value="{{ $value ?? '' }}"/>
        <!-- <textarea class="textarea form-control" id="option_{{ $rowCount }}" rows="2" placeholder="Enter The Option..">{{ $value ?? '' }}</textarea> -->
            <!-- <div id="option_{{ $rowCount }}">{{ $value ?? '' }}</div> -->
            

            <input type="radio" id="is_correct_{{ $rowCount }}" name="is_correct" value="{{ $rowCount }}">
            <label for="is_correct_{{ $rowCount }}">CorrectAnswer</label>

        </div>
    </div>
    
</div>

<script>
    const RIGHT_MODAL = '#task-detail-1';
    $(document).ready(function() {
        let rowId = "{{ $rowCount }}";
        init(RIGHT_MODAL)
    });
</script>
