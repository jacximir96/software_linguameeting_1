@include('common.form_message_errors')

{{ Form::model($searchCoachForm->model(),  [
   'class' => '',
   'url'=> $searchCoachForm->action(),
   'autocomplete' => 'off',
   'id' =>'search-coach-form',

]) }}

<div class="row">

    <div class="col-6 col-md-4">
        <label class="fw-bold d-block">Date</label>
        <div class="input-group">
            {{Form::text("dateSession", null, ['class' => 'form-control input-datepicker '.($errors->has('dateSession') ? ' is-invalid ' : ''),'id' => 'dateSession',])}}
            <span class="input-group-text icon-calendar"><i class="fa fa-calendar"></i></span>
            @error('dateSession')
            <span class="custom-invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>

    <div class="col-6 col-md-4">
        @include('common.form-field.select', [  'field' => 'time_id',
                                                'label' => 'Time',
                                                'optionsField' => 'timeOptions',
                                                'placeholder' => 'Select Time'])
    </div>

    <div class="col-6 col-md-4">
        @include('common.form-field.text', ['field' => 'coach', 'label' => 'Coach\'s first name (Optional)'])
    </div>
</div>

<div class="row">
    <div class="mt-4 col-12 text-end">
        <button class="btn bg-corporate-color text-white btn-sm btn-bold px-4" type="submit">
            Search Session
        </button>
    </div>
</div>

{{Form::close()}}

<script>

    $(document).ready(function () {

        $("#dateSession").datepicker("destroy");

        $("#dateSession").datepicker({
            defaultDate: "+1w",
            changeMonth: true,
            dateFormat: "yy-mm-dd",
            numberOfMonths: 1,
            minDate: '{{$startDate->toDateString()}}',
            maxDate: '{{$endDate->toDateString()}}',
            firstDay: 1
        });

        $('#dateSession').prop("disabled", false);
        $('#timeId').prop("disabled", false);
        $('#coach').prop("disabled", false);
    });

</script>
