{{ Form::model($searchCoachForm->model(),  [
           'class' => '',
           'url'=> $searchCoachForm->action(),
           'autocomplete' => 'off',
           'id' =>'search-availability',
           ]) }}
<div class="row mt-2">
    <div class="col-12 col-md-4">
        <label class="fw-bold d-block">Date</label>
        <div class="input-group">
            {{Form::text("dateSession", null, [  'class' => 'form-control input-datepicker '.($errors->has('dateSession') ? ' is-invalid ' : ''),
                                                'id' => 'dateSession',
                                                'disabled' => true])}}
            <span class="input-group-text icon-calendar"><i class="fa fa-calendar"></i></span>
            @error('dateSession')
            <span class="custom-invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>

    <div class="col-12 col-md-4">
        @include('common.form-field.select', [  'field' => 'time_id',
                                                'id' => 'timeId',
                                                'form' => $searchCoachForm,
                                                'label' => 'Time',
                                                'optionsField' => 'timeOptions',
                                                'disabled' => true,

                                                'placeholder' => 'Select Time'])
    </div>

    <div class="col-6 col-md-4">
        @include('common.form-field.text', ['field' => 'coach',
                                            'id' => 'coach',
                                            'disabled' => true,
                                            'label' => 'Coach\'s first name (Optional)'])
    </div>

    @if ($isWeek)

        <input type="hidden" name="coaching_week_id" value="" id="coaching-week-id" />
    @endif
</div>

<div class="row mt-4">
    <div class="col-12 text-center">
        <button class="btn bg-corporate-color text-white btn-sm btn-bold px-4" type="submit">
            Search Session
        </button>
    </div>
</div>

{{Form::close()}}

<script>

    $(document).ready(function () {

        $("#search-availability").submit(function(event) {

            if ($('#coaching-week-id').val() == ''){
                event.preventDefault();
                alert('Select week is mandatory');
                return;
            }
            else if ($('#dateSession').val() == ''){
                event.preventDefault();
                alert('Select date is mandatory');
            }
            else if ($('#timeId').val() == ''){
                event.preventDefault();
                alert('Select time is mandatory');
            }
        });

        jQuery(document).on('click', '.coaching-week-option', function (event) {

            var isChecked = jQuery(this).prop('checked')

            if (isChecked){
                jQuery('#coaching-week-id').val(jQuery(this).val())

                $('#dateSession').prop("disabled", false);
                $('#timeId').prop("disabled", false);
                $('#coach').prop("disabled", false);

                var startDate = jQuery(this).data('start-date')
                var endDate = jQuery(this).data('end-date')


                var today = new Date();
                var currentDate = today.toISOString().split('T')[0];

                if (startDate < currentDate) {
                    startDate = currentDate;
                }


                $("#dateSession").datepicker("destroy");

                $("#dateSession").datepicker({
                    defaultDate: "+1w",
                    changeMonth: true,
                    dateFormat: "yy-mm-dd",
                    numberOfMonths: 1,
                    minDate: startDate,
                    maxDate: endDate,
                    firstDay: 1
                });
            }
        });
    });
</script>
